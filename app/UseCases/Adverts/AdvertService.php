<?php
/**
 * Created by PhpStorm.
 * User: sid
 * Date: 06.06.18
 * Time: 22:38
 */

namespace App\UseCases\Adverts;

use App\Entity\Adverts\Advert\Advert;
use App\Entity\Adverts\Category;
use App\Entity\Region;
use App\Entity\User;
use App\Events\Advert\ModerationPassed;
use App\Http\Requests\Adverts\AttributesRequest;
use App\Http\Requests\Adverts\CreateRequest;
use App\Http\Requests\Adverts\EditRequest;
use App\Http\Requests\Adverts\PhotosRequest;
use App\Http\Requests\Adverts\RejectRequest;
use App\Mail\Auth\AdvertFavoritePrice;
use App\Notifications\Advert\ModerationPassedNotification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class AdvertService
{
    public function create($userId,$categoryId,$regionId, CreateRequest $request): Advert
    {
        /** @var User $user */
        $user = User::findOrFail($userId);
        /** @var Category $category */
        $category = Category::findOrFail($categoryId);
        /** @var Region $region */
        $region = $regionId ? Region::findOrFail($regionId) : null;
        /** @var Advert $advert */
        return DB::transaction(function () use ($request,$user,$category,$region){
            $advert = Advert::make([
                'title' => $request['title'],
                'content' => $request['content'],
                'price' => $request['price'],
                'address' => $request['address'],
                'status' => Advert::STATUS_DRAFT,
            ]);
            $advert->user()->associate($user);
            $advert->category()->associate($category);
            $advert->region()->associate($region);
            $advert->saveOrFail();

            foreach ($category->allAttributes() as $attribute) {
                $value = $request['attribute'][$attribute->id] ?? null;
                if(!empty($value)) {
                    $advert->values()->create([
                        'attribute_id' => $attribute->id,
                        'value' => $value,
                    ]);
                }
            }
            return $advert;
        });
    }

    public function addPhotos($id, PhotosRequest $request)
    {
        $advert = $this->getAdvert($id);

        DB::transaction(function () use ($request, $advert){
            foreach ($request['files'] as $file){
                $advert->photos()->create([
                    'file' =>$file->store('adverts')
                ]);
            }
        });
    }

    public function edit($id, EditRequest $request)
    {
        $advert = $this->getAdvert($id);
        $oldPrice = $advert->price;
        $advert->update($request->only(['title','content','price','address']));
        if($oldPrice !== $advert->price) {
            foreach ($advert->favorites()->cursor() as $user) {
                /** @var User $user */
                Mail::to($user->email)->queue(new AdvertFavoritePrice($user,$advert,$oldPrice));
            }
        }
    }

    /**
     * @param $id
     *
     * @return Advert
     */
    private function getAdvert($id)
    {
        return Advert::findOrFail($id);
    }

    public function moderate($id)
    {
        $advert = $this->getAdvert($id);
        $advert->moderate(Carbon::now());
        event(new ModerationPassed($advert));
    }
    public function sendToModeration($id)
    {
        $advert = $this->getAdvert($id);
        $advert->sendToModeration();
    }

    public function reject($id, RejectRequest $request): void
    {
        $advert = $this->getAdvert($id);
        $advert->reject($request['reason']);
    }
    public function editAttributes($id, AttributesRequest $request): void
    {
        $advert = $this->getAdvert($id);
        DB::transaction(function () use ($request, $advert) {
            $advert->values()->delete();
            foreach ($advert->category->allAttributes() as $attribute) {
                $value = $request['attributes'][$attribute->id] ?? null;
                if (!empty($value)) {
                    $advert->values()->create([
                        'attribute_id' => $attribute->id,
                        'value' => $value,
                    ]);
                }
            }
            //Обновляем таймстамп для updated_at
            $advert->update();
        });
    }
    public function expire(Advert $advert): void
    {
        $advert->expire();
    }
    public function close($id): void
    {
        $advert = $this->getAdvert($id);
        $advert->close();
    }
    public function remove($id): void
    {
        $advert = $this->getAdvert($id);
        $advert->delete();
    }
}
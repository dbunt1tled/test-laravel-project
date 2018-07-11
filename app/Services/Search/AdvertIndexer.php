<?php
/**
 * Created by PhpStorm.
 * User: sid
 * Date: 27.06.18
 * Time: 21:45
 */

namespace App\Services\Search;

use App\Entity\Adverts\Advert\Advert;
use App\Entity\Adverts\Advert\Value;
use Elasticsearch\Client;

class AdvertIndexer
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function clear()
    {
        $this->client->deleteByQuery([
            'index' => 'app',
            'type' => 'advert',
            'body' => [
                'query' => [
                    'match_all' => new \stdClass(),// Нужен простой пустой объект чтоб он при json_encode сделался {}
                ],
            ]
        ]);
    }

    public function remove(Advert $advert)
    {
        $this->client->delete([
            'index' => 'app',
            'type' => 'adverts',
            'id' => $advert->id,
        ]);
    }

    public function index(Advert $advert)
    {
        /**
         * @var Advert $advert
         */
        $regions = [];
        if($region = $advert->region) {
            do {
                $regions[] = $region->id;
            } while ($region = $region->parent);
        }

        $this->client->index([
            'index' => 'app',
            'type' => 'adverts',
            'id' => $advert->id,//служебная запись  если не сам сгенерирует
            'body' => [
                'id' => $advert->id,
                'published_at' => $advert->published_at ? $advert->published_at->format(DATE_ATOM) : null,//Этот формат принемается по умолчанию
                'title' => $advert->title,
                'status' => $advert->status,
                'content' => $advert->content,
                'price' => $advert->price,
                'categories' => array_merge([$advert->category->id],$advert->category->ancestors()->pluck('id')->toArray()),
                'regions' => $regions,
                'values' => array_map(function (Value $value ) {
                    return [
                        'attribute' => $value->attribute_id,
                        'value_string' => (string) $value->value,
                        'value_int' => (int) $value->value,
                    ];
                }, $advert->values()->getModels()),
            ],
        ]);
    }
}
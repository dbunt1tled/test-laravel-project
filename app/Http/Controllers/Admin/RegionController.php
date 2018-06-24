<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Region;
use App\Http\Requests\Admin\Region\CreateRequest;
use App\Http\Requests\Admin\Region\UpdateRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Gate;
use Illuminate\Support\Facades\Cache;

class RegionController extends Controller
{

    public function index()
    {
        $regions = Region::where([['parent_id',null]])->orderBy('name')->get();
        return view('admin.region.index', compact('regions'));
    }

    public function create(Request $request)
    {
        if($parent = $request->get('parent')){
            $parent = Region::whereId($parent)->firstOrFail();
        }
        return view('admin.region.create', compact('parent'));
    }

    public function store(CreateRequest $request)
    {
        $region = Region::new($request['name'],$request['slug'],$request['parent']);
        $region->save();
        Cache::tags(Region::class)->flush();
        return redirect()->route('admin.region.show',$region);
    }

    public function show(Region $region)
    {
        $regions = Region::where('parent_id',$region->id)->orderBy('name')->get();
        return view('admin.region.show',[
            'region' => $region,
            'regions' => $regions,
        ]);
    }

    public function edit(Region $region)
    {
        $regions = Region::where('id','!=',$region->id)->pluck('name', 'id');
        return view('admin.region.edit', compact('region','regions'));
    }

    public function update(UpdateRequest $request, Region $region)
    {
        $region->edit($request['name'],$request['slug'],$request['parent_id']);
        $region->save();
        Cache::tags(Region::class)->flush();
        return redirect()->route('admin.region.show',$region);
    }

    public function destroy(Region $region)
    {
        if(Gate::denies('region.manage')){
            abort(403,'В доступе отказано.');
        }
        $region->delete();
        return redirect()->route('admin.region.index');
    }
}

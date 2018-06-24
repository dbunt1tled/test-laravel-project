<?php

namespace App\Http\Controllers\Ajax;

use App\Entity\Region;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    public function get(Request $request)
    {
        $parentId = $request->get('parent') ?: null;
        return Region::where('parent_id',$parentId)
            ->orderBy('name')
            ->select('id','name')
            ->get()
            ->toArray();
    }
}

<?php

namespace App\Http\Controllers\Admin\Adverts;

use App\Entity\Adverts\Attribute;
use App\Entity\Adverts\Category;
use App\Http\Requests\Admin\Adverts\Category\Attribute\AttributeRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Gate;

class AttributeController extends Controller
{

    public function create(Category $category)
    {
        $types = Attribute::typeList();
        return view('admin.adverts.category.attribute.create', compact('category','types'));
    }

    public function store(AttributeRequest $request,Category $category)
    {
        $attribute = Attribute::new($request['name'],$category->id,$request['type'],(bool)$request['required'],array_map('trim',preg_split('#[\r\n]+#',$request['variants'])),$request['sort']);
        $attribute->save();
        return redirect()->route('admin.adverts.category.attribute.show',[$category,$attribute]);
    }

    public function show(Category $category, Attribute $attribute)
    {
        return view('admin.adverts.category.attribute.show',[
            'category' => $category,
            'attribute' => $attribute
        ]);
    }
    public function edit(Category $category, Attribute $attribute)
    {
        $types = Attribute::typeList();
        return view('admin.adverts.category.attribute.edit', compact('category','attribute','types'));
    }

    public function update(AttributeRequest $request, Category $category, Attribute $attribute)
    {

        $attributeEntity = $category->attributes()->findOrFail($attribute->id)->first();
        $attributeEntity->edit($request['name'],$category->id,$request['type'],(bool)$request['required'],array_map('trim',preg_split('#[\r\n]+#',$request['variants'])),$request['sort']);
        $attributeEntity->save();
        return redirect()->route('admin.adverts.category.attribute.show',[$category,$attributeEntity]);
    }

    public function destroy(Category $category)
    {
        if(Gate::denies('adverts.category.attribute.manage')){
            abort(403,'В доступе отказано.');
        }
        $category->delete();
        return redirect()->route('admin.adverts.category.index');
    }
}

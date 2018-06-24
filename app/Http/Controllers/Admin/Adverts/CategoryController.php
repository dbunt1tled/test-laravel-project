<?php

namespace App\Http\Controllers\Admin\Adverts;

use App\Entity\Adverts\Category;
use App\Http\Requests\Admin\Adverts\Category\CreateRequest;
use App\Http\Requests\Admin\Adverts\Category\UpdateRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Gate;
use Illuminate\Support\Facades\Cache;

class CategoryController extends Controller
{

    public function index()
    {
        $categories = Category::defaultOrder()->withDepth()->get();
        return view('admin.adverts.category.index', compact('categories'));
    }

    public function create(Request $request)
    {
        if($parent = $request->get('parent')){
            $parent = Category::whereId($parent)->firstOrFail();
        }
        return view('admin.adverts.category.create', compact('parent'));
    }

    public function store(CreateRequest $request)
    {
        $category = Category::new($request['name'],$request['slug'],$request['parent']);
        $category->save();
        Cache::tags(Category::class)->flush();
        return redirect()->route('admin.adverts.category.show',$category);
    }

    public function show(Category $category)
    {
        $categories = $category->descendants()->withDepth()->get();
        $parentAttributes = $category->parentAttributes();
        $attributes = $category->attributes()->orderBy('sort')->get();
        return view('admin.adverts.category.show',[
            'category' => $category,
            'categories' => $categories,
            'attributes' => $attributes,
            'parentAttributes' => $parentAttributes
        ]);
    }
    public function up(Category $category)
    {
        $category->up();
        return redirect()->route('admin.adverts.category.index');
    }
    public function down(Category $category)
    {
        $category->down();
        return redirect()->route('admin.adverts.category.index');
    }
    public function first(Category $category)
    {
        if($first = $category->siblings()->defaultOrder()->first()){
            $category->insertBeforeNode($first);
        }
        return redirect()->route('admin.adverts.category.index');
    }
    public function last(Category $category)
    {
        if($last = $category->siblings()->defaultOrder()->last()){
            $category->insertAfterNode($last);
        }
        return redirect()->route('admin.adverts.category.index');
    }
    public function edit(Category $category)
    {
        $categories = Category::defaultOrder()->withDepth()->get();
        return view('admin.adverts.category.edit', compact('category','categories'));
    }

    public function update(UpdateRequest $request, Category $category)
    {
        $category->edit($request['name'],$request['slug'],$request['parent_id']);
        $category->save();
        Cache::tags(Category::class)->flush();
        return redirect()->route('admin.adverts.category.show',$category);
    }

    public function destroy(Category $category)
    {
        if(Gate::denies('adverts.category.manage')){
            abort(403,'В доступе отказано.');
        }
        $category->delete();
        return redirect()->route('admin.adverts.category.index');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;

class CategoryController extends Controller
{
    public function index(){
        $categories = Category::all();
        return $categories;
    }
    public function publishedCategory(){
         $categories = Category::where('status',1)->get();
        return $categories;
    }
    public function store(Request $request){
        // return $request->all();

        $this->validate($request,[
            'name' => 'required',
            'status' => 'required',
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->status = $request->status;
        $category->save();
        return $category;
    }
     public function update(Request $request){
        // return $request->all();

        $this->validate($request,[
            'name' => 'required',
            'status' => 'required',
        ]);

        $category =  Category::find($request->id);
        $category->name = $request->name;
        $category->status = $request->status;
        $category->save();
        return $category;
    }
    public function destroy($id){
        Category::destroy($id);
        return 'success';
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;
use App\SubImage;
use Auth;

class ProductController extends Controller
{
    public function index(){
        $category = Category::all();
        $product =  Product::orderBy('id','desc')->get();
        return response()->json([
            'category' =>$category,
            'product' =>$product,
        ]);
    }
    public function store(Request $request){
        // return $request->all();
        $this->validate($request,[
            'name' => 'required|min:3',
            'price' => 'required',
            'description' => 'required',
            'image' => 'required',
        ]);


       $productImage = $request->file('image');
       $imageName = $productImage->getClientOriginalName();
       $imageDrectory ='product/images/';
       $productImage->move($imageDrectory,$imageName);
       $imageUrl = $imageDrectory.$imageName;

       $product = new Product();
       $product->user_id = auth()->user()->id;
       $product->category_id = $request->category_id;
       $product->name = $request->name;
       $product->price = $request->price;
       $product->description = $request->description;
       $product->image = $imageUrl;
       $product->save();



       $productId = $product->id;
       $productSubImages = $request->file('images');
       foreach($productSubImages as $productSubImage){
           $subImageName =$productSubImage->getClientOriginalName();
           $subImageDirectory = 'product/sub-images/';
           $productSubImage->move($subImageDirectory,$subImageName);
           $subImageUrl =$subImageDirectory.$subImageName;
           $subImage = new SubImage();
           $subImage->product_id = $productId;
           $subImage->image = $subImageUrl;
           $subImage->save();
       }      


    //    return $product;
       return request()->json(100,$product);

        // return Product::create($request->all()+ ['user_id'=>Auth::id()]);
    }

    public function detail($id){
         
           $product = Product::find($id);
           $subImage = SubImage::where('product_id',$product->id)->get();
            return response(['product'=>$product,'subImage'=>$subImage]);
       
    }

    public function destroy($id){
        try{
            Product::destroy($id);
            return response([],204);
        }catch(\Exception $e){
            return response(['error'=>'Proble Deleting Product'],404);
        }
    }
    public function show($id){
        // return response()->json(Product::find($id));
        $product = Product::find($id);
        if(count($product) > 0)
            return response()->json($product);
            return response()->json(['error'=>'Resource Not Found..'],404);
    }
    public function update(Request $request,$id){
        $proudct = Product::find($id);
      
        $proudct->update($request->all());
        return response()->json($proudct);
    }
}

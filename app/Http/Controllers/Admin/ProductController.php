<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\Models\Inquiry;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\StorageSetting;
use App\Models\ProductCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:Product');
    }

    public function index()
    {
        $index['data'] = Product::get();
        return view("product.index", $index);
    }

    public function create()
    {
        $index['productCategory'] = ProductCategory::where('status',1)->get();
        return view("product.create", $index);
    }

    public function product_status(Request $request)
    {
        $product = Product::find($request->get("id"));
        $product->status = ($request->get("checked")=="true")?1:0;
        $product->save();
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'title' => 'required',
            'price' => 'required',
            "discount_price" => 'required',
            'description' => 'required',
            "image" => "nullable|mimes:jpg,png,jpeg",
            'product_category_id' => 'required',
        ]);

        if ($validation->fails()) {
            return back()->withErrors($validation)->withInput();
        } else {

            $id = Product::create([
                "product_category_id" => $request->get("product_category_id"),
                "title" => $request->get("title"),
                "price" => $request->get("price"),
                "discount_price" => $request->get("discount_price"),
                "description" => $request->get("description"),
            ])->id;
           
            if(StorageSetting::getStorageSetting("storage") == "DigitalOcean")
            {
                if ($request->file("image") && $request->file('image')->isValid()) {
                    $image = $request->file('image');
                    $file = Str::uuid().'.'.$image->getClientOriginalExtension();
            
                    $path = Storage::disk('spaces')->put('uploads/'.$file, file_get_contents($image),'public');
                    
                    $product = Product::find($id);
                    $product->image = $file;
                    $product->save();
                }
            }
            else
            {
                if ($request->file("image") && $request->file('image')->isValid()) {
                    $this->upload_image($request->file("image"),"image", $id);
                }
            }

            return redirect()->route("product.index");
        }
    }

    public function edit($id)
    {
        $index['product'] = Product::find($id);
        $index['productCategory'] = ProductCategory::where('status',1)->get();
        return view("product.edit", $index);
    }

    public function update(Request $request, $id)
    {
        //dd($request->all());
        $validation = Validator::make($request->all(), [
            'title' => 'required',
            'price' => 'required',
            "discount_price" => 'required',
            'description' => 'required',
            "image" => "nullable|mimes:jpg,png,jpeg",
            'product_category_id' => 'required',
        ]);

        if ($validation->fails()) {
            return back()->withErrors($validation)->withInput();
        } else {
            $product = Product::find($request->get("id"));
            $product->product_category_id = $request->product_category_id;
            $product->title = $request->title;
            $product->price = $request->price;
            $product->discount_price = $request->discount_price;
            $product->description = $request->description;
            $product->save();

            if(StorageSetting::getStorageSetting("storage") == "DigitalOcean")
            {
                if ($request->file("image") && $request->file('image')->isValid()) {
                    $image = $request->file('image');
                    $file = Str::uuid().'.'.$image->getClientOriginalExtension();
            
                    $path = Storage::disk('spaces')->put('uploads/'.$file, file_get_contents($image),'public');
                    
                    $product = Product::find($request->get("id"));
                    $product->image = $file;
                    $product->save();
                }
            }
            else
            {
                if ($request->file("image") && $request->file('image')->isValid()) {
                    $this->upload_image($request->file("image"),"image", $id);
                }
            }

            return redirect()->route('product.index');
        }
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        if(StorageSetting::getStorageSetting("storage") == "DigitalOcean")
        {
            Storage::disk('spaces')->delete('uploads/'.$product->image);
        }
        else
        {
            unlink('./uploads/'.$product->image);
        }

        Inquiry::where('product_id',$id)->delete();
        Product::find($id)->delete();
        
        return redirect()->route('product.index');
    }

    private function upload_image($file,$field,$id)
    {
        $destinationPath = './uploads';
        $extension = $file->getClientOriginalExtension();
        $fileName = Str::uuid() . '.' . $extension;
        $file->move($destinationPath, $fileName);
        
        $image = Product::find($id);
        $image->$field = $fileName;
        $image->save();
    }
}

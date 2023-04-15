<?php

namespace App\Http\Controllers\Admin;

use Image;
use App\Models\Story;
use App\Models\Category;
use App\Models\Festivals;
use App\Models\CustomPost;
use Illuminate\Support\Str;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Models\StorageSetting;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class StoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:Stories');
    }

    public function index()
    {
        $index['data'] = Story::orderBy('id', 'DESC')->paginate(12);
        return view("story.index", $index);
    }

    public function create()
    {
        $index['category'] = Category::where('status',1)->get();
        $index['custom'] = CustomPost::where('status',1)->get();
        $index['festival'] = Festivals::where('status',1)->get();
        $index['plan'] = Subscription::get();
        return view("story.create", $index);
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            "story_type" => 'required',
            "image" => "nullable|mimes:jpg,png,jpeg",
        ]);

        if ($validation->fails()) {
            return back()->withErrors($validation)->withInput();
        } else {
            $id = Story::create([
                "story_type" => $request->get("story_type"),
                "user_id" => $request->get("user_id"),
                "festival_id" => $request->get("festival_id"),
                "category_id" => $request->get("category_id"),
                "custom_category_id" => $request->get("custom_category_id"),
                "subscription_id" => $request->get("plan_id"),
                "external_link" => $request->get("external_link"),
                "external_link_title" => $request->get("external_link_title"),
            ])->id;

            if(StorageSetting::getStorageSetting("storage") == "DigitalOcean")
            {
                if ($request->file("image") && $request->file('image')->isValid()) {
                    $image = $request->file('image');
                    $file = Str::uuid().'.'.$image->getClientOriginalExtension();
            
                    $path = Storage::disk('spaces')->put('uploads/'.$file, file_get_contents($image),'public');
                    
                    $s = Story::find($id);
                    $s->image = $file;
                    $s->save();
                }
            }
            else
            {
                if ($request->file("image") && $request->file('image')->isValid()) {
                    $this->upload_image($request->file("image"),"image", $id);
                }
            }

            return redirect()->route("story.index");
        }
    }

    public function story_status(Request $request)
    {
        $story = Story::find($request->get("id"));
        $story->status = ($request->get("checked")=="true")?1:0;
        $story->save();
    }

    public function edit($id)
    {
        $index['story'] = Story::find($id);
        $index['category'] = Category::where('status',1)->get();
        $index['festival'] = Festivals::where('status',1)->get();
        $index['custom'] = CustomPost::where('status',1)->get();
        $index['plan'] = Subscription::get();
        return view("story.edit", $index);
    }

    public function update(Request $request, $id)
    {
        //dd($request->all());
        $validation = Validator::make($request->all(), [
            "story_type" => 'required',
            "image" => "nullable|mimes:jpg,png,jpeg",
        ]);

        if ($validation->fails()) {
            return back()->withErrors($validation)->withInput();
        } else {
            $story = Story::find($request->get("id"));
            $story->story_type = $request->get("story_type");
            $story->festival_id = $request->get("festival_id");
            $story->category_id = $request->get("category_id");
            $story->custom_category_id = $request->get("custom_category_id");
            $story->subscription_id = $request->get("plan_id");
            $story->external_link = $request->get("external_link");
            $story->external_link_title = $request->get("external_link_title");
            $story->save();

            if(StorageSetting::getStorageSetting("storage") == "DigitalOcean")
            {
                if ($request->file("image") && $request->file('image')->isValid()) {
                    $image = $request->file('image');
                    $file = Str::uuid().'.'.$image->getClientOriginalExtension();
            
                    $path = Storage::disk('spaces')->put('uploads/'.$file, file_get_contents($image),'public');
                    
                    $s = Story::find($request->get("id"));
                    $s->image = $file;
                    $s->save();
                }
            }
            else
            {
                if ($request->file("image") && $request->file('image')->isValid()) {
                    $this->upload_image($request->file("image"),"image", $id);
                }
            }

            return redirect()->route('story.index');
        }
    }

    public function destroy($id)
    {
        $story = Story::find($id);
        if(StorageSetting::getStorageSetting("storage") == "DigitalOcean")
        {
            Storage::disk('spaces')->delete('uploads/'.$story->image);
        }
        else
        {
            unlink('./uploads/'.$story->image);
        }

        Story::find($id)->delete();
        return redirect()->route('story.index');
    }

    private function upload_image($file,$field,$id)
    {
        $destinationPath = './uploads';
        $extension = $file->getClientOriginalExtension();
        $fileName = Str::uuid() . '.' . $extension;
        $file->move($destinationPath, $fileName);

        $image = Story::find($id);
        $image->$field = $fileName;
        $image->save();
    }
}

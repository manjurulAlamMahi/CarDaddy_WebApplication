<?php

namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        $about = AboutUs::first();
        return view('backend.layout.about.index', compact('about'));
    }
    public function update(Request $request)
    {
        // return $request->all();
        $about = AboutUs::first();

        $validated = $request->validate([
            'desp'      => 'required|string',
            'image_one' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image_two' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->except(['image_one', 'image_two']);

        if ($request->hasFile('image_one')) {
            if ($about->image_one && file_exists($about->image_one) && $about->image_one != 'default.jpg') {
                unlink($about->image_one);
            }
            $path = $this->fileUpload($request->file('image_one'), 'about/');
            $data['image_one'] = $path;
        }

        if ($request->hasFile('image_two')) {
            if ($about->image_two && file_exists($about->image_two) && $about->image_two != 'default.jpg') {
                unlink($about->image_two);
            }
            $path = $this->fileUpload($request->file('image_two'), 'about/');
            $data['image_two'] = $path;
        }

        $about->update($data);

        return back()->with('success', 'Content updated successfully');
    }
}

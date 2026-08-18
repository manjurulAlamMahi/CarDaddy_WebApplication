<?php

namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Blog::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function ($data) {
                    return '<img src="' . asset($data->image) . '" width="24" alt="">';
                })
                ->addColumn('is_front', function ($data) {
                    return '<div class="form-check form-switch mb-2">
                                <input class="form-check-input" onclick="isFront(' . $data->id . ')" type="checkbox" ' . ($data->is_front == 1 ? 'checked' : '') . '>
                            </div>';
                })
                ->addColumn('status', function ($data) {
                    return '<div class="form-check form-switch mb-2">
                                <input class="form-check-input" onclick="statusCategory(' . $data->id . ')" type="checkbox" ' . ($data->status == 'active' ? 'checked' : '') . '>
                            </div>';
                })
                ->addColumn('action', function ($data) {
                    return '<a href="' . route('blog.edit', $data->id) . '" class="btn btn-info">
                                <i class="mdi mdi-pencil"></i>
                            </a>
                            <button type="button"  onclick="deleteData(\'' . route('blog.destroy', $data->id) . '\')" class="btn btn-danger del">
                                <i class="mdi mdi-delete"></i>
                            </button>';
                })
                ->rawColumns(['image', 'is_front', 'status', 'action'])
                ->make(true);
        }

        return view('backend.layout.blog.index');
    }
    public function edit($id)
    {
        $data['blog'] = Blog::find($id);
        return view('backend.layout.blog.edit', $data);
    }
    public function store(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'short_desp' => 'required|string|max:500',
            'long_desp' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->all();

        // If you need to handle the image upload:
        if ($request->hasFile('image')) {
            $path = $this->fileUpload($request->image, 'blog/');
            $data['image'] = $path;
        }
        $data['slug'] = $this->generateUniqueSlug($request->title, Blog::class);
        $data['user_id'] = Auth::id();

        Blog::create($data);

        // You can now return a response or redirect as needed
        return back()->with('success', 'Blog post created successfully');
    }
    public function update(Request $request)
    {
        $blog = Blog::find($request->id);

        if (!$blog) {
            return back()->with('error', 'Blog post not found');
        }

        // Validate the incoming request
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'short_desp' => 'required|string|max:500',
            'long_desp' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->except(['image']);

        if ($request->hasFile('image')) {
            if (file_exists($blog->image)) {
                unlink($blog->image);
            }
            $path = $this->fileUpload($request->image, 'blog/');
            $data['image'] = $path;
        }

        if ($blog->title !== $request->title) {
            $data['slug'] = $this->generateUniqueSlug($request->title, Blog::class);
        }

        $blog->update($data);

        return back()->with('success', 'Blog post updated successfully');
    }
    public function status(Request $request)
    {
        $cate = Blog::find($request->id);


        if ($cate->status == 'active') {
            $cate->update([
                'status' => 'inactive',
            ]);
        } else {
            $cate->update([
                'status' => 'active',
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Status Updated'
        ]);
    }
    public function isFront(Request $request)
    {
        // Find the blog entry
        $blog = Blog::find($request->id);

        // If blog is not found, return an error response
        if (!$blog) {
            return response()->json([
                'success' => false,
                'message' => 'Blog not found'
            ], 404);
        }

        // Reset all 'is_front' values to 0
        Blog::where('is_front', 1)->update(['is_front' => 0]);

        // Update the selected blog entry
        $blog->update(['is_front' => 1]);

        return response()->json([
            'success' => true,
            'message' => 'Status Updated'
        ]);
    }

    public function destroy($id)
    {
        $delete = Blog::find($id)->delete();
        if ($delete) {
            return back()->with('success', 'Deleted Successfully');
        } else {
            return back()->with('error', 'Try Again!');
        }
    }
}

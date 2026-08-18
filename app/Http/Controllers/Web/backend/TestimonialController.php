<?php

namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class TestimonialController extends Controller
{
    public function get(Request $request)
    {
        $query = Testimonial::query();

        if (!empty($request->id)) {
            $query->where('id', $request->id);
        }

        $data = $query->get();

        return response()->json($data);
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Testimonial::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function ($data) {
                    return '<img src="' . asset($data->image) . '" width="24" alt="">';
                })
                ->addColumn('status', function ($data) {
                    return '<div class="form-check form-switch mb-2">
                                <input class="form-check-input" onclick="statusTestimonial(' . $data->id . ')" type="checkbox" ' . ($data->status == 'active' ? 'checked' : '') . '>
                            </div>';
                })
                ->addColumn('action', function ($data) {
                    return '<button onclick="editTestimonial(' . $data->id . ')" type="button" class="btn btn-info">
                                <i class="mdi mdi-pencil"></i>
                            </button>
                            <button type="button"  onclick="deleteData(\'' . route('testimonial.destroy', $data->id) . '\')" class="btn btn-danger del">
                                <i class="mdi mdi-delete"></i>
                            </button>';
                })
                ->rawColumns(['image', 'status', 'action'])
                ->make(true);
        }
        return view('backend.layout.testimonial.index');
    }
    public function store(Request $request)
    {
        $imageRule = $request->filled('id') ? 'nullable' : 'required';

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'rating' => 'required|numeric|min:0|max:5',
            'review' => 'required|string|max:500',
            'image' => "$imageRule|image|mimes:jpeg,png,jpg,gif,svg|max:2048",
        ]);

        $data = $request->only(['name', 'rating', 'review']);

        if ($request->filled('id')) {
            $testimonial = Testimonial::findOrFail($request->id);

            if ($request->hasFile('image')) {
                if ($testimonial->image && file_exists(public_path($testimonial->image))) {
                    unlink(public_path($testimonial->image)); // Delete old image
                }
                $path = $this->fileUpload($request->image, 'client/');
                $data['image'] = $path;
            } else {
                $data['image'] = $testimonial->image;
            }

            $testimonial->update($data);

            return back()->with('success', 'Updated successfully');
        }

        // **CREATE CASE (image required)**
        if ($request->hasFile('image')) {
            $path = $this->fileUpload($request->image, 'client/');
            $data['image'] = $path;
        }

        Testimonial::create($data);

        return back()->with('success', 'Created successfully');
    }

    public function status(Request $request)
    {
        $cate = Testimonial::find($request->id);


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
    public function destroy($id)
    {
        $delete = Testimonial::find($id)->delete();
        if ($delete) {
            return back()->with('success', 'Deleted Successfully');
        } else {
            return back()->with('error', 'Try Again!');
        }
    }
}

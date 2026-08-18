<?php

namespace App\Http\Controllers\Web\Backend;

use App\Helper\Helper;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\ImageType;
use App\Models\VehicleExteriorImage;
use App\Models\VehicleInteriorImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Illuminate\Validation\Rule;

class ImageTypeController extends Controller
{
    public function get(Request $request)
    {
        $query = ImageType::query();

        if (!empty($request->id) && empty($request->name)) {
            $query->where('id', $request->id);
        }
        if (!empty($request->name)) {
            if (!empty($request->id)) {
                $query->where('id', '!=', $request->id)->where('name', $request->name);
            }
            $query->where('name', $request->name);
        }

        $ImageTypes = $query->get();

        return response()->json($ImageTypes);
    }

    public function status(Request $request)
    {
        $cate = ImageType::find($request->id);


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
        $delete = ImageType::find($id)->update([
            'priority' => 0
        ]);

        $delete = ImageType::find($id)->delete();
        VehicleExteriorImage::where('image_type_id', $id)->delete();
        VehicleInteriorImage::where('image_type_id', $id)->delete();
        if ($delete) {
            return back()->with('success', 'Deleted Successfully');
        } else {
            return back()->with('error', 'Try Again!');
        }
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = ImageType::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function ($data) {
                    return '<img src="' . asset($data->image) . '" width="24" alt="">';
                })
                ->addColumn('status', function ($data) {
                    return '<div class="form-check form-switch mb-2">
                                <input class="form-check-input" onclick="statusImageType(' . $data->id . ')" type="checkbox" ' . ($data->status == 'active' ? 'checked' : '') . '>
                            </div>';
                })
                ->addColumn('action', function ($data) {
                    return '<button onclick="editImageType(' . $data->id . ')" type="button" class="btn btn-info">
                                <i class="mdi mdi-pencil"></i>
                            </button>
                            <button type="button"  onclick="deleteData(\'' . route('image.destroy', $data->id) . '\')" class="btn btn-danger del">
                                <i class="mdi mdi-delete"></i>
                            </button>';
                })
                ->setRowAttr([
                    'data-id' => function ($data) {
                        return $data->id;
                    }
                ])
                ->rawColumns(['image', 'status', 'action'])
                ->make(true);
        }

        return view('backend.layout.imageType.index');
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255|unique:image_types,name',
            'image'    => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'name.required' => 'The ImageType name is required.',
            'name.string'   => 'The ImageType name must be a valid string.',
            'name.max'      => 'The ImageType name cannot exceed 255 characters.',
            'name.unique'   => 'This ImageType name is already taken. Please choose a different name.',

            'priority.numeric'  => 'The priority must be a number.',
            'priority.unique'   => 'This priority value is already taken. Please choose a different one.',

            'image.required'    => 'An image is required for the ImageType.',
            'image.image'       => 'The file must be an image.',
            'image.mimes'       => 'Only JPEG, PNG, JPG, and GIF formats are allowed.',
            'image.max'         => 'The image size must not exceed 2MB.',
        ]);

        if ($validator->fails()) {
            return back()->with('error', $validator->errors()->first())->withInput();
        }

        try {
  
            if ($request->hasFile('image')) {
                $data['image'] = Helper::fileUpload($request->image, 'ImageTypes', $request->name . "-" . time());
            }

            ImageType::create($data);

            return back()->with('success', 'ImageType successfully created');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('image_types', 'name')->ignore($request->id),
            ],
            'image'    => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'name.required' => 'The ImageType name is required.',
            'name.string'   => 'The ImageType name must be a valid string.',
            'name.max'      => 'The ImageType name cannot exceed 255 characters.',
            'name.unique'   => 'This ImageType name is already taken. Please choose a different name.',

            'priority.required' => 'The priority field is required.',
            'priority.numeric'  => 'The priority must be a number.',
            'priority.unique'   => 'This priority value is already taken. Please choose a different one.',

            'image.image'       => 'The file must be an image.',
            'image.mimes'       => 'Only JPEG, PNG, JPG, and GIF formats are allowed.',
            'image.max'         => 'The image size must not exceed 2MB.',
        ]);

        if ($validator->fails()) {
            return back()->with('error', $validator->errors()->first())->withInput();
        }
        $ImageType = ImageType::find($request->id);
        try {
            if ($request->hasFile('image')) {
                if (file_exists($ImageType->image) && $ImageType->image != 'default.jpg') {
                    unlink($ImageType->image);
                }
                $data['image'] = Helper::fileUpload($request->image, 'ImageTypes', $request->name . "-" . time());
            }
            $ImageType = $ImageType->update($data);
            return back()->with('success', 'ImageType successfully created');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}

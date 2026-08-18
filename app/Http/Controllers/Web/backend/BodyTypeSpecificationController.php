<?php

namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use App\Models\BodyType;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class BodyTypeSpecificationController extends Controller
{
    public function get(Request $request)
    {
        $query = BodyType::query();

        if (!empty($request->id) && empty($request->name)) {
            $query->where('id', $request->id);
        }
        if (!empty($request->name)) {
            if (!empty($request->id)) {
                $query->where('id', '!=', $request->id)->where('name', $request->name);
            }
            $query->where('name', $request->name);
        }

        $data = $query->get();

        return response()->json($data);
    }

    public function destroy($id)
    {
        $delete = BodyType::find($id)->delete();
        Vehicle::where('body_type', $id)->update(['body_type' => null]);
        if ($delete) {
            return back()->with('success', 'Deleted Successfully');
        } else {
            return back()->with('error', 'Try Again!');
        }
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = BodyType::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    return '<button onclick="editContent(' . $data->id . ')" type="button" class="btn btn-info">
                                <i class="mdi mdi-pencil"></i>
                            </button>
                            <button type="button"  onclick="deleteData(\'' . route('bodyType.destroy', $data->id) . '\')" class="btn btn-danger del">
                                <i class="mdi mdi-delete"></i>
                            </button>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('backend.layout.specification.bodyType.index');
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255|unique:body_types,name',
        ], [
            'name.required' => 'The name is required.',
            'name.string'   => 'The name must be a valid string.',
            'name.max'      => 'The name cannot exceed 255 characters.',
            'name.unique'   => 'This name is already taken. Please choose a different name.',
        ]);

        $data['slug'] = $this->generateUniqueSlug($request->name, BodyType::class);

        if ($validator->fails()) {
            return back()->with('error', $validator->errors()->first())->withInput();
        }

        try {
            BodyType::create($data);

            return back()->with('success', 'Successfully Created');
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
                Rule::unique('body_types', 'name')->ignore($request->id),
            ],
        ], [
            'name.required' => 'The name is required.',
            'name.string'   => 'The name must be a valid string.',
            'name.max'      => 'The name cannot exceed 255 characters.',
            'name.unique'   => 'This name is already taken. Please choose a different name.',
        ]);

        if ($validator->fails()) {
            return back()->with('error', $validator->errors()->first())->withInput();
        }
        $content = BodyType::find($request->id);

        if ($content->name !== $request->name) {
            $data['slug'] = $this->generateUniqueSlug($request->name, BodyType::class);
        }
        try {
            $content->update($data);
            return back()->with('success', 'Successfully updated');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}

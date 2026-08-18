<?php

namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use App\Models\Cylinder;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class CylinderSpecificationController extends Controller
{
    public function get(Request $request)
    {
        $query = Cylinder::query();

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
        $delete = Cylinder::find($id)->delete();
        Vehicle::where('cylinder', $id)->update(['cylinder' => null]);
        if ($delete) {
            return back()->with('success', 'Deleted Successfully');
        } else {
            return back()->with('error', 'Try Again!');
        }
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Cylinder::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    return '<button onclick="editContent(' . $data->id . ')" type="button" class="btn btn-info">
                                <i class="mdi mdi-pencil"></i>
                            </button>
                            <button type="button"  onclick="deleteData(\'' . route('cylinder.destroy', $data->id) . '\')" class="btn btn-danger del">
                                <i class="mdi mdi-delete"></i>
                            </button>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('backend.layout.specification.cylinder.index');
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255|unique:cylinders,name',
        ], [
            'name.required' => 'The name is required.',
            'name.string'   => 'The name must be a valid string.',
            'name.max'      => 'The name cannot exceed 255 characters.',
            'name.unique'   => 'This name is already taken. Please choose a different name.',
        ]);

        if ($validator->fails()) {
            return back()->with('error', $validator->errors()->first())->withInput();
        }

        try {
            Cylinder::create($data);

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
                Rule::unique('cylinders', 'name')->ignore($request->id),
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
        $content = Cylinder::find($request->id);
        try {
            $content->update($data);
            return back()->with('success', 'Successfully updated');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}

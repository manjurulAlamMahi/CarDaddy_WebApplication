<?php

namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use App\Models\Drivetrain;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class DrivetrainSpecificationController extends Controller
{
    public function get(Request $request)
    {
        $query = Drivetrain::query();

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
        $delete = Drivetrain::find($id)->delete();
        Vehicle::where('drivetrain', $id)->update(['drivetrain' => null]);
        if ($delete) {
            return back()->with('success', 'Deleted Successfully');
        } else {
            return back()->with('error', 'Try Again!');
        }
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Drivetrain::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    return '<button onclick="editContent(' . $data->id . ')" type="button" class="btn btn-info">
                                <i class="mdi mdi-pencil"></i>
                            </button>
                            <button type="button"  onclick="deleteData(\'' . route('drivetrain.destroy', $data->id) . '\')" class="btn btn-danger del">
                                <i class="mdi mdi-delete"></i>
                            </button>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('backend.layout.specification.drivetrain.index');
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255|unique:drivetrains,name',
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
            $data['slug'] = $this->generateUniqueSlug($request->name, Drivetrain::class);
            Drivetrain::create($data);

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
                Rule::unique('drivetrains', 'name')->ignore($request->id),
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
        $content = Drivetrain::find($request->id);

        if ($content->name !== $request->name) {
            $data['slug'] = $this->generateUniqueSlug($request->name, Drivetrain::class);
        }
        try {
            $content->update($data);
            return back()->with('success', 'Successfully updated');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}

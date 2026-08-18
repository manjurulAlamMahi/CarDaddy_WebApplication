<?php

namespace App\Http\Controllers\Web\Backend;

use App\Helper\Helper;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\Declaration;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Illuminate\Validation\Rule;

class DeclarationController extends Controller
{
    public function get(Request $request)
    {
        $query = Declaration::query();

        if (!empty($request->id) && empty($request->name) && empty($request->priority)) {
            $query->where('id', $request->id);
        }
        if (!empty($request->name)) {
            if (!empty($request->id)) {
                $query->where('id', '!=', $request->id)->where('name', $request->name);
            }
            $query->where('name', $request->name);
        }
        if (!empty($request->priority)) {
            if (!empty($request->id)) {
                $query->where('id', '!=', $request->id)->where('priority', $request->priority);
            }
            $query->where('priority', $request->priority);
        }

        $declarations = $query->get();

        return response()->json($declarations);
    }

    public function priority(Request $request)
    {
        try {
            foreach ($request->ranks as $rankData) {
                $declaration = Declaration::find($rankData['id']);
                if ($declaration) {
                    $declaration->priority = $rankData['rank'];
                    $declaration->save();
                }
            }
            return response()->json(['success' => true, 'message' => 'Priority updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update priority', 'message' => $e->getMessage()], 500);
        }
    }

    public function status(Request $request)
    {
        $cate = Declaration::find($request->id);


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
        $delete = Declaration::find($id)->delete();
        if ($delete) {
            return back()->with('success', 'Deleted Successfully');
        } else {
            return back()->with('error', 'Try Again!');
        }
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Declaration::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function ($data) {
                    return '<div class="form-check form-switch mb-2">
                                <input class="form-check-input" onclick="statusdeclaration(' . $data->id . ')" type="checkbox" ' . ($data->status == 'active' ? 'checked' : '') . '>
                            </div>';
                })
                ->addColumn('action', function ($data) {
                    return '<button onclick="editdeclaration(' . $data->id . ')" type="button" class="btn btn-info">
                                <i class="mdi mdi-pencil"></i>
                            </button>
                            <button type="button"  onclick="deleteData(\'' . route('declaration.destroy', $data->id) . '\')" class="btn btn-danger del">
                                <i class="mdi mdi-delete"></i>
                            </button>';
                })
                ->setRowAttr([
                    'data-id' => function ($data) {
                        return $data->id;
                    }
                ])
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view('backend.layout.declaration.index');
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255|unique:declarations,name',
            'priority' => 'nullable|numeric|unique:declarations,priority',
        ], [
            'name.required' => 'The declaration name is required.',
            'name.string'   => 'The declaration name must be a valid string.',
            'name.max'      => 'The declaration name cannot exceed 255 characters.',
            'name.unique'   => 'This declaration name is already taken. Please choose a different name.',

            'priority.numeric'  => 'The priority must be a number.',
            'priority.unique'   => 'This priority value is already taken. Please choose a different one.',
        ]);

        if ($validator->fails()) {
            return back()->with('error', $validator->errors()->first())->withInput();
        }

        try {
            // Auto-generate priority if not provided
            if (empty($data['priority'])) {
                $highestPriority = Declaration::max('priority');
                $data['priority'] = $highestPriority ? $highestPriority + 1 : 1;
            }

            $declaration = Declaration::create($data);

            return back()->with('success', 'Declaration successfully created');
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
                Rule::unique('declarations', 'name')->ignore($request->id),
            ],
            'priority' => [
                'required',
                'numeric',
                Rule::unique('declarations', 'priority')->ignore($request->id),
            ],
        ], [
            'name.required' => 'The declaration name is required.',
            'name.string'   => 'The declaration name must be a valid string.',
            'name.max'      => 'The declaration name cannot exceed 255 characters.',
            'name.unique'   => 'This declaration name is already taken. Please choose a different name.',

            'priority.required' => 'The priority field is required.',
            'priority.numeric'  => 'The priority must be a number.',
            'priority.unique'   => 'This priority value is already taken. Please choose a different one.',
        ]);

        if ($validator->fails()) {
            return back()->with('error', $validator->errors()->first())->withInput();
        }
        $declaration = Declaration::find($request->id);
        try {
            $declaration = $declaration->update($data);
            return back()->with('success', 'Declaration successfully created');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}

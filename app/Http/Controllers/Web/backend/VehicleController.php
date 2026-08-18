<?php

namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BodyType;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Cylinder;
use App\Models\Door;
use App\Models\Drivetrain;
use App\Models\FuelType;
use App\Models\ImageType;
use App\Models\Mileage;
use App\Models\MPG;
use App\Models\Size;
use App\Models\Tag;
use App\Models\Transmission;
use App\Models\Vehicle;
use App\Models\VehicleExteriorImage;
use App\Models\VehicleInteriorImage;
use App\Models\VehicleTag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class VehicleController extends Controller
{
    // Create Page
    public function create()
    {
        $data['brands'] = Brand::all();
        $data['categories'] = Category::all();

        $data['body_type'] = BodyType::all();
        $data['colors'] = Color::all();
        $data['cylinders'] = Cylinder::all();
        $data['doors'] = Door::all();
        $data['drivetrains'] = Drivetrain::all();
        $data['fuel_types'] = FuelType::all();
        $data['mileage'] = Mileage::all();
        $data['mpgs'] = MPG::all();
        $data['sizes'] = Size::all();
        $data['transmission'] = Transmission::all();

        $data['tags'] = Tag::all();

        $data['exterior_image_types'] = ImageType::where('type', 'exterior')->get();
        $data['interior_image_types'] = ImageType::where('type', 'interior')->get();

        return view('backend.layout.vehicle.create', $data);
    }
    // Edit
    public function edit($id)
    {
        $data['brands'] = Brand::all();
        $data['categories'] = Category::all();

        $data['body_type'] = BodyType::all();
        $data['colors'] = Color::all();
        $data['cylinders'] = Cylinder::all();
        $data['doors'] = Door::all();
        $data['drivetrains'] = Drivetrain::all();
        $data['fuel_types'] = FuelType::all();
        $data['mileage'] = Mileage::all();
        $data['mpgs'] = MPG::all();
        $data['sizes'] = Size::all();
        $data['transmission'] = Transmission::all();

        $data['exterior_image_types'] = ImageType::where('type', 'exterior')->get();
        $data['interior_image_types'] = ImageType::where('type', 'interior')->get();

        $data['vehicle'] = Vehicle::findOrFail($id);
        $data['tags'] = Tag::all();
        $data['vehicleTags'] = $data['vehicle']->tags()->pluck('tag_id')->toArray();
        return view('backend.layout.vehicle.edit', $data);
    }
    public function view($id)
    {
        $data['vehicle'] = Vehicle::findOrFail($id);
        $data['vehicle_interior_images'] = VehicleInteriorImage::where('vehicle_id', $id)->get();
        $data['vehicle_exterior_images'] = VehicleExteriorImage::where('vehicle_id', $id)->get();
        $data['vehicle_tags'] = VehicleTag::where('vehicle_id', $id)->get();
        return view('backend.layout.vehicle.view', $data);
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $data = Vehicle::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('brand', function ($data) {
                    return $data->brand->name;
                })
                ->addColumn('category', function ($data) {
                    return $data->cate->name;
                })
                ->addColumn('action', function ($data) {
                    if ($data->verified == 0) {
                        return '
                        <a href="' . route('vehicle.view', $data->id) . '" class="btn btn-primary">
                            <i class="mdi mdi-eye"></i>
                        </a>
                        <a href="' . route('vehicle.verified', $data->id) . '" class="btn btn-info">
                            Verify
                        </a>
                        <button type="button" onclick="deleteData(\'' . route('vehicle.destroy', $data->id) . '\')" class="btn btn-danger del">
                            <i class="mdi mdi-delete"></i>
                        </button>';
                    } else {
                        return '
                        <a href="' . route('vehicle.view', $data->id) . '" class="btn btn-primary">
                            <i class="mdi mdi-eye"></i>
                        </a>
                        <a href="' . route('vehicle.edit', $data->id) . '" class="btn btn-info">
                            <i class="mdi mdi-pencil"></i>
                        </a>
                        <button type="button" onclick="deleteData(\'' . route('vehicle.destroy', $data->id) . '\')" class="btn btn-danger del">
                            <i class="mdi mdi-delete"></i>
                        </button>';
                    }
                })
                ->addColumn('status', function ($data) {
                    return '<div class="form-check form-switch mb-2">
                                <input class="form-check-input" onclick="updateStatus(' . $data->id . ')" type="checkbox" ' . ($data->status == 'active' ? 'checked' : '') . '>
                            </div>';
                })
                ->setRowAttr([
                    'data-id' => function ($data) {
                        return $data->id;
                    }
                ])
                ->rawColumns(['make', 'category', 'status', 'action'])
                ->make(true);
        }
        return view('backend.layout.vehicle.list');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $validate = Validator::make($data, [
            'name'           => 'required|string|max:255',
            'make'           => 'required|integer|exists:brands,id',
            'model'          => 'required|string|max:255',
            'submodel'       => 'nullable|string|max:255',
            'category'       => 'required|integer|exists:categories,id',
            'year'           => 'required|integer|min:1900|max:' . date('Y'),
            'price'          => 'required|numeric|min:0',
            'mileage'        => 'nullable|integer|min:0',
            'color'          => 'required|integer|exists:colors,id',
            'condition'      => 'required|in:new,used',
            'body_type'      => 'nullable|integer|exists:body_types,id',
            'transmission'   => 'nullable|integer|exists:transmissions,id',
            'size'           => 'nullable|integer|exists:sizes,id',
            'doors'          => 'nullable|integer|min:1|max:10',
            'exterior_color' => 'nullable|integer|exists:colors,id',
            'interior_color' => 'nullable|integer|exists:colors,id',
            'drivetrain'     => 'nullable|integer|exists:drivetrains,id',
            'cylinder'       => 'nullable|integer|min:1|max:16',
            'mpg'            => 'nullable|integer|min:1|max:100',
            'fuel_type'      => 'nullable|integer|exists:fuel_types,id',
            'description'    => 'required|string',
            'features'       => 'nullable|string',
            'history'        => 'nullable|string',
            'warrenty'       => 'nullable|string',
            'video_link_01'  => 'nullable|url',
            'video_link_02'  => 'nullable|url',
            'tags'           => 'required|array',
            'tags.*'         => 'integer|exists:tags,id',
        ]);
        if ($validate->fails()) {
            return redirect()->back()->with('error', $validate->errors()->first())->withErrors($validate)->withInput();
        }
        try {
            DB::beginTransaction();

            $vehicle                 = new Vehicle();
            $vehicle->name           = $data['name'];
            $vehicle->slug           = $this->generateUniqueSlug($request->name, Vehicle::class);
            $vehicle->make           = $data['make'];
            $vehicle->model          = $data['model'];
            $vehicle->submodel       = $data['submodel'];
            $vehicle->category       = $data['category'];
            $vehicle->year           = $data['year'];
            $vehicle->price          = $data['price'];
            $vehicle->mileage        = $data['mileage'];
            $vehicle->color          = $data['color'];
            $vehicle->condition      = $data['condition'];
            $vehicle->body_type      = $data['body_type'];
            $vehicle->transmission   = $data['transmission'];
            $vehicle->size           = $data['size'];
            $vehicle->doors          = $data['doors'];
            $vehicle->exterior_color = $data['exterior_color'];
            $vehicle->interior_color = $data['interior_color'];
            $vehicle->drivetrain     = $data['drivetrain'];
            $vehicle->cylinder       = $data['cylinder'];
            $vehicle->mpg            = $data['mpg'];
            $vehicle->fuel_type      = $data['fuel_type'];
            $vehicle->description    = $data['description'];
            $vehicle->features       = $data['features'];
            $vehicle->history        = $data['history'];
            $vehicle->warrenty       = $data['warrenty'];
            $vehicle->video_link_01  = $data['video_link_01'];
            $vehicle->video_link_02  = $data['video_link_02'];
            $vehicle->created_by     = Auth::id();
            $vehicle->save();

            foreach ($data['image'] as $id => $value) {
                $imageType = ImageType::find($id);

                if (!$imageType || !($value instanceof \Illuminate\Http\UploadedFile) || !$value->isValid()) {
                    continue;
                }

                $folder = match ($imageType->type) {
                    'interior' => 'vehicle/interior',
                    'exterior' => 'vehicle/exterior',
                    default => null
                };

                if ($folder) {
                    $path = $this->fileUpload($value, $folder);

                    $model = $imageType->type === 'interior' ? VehicleInteriorImage::class : VehicleExteriorImage::class;

                    $model::create([
                        'vehicle_id'    => $vehicle->id,
                        'image_type_id' => $id,
                        'image'         => $path,
                    ]);
                }
            }

            foreach ($data['tags'] as $tag) {
                VehicleTag::create([
                    'vehicle_id' => $vehicle->id,
                    'tag_id'     => $tag,
                ]);
            }

            DB::commit();

            return redirect()->back()->with('success', 'Vehicle created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function update(Request $request)
    {
        $vehicle = Vehicle::findOrFail($request->id);
        $data = $request->all();

        $validate = Validator::make($data, [
            'name'           => 'required|string|max:255',
            'make'           => 'required|integer|exists:brands,id',
            'model'          => 'required|string|max:255',
            'submodel'       => 'nullable|string|max:255',
            'category'       => 'required|integer|exists:categories,id',
            'year'           => 'required|integer|min:1900|max:' . date('Y'),
            'price'          => 'required|numeric|min:0',
            'mileage'        => 'nullable|integer|min:0',
            'color'          => 'required|integer|exists:colors,id',
            'condition'      => 'required|in:new,used',
            'body_type'      => 'nullable|integer|exists:body_types,id',
            'transmission'   => 'nullable|integer|exists:transmissions,id',
            'size'           => 'nullable|integer|exists:sizes,id',
            'doors'          => 'nullable|integer|min:1|max:10',
            'exterior_color' => 'nullable|integer|exists:colors,id',
            'interior_color' => 'nullable|integer|exists:colors,id',
            'drivetrain'     => 'nullable|integer|exists:drivetrains,id',
            'cylinder'       => 'nullable|integer|min:1|max:16',
            'mpg'            => 'nullable|integer|min:1|max:100',
            'fuel_type'      => 'nullable|integer|exists:fuel_types,id',
            'description'    => 'required|string',
            'features'       => 'nullable|string',
            'history'        => 'nullable|string',
            'warrenty'       => 'nullable|string',
            'video_link_01'  => 'nullable|url',
            'video_link_02'  => 'nullable|url',
            'image.*'        => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validate->fails()) {
            return redirect()->back()->with('error', $validate->errors()->first())->withInput();
        }

        try {
            DB::beginTransaction();

            // Update existing vehicle
            $vehicle->name           = $data['name'];
            $vehicle->make           = $data['make'];
            $vehicle->model          = $data['model'];
            $vehicle->submodel       = $data['submodel'];
            $vehicle->category       = $data['category'];
            $vehicle->year           = $data['year'];
            $vehicle->price          = $data['price'];
            $vehicle->mileage        = $data['mileage'];
            $vehicle->color          = $data['color'];
            $vehicle->condition      = $data['condition'];
            $vehicle->body_type      = $data['body_type'];
            $vehicle->transmission   = $data['transmission'];
            $vehicle->size           = $data['size'];
            $vehicle->doors          = $data['doors'];
            $vehicle->exterior_color = $data['exterior_color'];
            $vehicle->interior_color = $data['interior_color'];
            $vehicle->drivetrain     = $data['drivetrain'];
            $vehicle->cylinder       = $data['cylinder'];
            $vehicle->mpg            = $data['mpg'];
            $vehicle->fuel_type      = $data['fuel_type'];
            $vehicle->description    = $data['description'];
            $vehicle->features       = $data['features'];
            $vehicle->history        = $data['history'];
            $vehicle->warrenty       = $data['warrenty'];
            $vehicle->video_link_01  = $data['video_link_01'];
            $vehicle->video_link_02  = $data['video_link_02'];

            // Update slug only if name is changed
            if ($vehicle->isDirty('name')) {
                $vehicle->slug = $this->generateUniqueSlug($request->name, Vehicle::class);
            }

            $vehicle->updated_by = Auth::id();
            $vehicle->save();

            // Handle images update
            if (!empty($data['image'])) {
                foreach ($data['image'] as $id => $value) {
                    $imageType = ImageType::find($id);

                    if (!$imageType || !($value instanceof \Illuminate\Http\UploadedFile) || !$value->isValid()) {
                        continue;
                    }

                    $folder = match ($imageType->type) {
                        'interior' => 'vehicle/interior',
                        'exterior' => 'vehicle/exterior',
                        default => null
                    };

                    if ($folder) {
                        $path = $this->fileUpload($value, $folder);

                        $model = $imageType->type === 'interior' ? VehicleInteriorImage::class : VehicleExteriorImage::class;

                        // Check if an image exists for this type and update it, otherwise create a new one
                        $existingImage = $model::where('vehicle_id', $vehicle->id)
                            ->where('image_type_id', $id)
                            ->first();

                        if ($existingImage) {
                            // Delete old image file if needed
                            Storage::delete($existingImage->image);
                            $existingImage->update(['image' => $path]);
                        } else {
                            $model::create([
                                'vehicle_id'    => $vehicle->id,
                                'image_type_id' => $id,
                                'image'         => $path,
                            ]);
                        }
                    }
                }
            }

            $vehicle->tags()->sync($data['tags'] ?? []);

            DB::commit();

            return redirect()->back()->with('success', 'Vehicle updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        $vehicle->delete();

        return redirect()->back()->with('success', 'Vehicle deleted successfully');
    }

    public function verified($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        $vehicle->update([
            'verified' => 1,
        ]);

        return redirect()->back()->with('success', 'Vehicle verified successfully');
    }

    public function status(Request $request)
    {
        $cate = Vehicle::find($request->id);


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
}

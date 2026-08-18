<?php

namespace App\Http\Controllers\API\Seller;

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
use App\Traits\apiresponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class VehicleController extends Controller
{
    use apiresponse;
    public function get(Request $request)
    {
        $query = Vehicle::query();

        // Filter by exact matches
        if ($request->has('body_type')) {
            $bodyTypes = explode(',', $request->body_type);
            $query->whereIn('body_type', $bodyTypes);
        }

        if ($request->has('size')) {
            $sizes = explode(',', $request->size);
            $query->whereIn('size', $sizes);
        }

        if ($request->has('category')) {
            $categories = explode(',', $request->category);
            $query->whereIn('category', $categories);
        }

        if ($request->has('make')) {
            $makes = explode(',', $request->make);
            $query->whereIn('make', $makes);
        }


        if ($request->has('transmission')) {
            $transmissions = explode(',', $request->transmission);
            $query->whereIn('transmission', $transmissions);
        }

        if ($request->has('fuel_type')) {
            $fuelTypes = explode(',', $request->fuel_type);
            $query->whereIn('fuel_type', $fuelTypes);
        }

        if ($request->has('drivetrain')) {
            $drivetrains = explode(',', $request->drivetrain);
            $query->whereIn('drivetrain', $drivetrains);
        }

        if ($request->has('exterior_color')) {
            $colors = explode(',', $request->exterior_color);
            $query->whereIn('exterior_color', $colors);
        }

        if ($request->has('interior_color')) {
            $colors = explode(',', $request->interior_color);
            $query->whereIn('interior_color', $colors);
        }

        if ($request->has('doors')) {
            $doors = explode(',', $request->doors);
            $query->whereIn('doors', $doors);
        }

        if ($request->has('cylinder')) {
            $cylinders = explode(',', $request->cylinder);
            $query->whereIn('cylinder', $cylinders);
        }

        // Search by name (partial match)
        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        // Year Range Filtering
        if ($request->has('min_year') && $request->has('max_year')) {
            $query->whereBetween('year', [$request->min_year, $request->max_year]);
        } elseif ($request->has('min_year')) {
            $query->where('year', '>=', $request->min_year);
        } elseif ($request->has('max_year')) {
            $query->where('year', '<=', $request->max_year);
        }

        // Price Range Filtering
        if ($request->has('min_price') && $request->has('max_price')) {
            $query->whereBetween('price', [$request->min_price, $request->max_price]);
        } elseif ($request->has('min_price')) {
            $query->where('price', '>=', $request->min_price);
        } elseif ($request->has('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Mileage Range Filtering
        if ($request->has('min_mileage') && $request->has('max_mileage')) {
            $query->whereBetween('mileage', [$request->min_mileage, $request->max_mileage]);
        } elseif ($request->has('min_mileage')) {
            $query->where('mileage', '>=', $request->min_mileage);
        } elseif ($request->has('max_mileage')) {
            $query->where('mileage', '<=', $request->max_mileage);
        }

        // MPG (Miles Per Gallon) Filtering
        if ($request->has('min_mpg') && $request->has('max_mpg')) {
            $query->whereBetween('mpg', [$request->min_mpg, $request->max_mpg]);
        } elseif ($request->has('min_mpg')) {
            $query->where('mpg', '>=', $request->min_mpg);
        } elseif ($request->has('max_mpg')) {
            $query->where('mpg', '<=', $request->max_mpg);
        }

        // Sorting (Optional)
        if ($request->has('sort_by')) {
            $sortColumn = $request->sort_by;
            $sortOrder = $request->has('sort_order') ? $request->sort_order : 'asc';
            if (in_array($sortColumn, ['name', 'year', 'price', 'mileage'])) {
                $query->orderBy($sortColumn, $sortOrder);
            }
        }

        // Pagination (Optional)
        if ($request->has('per_page')) {
            $vehicles = $query->paginate($request->per_page);
        } else {
            $vehicles = $query->get();
        }

        return $this->success($vehicles, 'Successfully!', 200);
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
            'tags'           => 'nullable|array',
            'tags.*'         => 'integer|exists:tags,id',
        ]);
        if ($validate->fails()) {
            return redirect()->back()->with('error', $validate->errors()->first())->withInput();
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
            $vehicle->body_type      = $data['body_type'];
            $vehicle->color          = $data['color'];
            $vehicle->condition      = $data['condition'];
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

            if (!empty($data['tags'])) {
                foreach ($data['tags'] as $tag) {
                    VehicleTag::create([
                        'vehicle_id' => $vehicle->id,
                        'tag_id'     => $tag,
                    ]);
                }
            }

            DB::commit();

            return $this->success($vehicle, 'Successfully!', 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage(), 'Something went wrong', 500);
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
            'tags'           => 'nullable|array',
            'tags.*'         => 'integer|exists:tags,id',
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

            return $this->success($vehicle, 'Successfully!', 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage(), 'Something went wrong', 500);
        }
    }

    public function destroy($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        $vehicle->delete();

        return $this->success([], 'Successfully!', 200);
    }

    public function status(Request $request)
    {
        // Validate the request to ensure 'id' is provided
        $request->validate([
            'id' => 'required|exists:vehicles,id',
        ]);

        $vehicle = Vehicle::find($request->id);

        // Toggle the status
        $vehicle->update([
            'status' => $vehicle->status === 'active' ? 'inactive' : 'active',
        ]);

        return $this->success($vehicle, 'Status Updated!', 200);

    }
}


<?php

namespace App\Http\Controllers\API\Seller;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ImageType;
use App\Models\Tag;
use App\Traits\apiresponse;
use Carbon\Carbon;
use Illuminate\Http\Request;

class VehicleDetailsController extends Controller
{
    use apiresponse;

    public function categories(Request $request)
    {
        $query = Category::query();

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

        $categories = $query->get();

        return $this->success($categories, 'Successfully!', 200);
    }

    public function brands(Request $request)
    {
        $query = Brand::query();

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

        $brands = $query->get();
        return $this->success($brands, 'Successfully!', 200);
    }
    public function tags(Request $request)
    {
        $query = Tag::query();

        $tags = $query->get();
        return $this->success($tags, 'Successfully!', 200);
    }

    public function imageType(Request $request)
    {
        $query = ImageType::query();

        $imageType = $query->get();

        return $this->success($imageType, 'Successfully!', 200);
    }

    public function years()
    {
        $years = [];  // Initialize the years array before the loop

        for ($i = Carbon::now()->year; $i >= 1900; $i--) {
            $years[] = $i;
        }

        return $this->success($years, 'Successfully!', 200);
    }

}

<?php

namespace App\Http\Controllers\API\Seller;

use App\Http\Controllers\Controller;
use App\Models\BodyType;
use App\Models\Color;
use App\Models\Cylinder;
use App\Models\Door;
use App\Models\Drivetrain;
use App\Models\FuelType;
use App\Models\Mileage;
use App\Models\MPG;
use App\Models\Size;
use App\Models\Transmission;
use App\Traits\apiresponse;
use Illuminate\Http\Request;

class SpecificationController extends Controller
{
    use apiresponse;

    public function bodyType(Request $request){
        $query = BodyType::query();

        $data = $query->get();

        return $this->success($data, 'Successfully!', 200);
    }
    public function transmission(Request $request){
        $query = Transmission::query();

        $data = $query->get();

        return $this->success($data, 'Successfully!', 200);
    }
    public function fuelType(Request $request){
        $query = FuelType::query();

        $data = $query->get();

        return $this->success($data, 'Successfully!', 200);
    }
    public function size(Request $request){
        $query = Size::query();

        $data = $query->get();

        return $this->success($data, 'Successfully!', 200);
    }
    public function door(Request $request){
        $query = Door::query();

        $data = $query->get();

        return $this->success($data, 'Successfully!', 200);
    }
    public function mileage(Request $request){
        $query = Mileage::query();

        $data = $query->get();

        return $this->success($data, 'Successfully!', 200);
    }
    public function drivetrain(Request $request){
        $query = Drivetrain::query();

        $data = $query->get();

        return $this->success($data, 'Successfully!', 200);
    }
    public function cylinder(Request $request){
        $query = Cylinder::query();

        $data = $query->get();

        return $this->success($data, 'Successfully!', 200);
    }
    public function mpg(Request $request){
        $query = MPG::query();

        $data = $query->get();

        return $this->success($data, 'Successfully!', 200);
    }
    public function color(Request $request){
        $query = Color::query();

        $data = $query->get();

        return $this->success($data, 'Successfully!', 200);
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleExteriorImage extends Model
{
    // fillable
    protected $fillable = [
        'vehicle_id',
        'image_type_id',
        'image',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function imageType()
    {
        return $this->belongsTo(ImageType::class);
    }
}

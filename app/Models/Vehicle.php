<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Vehicle extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name',
        'slug',
        'model',
        'submodel',
        'make',
        'category',
        'year',
        'price',
        'mileage',
        'color',
        'condition',
        'body_type',
        'transmission',
        'size',
        'doors',
        'exterior_color',
        'interior_color',
        'drivetrain',
        'cylinder',
        'mpg',
        'fuel_type',
        'description',
        'features',
        'history',
        'warrenty',
        'video_link_01',
        'video_link_02',
        'created_by',
        'updated_by',
        'status',
        'verified',
        'approved',
        'featured',
        'sold',
        'sold_by',
        'sold_at',
        'deleted_by',
    ];
    public function brand()
    {
        return $this->belongsTo(Brand::class, 'make');
    }
    public function cate()
    {
        return $this->belongsTo(Category::class, 'category');
    }
    public function relTo_color()
    {
        return $this->belongsTo(Color::class, 'color');
    }
    public function relTo_bodyType()
    {
        return $this->belongsTo(BodyType::class, 'body_type');
    }
    public function relTo_transmission()
    {
        return $this->belongsTo(Transmission::class, 'transmission');
    }
    public function relTo_size()
    {
        return $this->belongsTo(Size::class, 'size');
    }
    public function relTo_exteriorColor()
    {
        return $this->belongsTo(Color::class, 'exterior_color');
    }
    public function relTo_interiorColor()
    {
        return $this->belongsTo(Color::class, 'interior_color');
    }
    public function relTo_drivetrain()
    {
        return $this->belongsTo(Drivetrain::class, 'drivetrain');
    }
    public function relTo_cylinder()
    {
        return $this->belongsTo(Cylinder::class, 'cylinder');
    }
    public function relTo_mpg()
    {
        return $this->belongsTo(MPG::class, 'mpg');
    }
    public function relTo_fuelType()
    {
        return $this->belongsTo(FuelType::class, 'fuel_type');
    }
    public function relTo_doors()
    {
        return $this->belongsTo(Door::class, 'doors');
    }
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'vehicle_tags', 'vehicle_id', 'tag_id');
    }
    public function soldBy()
    {
        return $this->belongsTo(User::class, 'sold_by');
    }
    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    public function reviews(): MorphMany
    {
        return $this->morphMany(Review::class, 'reviewable');
    }
}

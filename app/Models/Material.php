<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'material_class_id',
        'material_division_id',
        'unique_id',
        'default_unit',
        'description',
        'measurement_unit',
        'height',
        'width',
        'length',
        'prices',
        'waste',
        'production_rate',
        'subbed_out_rate',
        'production_subed_out_cost',
        'cleaning_cost',
        'cleaning_subed_out',
        'associated_products'
    ];

    public function material_class() {
       return  $this->belongsTo(MaterialClass::class);
    }
    public function material_division() {
      return $this->belongsTo(MaterialDivision::class);
    }
    public function user() {
      return $this->belongsTo(User::class);
    }
    
}

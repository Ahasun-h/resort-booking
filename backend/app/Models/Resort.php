<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resort extends Model
{
    use HasFactory;

    public function resortImage()
    {
        return $this->hasMany(ResortImage::class,'resort_id');
    }
}

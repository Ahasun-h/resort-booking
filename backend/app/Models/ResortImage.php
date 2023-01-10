<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class ResortImage extends Model
{
    use HasFactory;

    // Relation With Bank
    public function resort() {
        return $this->belongsTo(Resort::class, 'resort_id');
    }
}

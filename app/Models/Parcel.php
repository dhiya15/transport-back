<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parcel extends Model
{
    use HasFactory;

    protected $guarded = [
        "created_at",
        "updated_at",
        "id"
    ];

    public function parcel_requests()
    {
        return $this->hasMany(Parcelrequest::class);
    }
}

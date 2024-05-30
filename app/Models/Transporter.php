<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transporter extends Model
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

    public function transport_requests()
    {
        return $this->hasMany(Transportrequest::class);
    }
}

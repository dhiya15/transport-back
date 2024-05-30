<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    use HasFactory;

    protected $guarded = [
        "created_at",
        "updated_at",
        "id"
    ];

    public function transport_requests()
    {
        return $this->hasMany(Transportrequest::class);
    }
}

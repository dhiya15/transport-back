<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transportrequest extends Model
{
    use HasFactory;

    protected $guarded = [
        "created_at",
        "updated_at",
        "id"
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }

    public function transporter()
    {
        return $this->belongsTo(Transporter::class);
    }
}

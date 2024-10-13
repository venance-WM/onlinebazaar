<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    use HasFactory;
    protected $fillable = [
        'admin_id',
        'agent_id',
        'action',
        'status',
        'service_data',
    ];

    protected $casts = [
        'service_data' => 'array', // Automatically decode JSON to an array
        'status' => 'string',      // Cast status to string (optional but can be helpful)
        'action' => 'string',      // Cast action to string (optional)
    ];
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
}


<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Installation extends Model
{
    use HasFactory;

    protected $fillable = [
        'opportunity_id',
        'technician_id',
        'scheduled_start',
        'scheduled_end',
        'status',
        'progress',
        'photos',
        'checklist',
    ];
    
    protected $casts = [
        'scheduled_start' => 'datetime',
        'scheduled_end' => 'datetime',
        'photos' => 'array',
        'checklist' => 'array',
    ];

    public function opportunity()
    {
        return $this->belongsTo(Opportunity::class);
    }

    public function technician()
    {
        return $this->belongsTo(User::class, 'technician_id');
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }
}
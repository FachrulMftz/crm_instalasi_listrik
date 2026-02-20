<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
    'user_id',
    'installation_id',
    'opportunity_id',
    'customer_id',
    'type',
    'subject',
    'description',
    'activity_date',
    'status',
    ];

    protected $casts = [
        'activity_date' => 'datetime',
    ];
    
    protected static function booted()
    {
        static::deleting(function ($activity) {
            if ($activity->installation) {
                $activity->installation->delete();
            }
        });
    }


    /**
     * Relasi ke User (Sales)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke Opportunity
     */
    public function opportunity()
    {
        return $this->belongsTo(Opportunity::class);
    }

    /**
     * Relasi ke Customer
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function installation()
    {
        return $this->belongsTo(Installation::class);
    }
    /**
     * Scope untuk activity hari ini
     */
    public function scopeToday($query)
    {
        return $query->whereDate('activity_date', today());
    }
    /**
     * Scope untuk activity yang planned
     */
    public function scopePlanned($query)
    {
        return $query->where('status', 'planned');
    }

    /**
     * Scope untuk activity yang completed
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
}
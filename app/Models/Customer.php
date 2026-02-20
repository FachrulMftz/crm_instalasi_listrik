<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'company',
    ];

    /**
     * Relasi ke Opportunities
     */
    public function opportunities()
    {
        return $this->hasMany(Opportunity::class);
    }

}
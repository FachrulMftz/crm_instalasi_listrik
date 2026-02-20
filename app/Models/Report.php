<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'installation_id',
        'kondisi_lokasi',
        'material_terpasang',
        'hasil_pengujian',
        'catatan',
        'dokumentasi',
    ];

    public function installation()
    {
        return $this->belongsTo(Installation::class);
    }
    public function create($installationId)
{
    $installation = Installation::findOrFail($installationId);

    return view('teknisi.report.create', compact('installation'));
}
    
}

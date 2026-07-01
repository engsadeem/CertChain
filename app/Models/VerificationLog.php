<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VerificationLog extends Model
{
    protected $fillable = [
        'certificate_id',
        'verifier_name',
        'verifier_org',
        'verifier_email',
        'ip_address',
        'is_valid',
        'verified_at',
    ];

    public $timestamps = false;

    protected $casts = [
        'is_valid' => 'boolean',
        'verified_at' => 'datetime',
    ];

    public function certificate(): BelongsTo
    {
        return $this->belongsTo(Certificate::class);
    }
}

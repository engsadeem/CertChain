<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Storage;

class Certificate extends Model
{
    protected $fillable = [
        'student_id',
        'issued_by',
        'certificate_id',
        'file_path',
        'qr_path',
        'keccak256_hash',
        'tx_hash',
        'contract_address',
        'status',
    ];

    protected $appends = ['file_url'];

    public function getFileUrlAttribute(): ?string
    {
        if (! $this->file_path) {
            return null;
        }

        if (filter_var($this->file_path, FILTER_VALIDATE_URL)) {
            return $this->file_path;
        }

        if (Storage::disk('public')->exists($this->file_path)) {
            return route('public.files.show', ['path' => $this->file_path]);
        }

        return str_starts_with($this->file_path, '/') ? $this->file_path : asset($this->file_path);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function issuedBy(): BelongsTo
    {
        return $this->belongsTo(University::class, 'issued_by');
    }

    public function blockchainRecord(): HasOne
    {
        return $this->hasOne(BlockchainRecord::class);
    }

    public function verificationLogs(): HasMany
    {
        return $this->hasMany(VerificationLog::class);
    }
}

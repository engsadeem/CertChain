<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BlockchainRecord extends Model
{
    protected $fillable = [
        'certificate_id',
        'tx_hash',
        'block_number',
        'network',
        'smart_contract',
        'committed_at',
    ];

    public $timestamps = false;

    public function certificate(): BelongsTo
    {
        return $this->belongsTo(Certificate::class);
    }
}

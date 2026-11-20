<?php
namespace App\Models;

// Model: allows this class to communicate with the database.
use Illuminate\Database\Eloquent\Model;

// BelongsTo: defines the relationship with another model.
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CertificateReminder extends Model
{
    // Columns Laravel is allowed to fill automatically.
    protected $fillable = [
        'certificate_id',
        'reminder_type',
        'inspection_date',
        'status',
        'sent_at',
        'provider_message_id',
        'error_message',
    ];

    // Convert database dates into PHP date objects.
    protected function casts(): array
    {
        return [
            'inspection_date' => 'date',
            'sent_at' => 'datetime',
        ];
    }

    // Each reminder belongs to one certificate.
    public function certificate(): BelongsTo
    {
        return $this->belongsTo(Certificate::class);
    }
}

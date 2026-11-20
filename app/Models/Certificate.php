<?php

namespace App\Models;

// Model connects this class to the database.
use Illuminate\Database\Eloquent\Model;

// BelongsTo defines the relationship with a customer.
use Illuminate\Database\Eloquent\Relations\BelongsTo;
// HasMany: defines a relationship with multiple reminder records.
use Illuminate\Database\Eloquent\Relations\HasMany;
class Certificate extends Model
{
    // These fields are allowed to be saved through mass assignment.
    protected $fillable = [
        'customer_id',
        'certificate_number',
        'issue_date',
        'next_inspection_date',
        'booking_url',
    ];

    // Convert database date values into date objects.
    protected function casts(): array
    {
        return [
            'issue_date' => 'date',
            'next_inspection_date' => 'date',
        ];
    }

    // Each certificate belongs to one customer.
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
    // One certificate can have multiple reminder records.
    public function reminders(): HasMany
    {
         return $this->hasMany(CertificateReminder::class);
    }
    // Automatically calculate the certificate renewal status.
    public function renewalStatus(): string
    {
        $today = now()->startOfDay();

        $inspectionDate = $this->next_inspection_date
            ->copy()
            ->startOfDay();

        // Inspection date has already passed.
        if ($inspectionDate->isBefore($today)) {
            return 'Overdue';
        }

        // Inspection is due within the next 30 days.
        if ($inspectionDate->lessThanOrEqualTo($today->copy()->addDays(30))) {
            return 'Due Soon';
        }

        // Inspection is more than 30 days away.
        return 'Up to Date';
    }
}

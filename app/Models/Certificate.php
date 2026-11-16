<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Certificate extends Model
{
    protected $fillable = [
        'customer_id',
        'certificate_number',
        'issue_date',
        'next_inspection_date',
        'booking_url',
    ];

    protected function casts(): array
    {
        return [
            'issue_date' => 'date',
            'next_inspection_date' => 'date',
        ];
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
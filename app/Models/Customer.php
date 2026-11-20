<?php
namespace App\Models;

// Model: allows this class to communicate with the database.
use Illuminate\Database\Eloquent\Model;

// HasMany: defines a relationship with multiple certificates.
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'is_active', // Allows us to archive and restore customers.
    ];

    // One customer can have multiple certificates.
    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class);
    }
}

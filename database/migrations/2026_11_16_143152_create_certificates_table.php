
<?php

// Migration: provides instructions for changing the database structure.
use Illuminate\Database\Migrations\Migration;

// Blueprint: lets us define the columns and their data types.
use Illuminate\Database\Schema\Blueprint;

// Schema: provides methods for creating and deleting tables.
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migration.
     * Create the certificates table.
     */
    public function up(): void
    {
        Schema::create('certificates', function (Blueprint $table) {

            // Unique ID for each certificate.
            $table->id();

            // Connect each certificate to an existing customer.
            $table->foreignId('customer_id')
                  ->constrained()
                  ->restrictOnDelete();;

            // Reference number printed on the certificate.
            $table->string('certificate_number')->unique();

            // Date when the certificate was issued.
            $table->date('issue_date');

            // Actual date of the next required inspection.
            $table->date('next_inspection_date');

            // External booking page; optional.
            $table->string('booking_url')->nullable();

            // Automatically track record creation and updates.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migration.
     * Delete the certificates table if rolled back.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};

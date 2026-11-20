
<?php

// Migration: provides instructions for changing the database structure.
use Illuminate\Database\Migrations\Migration;

// Blueprint: lets us define table columns and their data types.
use Illuminate\Database\Schema\Blueprint;

// Schema: provides methods for creating and deleting database tables.
use Illuminate\Support\Facades\Schema;

// Create an anonymous migration class.
return new class extends Migration
{
    /**
     * Run the migration.
     * Create the certificate reminders table.
     */
    public function up(): void
    {
        Schema::create('certificate_reminders', function (Blueprint $table) {

            // Unique ID for each reminder record.
            $table->id();

            // Connect the reminder to its certificate.
            // If a certificate is deleted, its reminder records are deleted too.
            $table->foreignId('certificate_id')
                  ->constrained()
                  ->cascadeOnDelete();

            // Type of reminder: 30_day or 7_day.
            $table->string('reminder_type');

            // Inspection date this reminder belongs to.
            // Helps distinguish reminders for different renewal cycles.
            $table->date('inspection_date');

            // Track the reminder's progress.
            // New reminders start as pending.
            $table->string('status')->default('pending');

            // Store the time when the SMS was successfully sent.
            $table->timestamp('sent_at')->nullable();

            // Store the message ID returned by an SMS provider.
            $table->string('provider_message_id')->nullable();

            // Store an error if sending the reminder fails.
            $table->text('error_message')->nullable();

            // Prevent duplicate reminders for the same certificate,
            // reminder type, and inspection date.
            $table->unique(
                ['certificate_id', 'reminder_type', 'inspection_date'],
                'unique_certificate_reminder'
            );

            // Automatically track when records are created or updated.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migration.
     * Delete the reminder table if rolled back.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificate_reminders');
    }
};

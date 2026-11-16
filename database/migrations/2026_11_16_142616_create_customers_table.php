
<?php

// Migration: provides Laravel instructions for database changes.
use Illuminate\Database\Migrations\Migration;

// Blueprint: helps us define the columns inside a database table.
use Illuminate\Database\Schema\Blueprint;

// Schema: helps us create and delete database tables.
use Illuminate\Support\Facades\Schema;

// Return an anonymous migration class.
return new class extends Migration
{
    /**
     * Run the migrations.
     * This creates the customers table.
     */
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {

            // Unique ID for each customer.
            $table->id();

            // Customer's full name.
            $table->string('name');

            // Email is optional because not every customer may provide one.
            $table->string('email')->nullable();

            // Customer's phone number for SMS reminders.
            $table->string('phone', 20);

            // Customer's address; optional.
            $table->text('address')->nullable();

            // Automatically stores record creation and update times.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migration.
     * This deletes the customers table if we roll back.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};

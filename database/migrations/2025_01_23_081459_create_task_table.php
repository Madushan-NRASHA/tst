<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedBigInteger('user_id'); // Foreign key for the User model
            $table->string('task_site')->nullable(); // Task Site - Nullable, as the form doesn't have it marked as required
            $table->string('task_name'); // Task name
            $table->integer('qty')->nullable(); // Quantity (nullable as it might not be provided)
            $table->string('task_type')->nullable(); // Task type (nullable)
            $table->string('status')->default('pending'); // Default value for status
            $table->string('Coordinator_status')->default('pending');
            $table->string('priority'); // Task priority

            // For start and end date/time
            $table->date('start_date'); // Task start date
            $table->date('end_date'); // Task end date
            $table->string('start_time'); // Task start time (HH:MM AM/PM)
            $table->string('end_time'); // Task end time (HH:MM AM/PM)

            $table->unsignedBigInteger('allocated_by'); // Allocated by (foreign key reference to the user)
            $table->timestamps(); // Created at and updated at columns

            // Add department_id as a foreign key (nullable in case not every task has a department)
            $table->unsignedBigInteger('department_id')->nullable();

            // Foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('allocated_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('set null'); // On delete set to null for departments
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
};

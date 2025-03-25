<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeneralTaskTable extends Migration
{
    public function up()
    {
        Schema::create('general_task', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedBigInteger('user_id'); // Foreign key for the User model
            $table->string('userType')->default('general_task'); // Default user type
            $table->string('task_site')->nullable(); // Task Site (nullable)
            $table->string('task_name'); // Task name
            $table->integer('qty')->nullable(); // Quantity (nullable)
            $table->string('task_type')->nullable(); // Task type (nullable)
            $table->string('status')->default('pending'); // Task status with default value
            $table->string('Coordinator_status')->default('pending'); // Coordinator status with default value
            $table->string('priority'); // Task priority (required)

            // Start and end date/time
            $table->date('start_date'); // Task start date
            $table->date('end_date'); // Task end date
            $table->string('start_time'); // Task start time (HH:MM AM/PM)
            $table->string('end_time'); // Task end time (HH:MM AM/PM)

            // Allocated by field (foreign key to User)
            $table->unsignedBigInteger('allocated_by'); 

            // Add department_id as a foreign key (nullable)
            $table->unsignedBigInteger('department_id')->nullable();

            $table->timestamps(); // Created at and updated at columns

            // Foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // Foreign key to the users table
            $table->foreign('allocated_by')->references('id')->on('users')->onDelete('cascade'); // Foreign key to the users table (allocated_by)
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('set null'); // Foreign key to the departments table (nullable)
        });
    }

    public function down()
    {
        // Drop the table if migration is rolled back
        Schema::dropIfExists('general_task');
    }
}

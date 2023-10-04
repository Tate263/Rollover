<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //
        Schema::create('student_program_status',function (Blueprint $table) {
            $table->increments('id');
            $table->string('status');
            $table->string('session');
            $table->string('part');
            $table->string('semester');
            $table->string('year');
            $table->string('studentNumber');
            $table->timestamps();
        });
       
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};

<?php
 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentProgramStatus extends Model

{
    protected $table = 'student_program_status'; // Specify the table name

    protected $fillable = ['session', 'status','part', 'semester','year','studentNumber']; // Define fillable attributes

    // Add any other attributes as needed

    // Define relationships if applicable
}

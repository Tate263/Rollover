<?php

namespace App\Http\Controllers;
//use App\StudentProgramStatus;
use Illuminate\Http\Request;
use App\Models\StudentProgramStatus;

class StudentProgramStatusController extends Controller
{
    public function rollOver(Request $request)
    {
        // Get all students from the old session (e.g., 2022-2023) except Part 4 Semester 2
        $oldSessionStudents = StudentProgramStatus::where('session', '2022-2023')
            ->where('status', 'Current')
            ->where(function ($query) {
                $query->where('part', '!=', 4) // Exclude Part 4
                    ->orWhere(function ($subQuery) {
                        $subQuery->where('part', 4)->where('semester', '!=', 2); // Exclude Part 4 Semester 2
                    });
            })
            ->get();
            
        foreach ($oldSessionStudents as $student) {
            // Store the values you want to preserve
            $studentNumber = $student->studentNumber;
            $year = $student->year;

            // Update the status of current records to 'Old'
            if ($student->status === 'Current') {
                $student->update(['status' => 'Old']);
            }

            // Determine the new part and semester for the student
            $newPart = $student->part;
            $newSemester = $student->semester;

            if ($student->part == 1) {
                if ($student->semester == 1) {
                    $newSemester = 2; // Move to Part 1 Semester 2
                } else {
                    $newPart = 2; // Move to Part 2 Semester 1
                    $newSemester = 1;
                }
            } elseif ($student->part == 2) {
                if ($student->semester == 1) {
                    $newSemester = 2; // Move to Part 2 Semester 2
                } else {
                    $newPart = 3; // Move to Part 3 Semester 1
                    $newSemester = 1;
                }
            } elseif ($student->part == 3) {
                if ($student->semester == 1) {
                    $newSemester = 2; // Move to Part 3 Semester 2
                } else {
                    $newPart = 4; // Move to Part 4 Semester 1
                    $newSemester = 1;
                }
            } elseif ($student->part == 4) {
                $newPart = 4; // Remain in Part 4
                if ($student->semester == 1) {
                    $newSemester = 2; // Move to Part 4 Semester 2
                }
            }

            // Create a new record for the student in the new session (e.g., 2023-2024) with 'Current' status
            StudentProgramStatus::create([
                'session' => '2023-2024',
                'part' => $newPart,
                'semester' => $newSemester,
                'status' => 'Current',
                'year' => $year,
                'studentNumber' => $studentNumber,
                // Other fields as needed
            ]);
        }

        // Redirect back with a success message
        return redirect()->back()->with('status', 'Students have been rolled over.');
    }
}
//In this updated code, we use the create method to create a new student record and then save it to the database. This should create new records for the rolled-over students without updating the existing ones.






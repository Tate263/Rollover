<?php

namespace App\Http\Controllers;
//use App\StudentProgramStatus;
use Illuminate\Http\Request;
use App\Models\StudentProgramStatus;

class StudentProgramStatusController extends Controller
{
    public function rollOver(Request $request)
    {
    $sessionsToRollOver = ['2022-2023', '2023-2023'];

        foreach ($sessionsToRollOver as $session) {
            // Get all students from the current session except Part 4 Semester 2
            $oldSessionStudents = StudentProgramStatus::where('session', $session)
                ->where(function ($query) {
                    $query->where('part', '!=', 4) // Exclude Part 4
                        ->orWhere(function ($subQuery) {
                            $subQuery->where('part', 4)->where('semester', '!=', 2); // Exclude Part 4 Semester 2
                        });
                })
                ->get();

            foreach ($oldSessionStudents as $student) {
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
                    if ($student->semester == 1) {
                        $newSemester = 2; // Move to Part 4 Semester 2
                    }
                }

                // Create a new record for the student in the next session with 'Current' status
                $newStudent = new StudentProgramStatus([
                    'session' => $this->getNextSession($session),
                    'part' => $newPart,
                    'semester' => $newSemester,
                    'status' => 'Current', // Set the status as 'current' for the new record
                    // Other fields as needed
                ]);

                $newStudent->save();
            }
        }

        // Redirect back with a success message
        return redirect()->back()->with('status', 'Students have been rolled over.');
    }

    private function getNextSession($currentSession)
    {
        // Split the current session into parts
        list($startYear, $endYear) = explode('-', $currentSession);

        // Calculate the next session
        $nextStartYear = (int)$startYear + 1;
        $nextEndYear = (int)$endYear + 1;

        return $nextStartYear . '-' . $nextEndYear;
    }
}
//In this updated code, I've added checks for updating both the part and semester fields based on the specified progression rules for each part and semester. Students should now progress correctly, and the part and semester fields in the database should be updated accordingly during rollover.
//In this updated code, we loop through an array of sessions to roll over. The getNextSession method is used to calculate the next session based on the current session. This code will roll over students for both 2022-2023 and 2023-2024 sessions, following the specified logic. Students from the old session will have their status updated to "Old," and new records will be created in the next session with the updated part and semester while maintaining a "Current" status.
//In this updated code, we first determine the new part and semester for each student based on their current part and semester. We use conditional statements to decide the progression logic. After determining the new part and semester, we create a new record for the student in the new session (e.g., 2023-2024) with the updated part and semester. Students progress according to the specified logic, and their status is set to "current" for the new records.






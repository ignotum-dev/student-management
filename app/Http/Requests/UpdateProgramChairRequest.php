<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProgramChairRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        $auth_user = auth()->user();
        // $userToUpdate = $this->route('user'); // Retrieve the user from the route
        // $programChair = $userToUpdate->programChair;

        // Check if the current user is allowed to update the role
        if ($this->has('role') && !$auth_user->isSuperAdmin()) {
            abort(403, 'Not authorized to edit the role.');
        }

        // Prevent student and program chair from updating student number
        if ($this->has('student_number') && ($auth_user->isStudent() || $auth_user->isProgramChair())) {
            abort(403, 'Not authorized to edit the student number.');
        }

        return true;
    }

    public function prepareForValidation()
    {
        $this->merge([
            'user' => $this->route('user'), // Assuming 'user' is the route parameter
            'programChair' => $this->route('user')->programChair, // Assuming User has a related program chair
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $user = $this->user;
<<<<<<< HEAD
        $student = $this->student;

        return [
            'role' => 'sometimes|string|exists:roles,role',
            'student_number' => [
                'sometimes',
                'string',
                'max:10',
                'unique:students,student_number,',
                // Rule::unique('students', 'student_number')->ignore($student->student_number),
            ],
=======
        // $programChair = $this->programChair;

        return [
            'role' => 'sometimes|string|exists:roles,role',
>>>>>>> d3f1ffb5e7265c7b67bee239ff3fbc563bf4d133
            'first_name' => 'sometimes|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'sometimes|string|max:255',
            'email' => [
                'sometimes',
                'email',
                'unique:users,email,' . $user->id,
            ],
            // 'password' => 'nullable|string|min:8|confirmed',
            'course' => 'sometimes|string|exists:courses,course',
            'department' => 'sometimes|string|exists:departments,department',
            'year' => 'sometimes|in:First Year,Second Year,Third Year,Fourth Year',
            'dob' => 'sometimes|date',
            'age' => 'sometimes|integer|min:18|max:100',
            'sex' => 'sometimes|in:Male,Female',
            'c_address' => 'sometimes|string|max:255',
            'h_address' => 'sometimes|string|max:255',
        ];
    }
}

<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;

class CreatePorjectTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'assignee_id'  => 'required|exists:users,id',
            'title'        => 'required|string|max:255',
            'description'  => 'required|string',
            'status'       => 'required|in:todo,in_progress,done',
            'priority'     => 'required|in:low,medium,high',
            'due_date'     => 'required|date',
        ];
    }
}

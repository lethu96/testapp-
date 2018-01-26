<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TestRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'=>'regex:/^[A-Za-z0-9,\-\.]+$/|max:10',
            'information'=>'max:300',
            'deadline'=>'date|after:now',
            'type'=>'in: "lab", "single", "acceptance"',
            'status'=>'in: "planned", "onhold", "doing", "done","cancelled"',
        ];
    }
    public function response(array $errors)
    {
        return response()->json(['error' => $errors]);
    }
}

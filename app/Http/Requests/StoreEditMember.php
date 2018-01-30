<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEditMember extends FormRequest
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
            'name' => 'regex:/^[A-Za-z0-9,\-\.]+$/|max:50',
            'information' =>'max:300',
            'phone_number'=>'regex:/^[\(\)\-\.\+\/0-9]+$/|max:20',
            'birthday'=>'date|before:now|after:60 year ago',
            'position_id'=>'integer',
            'avatar'=>'mimes:gif,png,jpeg|max:10240',
            'gender'=>'in:"male","female"'
        ];
    }
}

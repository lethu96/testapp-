<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCreateMember extends FormRequest
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
            'name' => 'required|regex:/^[A-Za-z0-9,\-\.]+$/|max:50',
            'information' =>'max:300',
            'phone_number'=>'required|regex:/^[\(\)\-\.\+\/0-9]+$/|max:20',
            'birthday'=>'required|date|before:yesterday|after:60 year ago',
            'position_id'=>'required',
            'avatar'=>'required|mimes:png,jpeg,gif|max:10240',
            'gender'=>'required|in:"male","female"'
        ];
    }
}

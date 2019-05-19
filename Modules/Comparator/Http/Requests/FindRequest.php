<?php

namespace Modules\Comparator\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FindRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'firstPackage' => 'required|string',
            'secondPackage' => 'required|string',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [
            'firstPackage.required' => 'First package is required!',
            'secondPackage.required' => 'Second package is required!',
        ];
    }
}

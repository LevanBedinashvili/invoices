<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInvoiceRequest extends FormRequest
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
            'first_name' => 'required',
            'last_name' => 'required',
            'personal_number' => 'sometimes',
            'mobile_number' => 'sometimes',
            'date_of_birth' => 'sometimes',
            'payment_type_id' => 'required',
            'branch_id' => 'required',
        ];
    }
}

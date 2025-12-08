<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SupplierRequest extends FormRequest
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

        $supplierId = $this->route('supplier')?->id;

        return [
            'fname' => 'required|max:30',
            'mname' => 'nullable|max:15',
            'lname' => 'required|max:15',
            'contact_number' => [
                'required',
                'string',
                'max:11',
                Rule::unique('suppliers', 'contact_number')->ignore($supplierId)
            ],
            'company_name' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('suppliers', 'company_name')->ignore($supplierId)
            ],
            // 'contact_number' => 'required|string|unique',
            // 'company_name' => 'required|string|unique',
            'company_address' => 'nullable|string'
        ];
    }

    public function messages(){
        return [
            'fname.required' => 'This field is required', 
        
        
        ];
    }
}

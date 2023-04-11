<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequestRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'pet_id' => 'required | numeric',
            'from' => 'required | date',
            'till' => 'required | date',
            'hourly_rate' => 'required | numeric'
        ];
    }

    public function handleRequest(){
        $data = $this->validated();
        $data['owner_id'] = Auth::user()->id;
        return $data;
    }
}

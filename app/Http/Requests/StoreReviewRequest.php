<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReviewRequest extends FormRequest
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
            'request_id' => 'required | numeric',
            'rating' => 'required | numeric | min:1 | max:5',
            'comment' => 'nullable | string',
        ];
    }

    public function handleRequest(){
        $data = $this->validated();
        return $data;
    }
}

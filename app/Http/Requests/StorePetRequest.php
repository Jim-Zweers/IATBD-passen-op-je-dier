<?php

namespace App\Http\Requests;

use App\Enums\Type;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Foundation\Http\FormRequest;

class StorePetRequest extends FormRequest
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
            'name' => 'required | string',
            'description' => 'nullable | string',
            'type' => ['required', new Enum(Type::class)],
            'image' => 'required | image'
        ];
    }

    public function handleRequest(){
        $data = $this->validated();
        $data['owner_id'] = Auth::user()->id;
        return $data;
    }
}

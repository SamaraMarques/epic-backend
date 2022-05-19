<?php

namespace App\Http\Requests\SectorAnswer;

use Illuminate\Foundation\Http\FormRequest;

class CreateSectorAnswerRequest extends FormRequest
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
            'gin' => ['required', 'numeric', 'min:1', 'max:3'],
            'gci' => ['required', 'numeric', 'min:1', 'max:3'],
            'answers' => ['required'],
        ];
    }
}

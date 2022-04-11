<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class PostStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'website_id'     => ['required','exists:websites,id'],
            'title'         => ['required','min:3','max:50'],
            'description'   => ['required','min:10', 'max:191'],
            'status'       => ['nullable','boolean'],
        ];
    }
}

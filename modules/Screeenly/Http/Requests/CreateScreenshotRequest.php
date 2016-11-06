<?php

namespace Screeenly\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateScreenshotRequest extends FormRequest
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
            'key'    => ['required', 'exists:api_keys,key'],
            'url'    => ['required', 'url'], // Is 'active_url' reliable enough?
            'width'  => ['sometimes', 'required', 'integer'],
            'height' => ['sometimes', 'required', 'integer'],
        ];
    }
}

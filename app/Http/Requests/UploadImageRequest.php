<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadImageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'iamge' => 'image|mimes:jpg,jpeg,png|max;2048',
            'files.*.iamge' => 'image|mimes:jpg,jpeg,png|max;2048',
            // 'image' => 'image|mimes:png|max:2048',

        ];
    }

    public function authorize()
    {
        return [
            'image' => '指定されたファイルが画像ではありません',
            'mimes' => '指定した拡張子（jpg/jpeg/png）',
            'max' => 'ファイルサイズは２MB以内にしてください',
        ];
    }
}

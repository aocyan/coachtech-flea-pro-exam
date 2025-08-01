<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
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
            'image' => 'mimes:jpeg,png',
            'comment' => 'required|max:400',
        ];
    }

    public function messages()
    {
        return [
            'image.mimes' => '「.png]または「.jpeg」形式でアップロードしてください',
            'comment.required' => '本文を入力してください',
            'comment.max' => '本文は400文字以内で入力してください',          
        ];
    }
}

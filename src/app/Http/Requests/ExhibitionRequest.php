<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
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
            'postal' => 'required|digits:8',
            'address' => 'required',
            'building' => 'required',
        ];
    }

     public function messages()
    {
        return [
            'pay.required' => '支払方法を選択してください',
            'postal.required' => '郵便番号が入力されていません',
            'postal.digits' => '郵便番号が８文字になっていません',
            'address.required' => '住所が入力されていません',
            'building.required' => '建物名が入力されていません',
        ];
    }
}

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
            'image' => 'required|mimes:jpeg,png',
            'category' => 'required|array|min:1',
            'category.*' => 'integer',
            'condition' => 'required|in:良好,目立った傷や汚れなし,やや傷や汚れあり,状態が悪い',
            'name' => 'required',
            'description' => 'required|max:255',
            'price' => 'required|numeric|min:0',
        ];
    }

     public function messages()
    {
        return [
            'image.required' => '商品画像を選択してください',
            'image.mimes' => '画像の拡張子は.jpegまたは.pngです',
            'category.required' => 'カテゴリーを選択してください',
            'category.min' => 'カテゴリーを選択してください',
            'condition.required' => '商品の状態を選択してください',
            'condition.in' => '商品の状態を選択してください',
            'name.required' => '商品名を入力してください',
            'description.required' => '商品の説明を入力してください',
            'description.max' => '商品の説明は255文字以内で入力してください',
            'price.required' => '販売価格を入力してください',
            'price.numeric' => '販売価格は数字で入力してください',
            'price.min' => '販売価格は0以上で入力してください',          
        ];
    }
}

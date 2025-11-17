<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    // バリデーションエラー時に入力画面へ戻す
    protected $redirectRoute = 'contacts.index';

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'last_name'  => ['required','string','max:20'],
            'first_name' => ['required','string','max:20'],

            'gender'     => ['required'],

            'email'      => ['required','email:filter'],

            'tel1'       => ['required','digits:3'],
            'tel2'       => ['required','digits:4'],
            'tel3'       => ['required','digits:4'],

            'address'    => ['required','string','max:255'],

            'building'   => ['nullable','string','max:255'],

            'category_id'=> ['required','integer','exists:categories,id'],

            // ★ フォームに合わせて detail に修正！！！！
            'detail'     => ['required','string','max:120'],
        ];
    }

    public function messages(): array
    {
        return [

            'last_name.required'   => 'お名前（姓）を入力してください',
            'first_name.required'  => 'お名前（名）を入力してください',

            'gender.required'      => '性別を選択してください',

            'email.required'       => 'メールアドレスを入力してください',
            'email.email'          => 'メールアドレスはメール形式で入力してください',

            'tel1.required'        => '電話番号を入力してください',
            'tel2.required'        => '電話番号を入力してください',
            'tel3.required'        => '電話番号を入力してください',

            'tel1.digits'          => '電話番号は半角数字で入力してください',
            'tel2.digits'          => '電話番号は半角数字で入力してください',
            'tel3.digits'          => '電話番号は半角数字で入力してください',

            'address.required'     => '住所を入力してください',

            'detail.required'      => 'お問い合わせ内容を入力してください',
            'detail.max'           => 'お問い合わせ内容は120文字以内で入力してください',

            'category_id.required' => 'お問い合わせの種類を選択してください',
            'category_id.integer'  => 'お問い合わせの種類を正しく選択してください',
            'category_id.exists'   => 'お問い合わせの種類を正しく選択してください',
        ];
    }

    public function attributes(): array
    {
        return [
            'last_name'  => 'お名前（姓）',
            'first_name' => 'お名前（名）',
            'gender'     => '性別',
            'email'      => 'メールアドレス',
            'tel1'       => '電話番号(先頭3桁)',
            'tel2'       => '電話番号(中間4桁)',
            'tel3'       => '電話番号(末尾4桁)',
            'address'    => '住所',
            'building'   => '建物名',
            'category_id'=> 'お問い合わせの種類',

            // ★ ここも detail に統一
            'detail'     => 'お問い合わせ内容',
        ];
    }
}

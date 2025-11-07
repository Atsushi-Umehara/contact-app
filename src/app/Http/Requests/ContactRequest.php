<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $tel = $this->input('tel');

        if (!$tel) {
            $t1 = (string) $this->input('tel1', '');
            $t2 = (string) $this->input('tel2', '');
            $t3 = (string) $this->input('tel3', '');
            $tel = $t1.$t2.$t3;
        }

        if (function_exists('mb_convert_kana')) {
            $tel = mb_convert_kana($tel, 'n');
        }

        $tel = preg_replace('/\D+/', '', $tel);

        $this->merge([
            'tel' => $tel,
        ]);
    }

    public function rules()
    {
        return [
            'last_name'   => ['required', 'string', 'max:8'],
            'first_name'  => ['required', 'string', 'max:8'],
            'gender' => ['required', 'in:1,2,3'],
            'email'       => ['required', 'email', 'max:255'],
            'tel'         => ['required', 'regex:/^\d{10,11}$/'],
            'address'     => ['required', 'string', 'max:255'],
            'building'    => ['nullable', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'detail'      => ['required', 'string', 'max:120'],

            'tel1'        => ['nullable', 'regex:/^\d{2,4}$/'],
            'tel2'        => ['nullable', 'regex:/^\d{1,4}$/'],
            'tel3'        => ['nullable', 'regex:/^\d{1,4}$/'],
        ];
    }

    public function attributes()
    {
        return [
            'last_name'   => '姓',
            'first_name'  => '名',
            'gender'      => '性別',
            'email'       => 'メールアドレス',
            'tel'         => '電話番号',
            'address'     => '住所',
            'building'    => '建物名',
            'category_id' => 'お問い合わせの種類',
            'detail'      => 'お問い合わせ内容',
            'tel1'        => '電話番号（市外局番/先頭）',
            'tel2'        => '電話番号（中間）',
            'tel3'        => '電話番号（末尾）',
        ];
    }

    public function messages()
    {
        return [
            'tel.regex'  => '電話番号はハイフンなしの半角数字10〜11桁で入力してください。',
            'tel1.regex' => '電話番号（先頭）は2〜4桁の半角数字で入力してください。',
            'tel2.regex' => '電話番号（中間）は1〜4桁の半角数字で入力してください。',
            'tel3.regex' => '電話番号（末尾）は1〜4桁の半角数字で入力してください。',
        ];
    }
}
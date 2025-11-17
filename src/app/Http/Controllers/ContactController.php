<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\ContactRequest;
use App\Models\Contact;

class ContactController extends Controller
{
    /**
     * 入力画面
     * GET /
     */
    public function index()
    {
        $categories = Category::all();
        return view('index', compact('categories'));
    }

    /**
     * 確認画面
     * POST /contacts/confirm
     */
    public function confirm(ContactRequest $request)
    {
        // バリデーション済み入力値
        $inputs = $request->validated();

        // 「修正する」で戻ってきたとき
        if ($request->has('back')) {
            return redirect()
                ->route('contacts.index')
                ->withInput($inputs);
        }

        // カテゴリ（null でもOK）
        $category = Category::find($inputs['category_id'] ?? null);

        return view('confirm', compact('inputs', 'category'));
    }

    /**
     * 保存処理
     * POST /contacts/store
     */
    public function store(ContactRequest $request)
    {
        // バリデーション済み
        $validated = $request->validated();

        // ★ DB に保存（tel1 / tel2 / tel3 をそのまま保存）
        Contact::create([
            'last_name'   => $validated['last_name'],
            'first_name'  => $validated['first_name'],
            'gender'      => $validated['gender'],
            'email'       => $validated['email'],

            // 3 分割のまま保存
            'tel1'        => $validated['tel1'],
            'tel2'        => $validated['tel2'],
            'tel3'        => $validated['tel3'],

            'address'     => $validated['address'],
            'building'    => $validated['building'] ?? null,
            'category_id' => $validated['category_id'],

            // textarea の中身
            'detail'      => $validated['detail'],
        ]);

        return redirect()->route('contacts.thanks');
    }

    /**
     * 完了画面
     * GET /contacts/thanks
     */
    public function thanks()
    {
        return view('thanks');
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Category;

class AdminContactController extends Controller
{
    public function index(Request $request)
    {
        // 1) キーワード整形（前後空白除去）
        $word = trim((string) $request->input('q', ''));

        $query = Contact::with('category')->orderBy('id', 'desc');

        // 2) キーワード検索
        if ($word !== '') {
            $like = "%{$word}%";
            $query->where(function ($q) use ($like) {
                $q->where('last_name', 'like', $like)
                    ->orWhere('first_name', 'like', $like)
                    ->orWhere('email', 'like', $like)
                    ->orWhere('tel', 'like', $like)
                    ->orWhere('detail', 'like', $like);
            });
        }

        // 3) カテゴリ絞り込み
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->integer('category_id'));
        }

        // 4) 性別絞り込み（1/2/3 のみ許可）
        if ($request->filled('gender')) {
            $gender = (string) $request->input('gender');
            if (in_array($gender, ['1','2','3'], true)) {
                $query->where('gender', $gender);
            }
        }

        // 5) 1ページ件数（10/20/50 のみ許可）
        $allowedPer = [10, 20, 50];
        $perInput   = (int) $request->input('per', 10);
        $per        = in_array($perInput, $allowedPer, true) ? $perInput : 10;

        // 6) ページネーション + クエリ引き継ぎ
        $contacts = $query->paginate($per)->withQueryString();

        // プルダウン用カテゴリ
        $categories = Category::all();

        return view('admin', compact('contacts', 'categories'));
    }

    public function search(Request $request)
    {
        // 1) allowed件数処理
        $allowedPer = [10, 20, 50];
        $per = in_array((int)$request->per, $allowedPer, true)
            ? (int)$request->per
            : 10;

        // 2) 検索 + 絞り込み
        $contacts = Contact::with('category')
            ->when($request->filled('q'), function ($q) use ($request) {
                $word = trim((string)$request->q);
                $like = "%{$word}%";
                $q->where(function ($sub) use ($like) {
                    $sub->where('last_name', 'like', $like)
                        ->orWhere('first_name', 'like', $like)
                        ->orWhere('email', 'like', $like)
                        ->orWhere('tel', 'like', $like)
                        ->orWhere('detail', 'like', $like);
                });
            })
            ->when($request->filled('category_id'), function ($q) use ($request) {
                $q->where('category_id', (int)$request->category_id);
            })
            ->when(in_array((string)$request->gender, ['1','2','3'], true), function ($q) use ($request) {
                $q->where('gender', $request->gender);
            })
            ->when($request->filled('from'), function ($q) use ($request) {
                $q->whereDate('created_at', '>=', $request->from);
            })
            ->when($request->filled('to'), function ($q) use ($request) {
                $q->whereDate('created_at', '<=', $request->to);
            })
            ->orderByDesc('id')
            ->paginate($per)
            ->withQueryString(); // ← 検索条件維持

        // 3) カテゴリ一覧
        $categories = Category::all();

        // 4) Bladeへ返す
        return view('search', compact('contacts', 'categories'));
    }

    public function delete(Contact $contact)
    {
        // カテゴリ取得（null対応）
        $category = $contact->category;

        return view('delete', compact('contact', 'category'));
    }

    /**
     * 削除実行
     */
    public function destroy(Contact $contact)
    {
        $contact->delete(); // ← 完全削除（physical delete）

        return redirect()
            ->route('admin.contacts.index')
            ->with('message', 'お問い合わせを削除しました。');
    }


}
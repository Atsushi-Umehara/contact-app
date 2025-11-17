<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Category;

class AdminContactController extends Controller
{
    /*====================================
     * 一覧（/admin/contacts）
     *===================================*/
    public function index(Request $request)
    {
        $word = trim((string) $request->input('q', ''));

        $query = Contact::with('category')->orderByDesc('id');

        // ---- キーワード検索（姓/名/メール/TEL/本文）----
        if ($word !== '') {
            $like   = "%{$word}%";
            $noDash = str_replace('-', '', $word);

            $query->where(function ($q) use ($like, $noDash) {
                $q->where('last_name',  'like', $like)
                    ->orWhere('first_name', 'like', $like)
                    ->orWhere('email',      'like', $like)
                    // tel1-tel2-tel3 や数字だけでもヒット
                    ->orWhereRaw("CONCAT(tel1, '-', tel2, '-', tel3) LIKE ?", [$like])
                    ->orWhereRaw("CONCAT(tel1, tel2, tel3) LIKE ?", [$noDash])
                    ->orWhere('detail',     'like', $like);
            });
        }

        // ---- カテゴリ絞り込み ----
        if ($request->filled('category_id')) {
            $query->where('category_id', (int) $request->input('category_id'));
        }

        // ---- 性別絞り込み ----
        if (in_array((string) $request->gender, ['1', '2', '3'], true)) {
            $query->where('gender', $request->gender);
        }

        // ---- 1ページ件数（10 / 20 / 50）----
        $per = in_array((int) $request->per, [10, 20, 50], true)
            ? (int) $request->per
            : 10;

        // ---- ページネーション ----
        $contacts   = $query->paginate($per)->withQueryString();
        $categories = Category::all();

        return view('admin', compact('contacts', 'categories'));
    }

    /*====================================
     * 検索結果画面（/admin/contacts/search）
     *===================================*/
    public function search(Request $request)
    {
        $per = in_array((int) $request->per, [10, 20, 50], true)
            ? (int) $request->per
            : 10;

        $contacts = Contact::with('category')

            // ---- キーワード ----
            ->when($request->filled('q'), function ($q) use ($request) {
                $word   = trim((string) $request->q);
                $like   = "%{$word}%";
                $noDash = str_replace('-', '', $word);

                $q->where(function ($sub) use ($like, $noDash) {
                    $sub->where('last_name',  'like', $like)
                        ->orWhere('first_name', 'like', $like)
                        ->orWhere('email',      'like', $like)
                        ->orWhereRaw("CONCAT(tel1, '-', tel2, '-', tel3) LIKE ?", [$like])
                        ->orWhereRaw("CONCAT(tel1, tel2, tel3) LIKE ?", [$noDash])
                        ->orWhere('detail',     'like', $like);
                });
            })

            // ---- カテゴリ ----
            ->when($request->filled('category_id'), function ($q) use ($request) {
                $q->where('category_id', (int) $request->category_id);
            })

            // ---- 性別 ----
            ->when(
                in_array((string) $request->gender, ['1', '2', '3'], true),
                function ($q) use ($request) {
                    $q->where('gender', $request->gender);
                }
            )

            // ---- 日付範囲 ----
            ->when($request->filled('from'), function ($q) use ($request) {
                $q->whereDate('created_at', '>=', $request->from);
            })
            ->when($request->filled('to'), function ($q) use ($request) {
                $q->whereDate('created_at', '<=', $request->to);
            })

            ->orderByDesc('id')
            ->paginate($per)
            ->withQueryString();

        $categories = Category::all();

        return view('search', compact('contacts', 'categories'));
    }

    /*====================================
     * 削除前確認画面
     * /admin/contacts/{contact}/delete
     *===================================*/
    public function delete(Contact $contact)
    {
        $category = $contact->category; // null でもOK
        return view('delete', compact('contact', 'category'));
    }

    /*====================================
     * 削除実行
     *===================================*/
    public function destroy(Contact $contact)
    {
        $contact->delete();

        return redirect()
            ->route('admin.contacts.index')
            ->with('message', 'お問い合わせを削除しました。');
    }

    /*====================================
     * CSV エクスポート
     * /admin/contacts/export
     *===================================*/
    public function export(Request $request)
    {
        $fileName = 'contacts_' . now()->format('Ymd_His') . '.csv';

        $callback = function () use ($request) {
            $handle = fopen('php://output', 'w');

            // 1行目：ヘッダー
            fputcsv($handle, [
                'ID',
                '受付日',
                '姓',
                '名',
                '性別',
                'メール',
                'TEL',
                'カテゴリ',
                '内容',
            ]);

            $genderLabel = [1 => '男性', 2 => '女性', 3 => 'その他'];

            // ベースクエリ
            $query = Contact::with('category')->orderByDesc('id');

            // --- キーワード ---
            if ($request->filled('q')) {
                $word   = trim((string) $request->q);
                $like   = "%{$word}%";
                $noDash = str_replace('-', '', $word);

                $query->where(function ($q) use ($like, $noDash) {
                    $q->where('last_name',  'like', $like)
                        ->orWhere('first_name', 'like', $like)
                        ->orWhere('email',      'like', $like)
                        ->orWhereRaw("CONCAT(tel1, '-', tel2, '-', tel3) LIKE ?", [$like])
                        ->orWhereRaw("CONCAT(tel1, tel2, tel3) LIKE ?", [$noDash])
                        ->orWhere('detail',     'like', $like);
                });
            }

            // --- カテゴリ ---
            if ($request->filled('category_id')) {
                $query->where('category_id', (int) $request->input('category_id'));
            }

            // --- 性別 ---
            if (in_array((string) $request->gender, ['1', '2', '3'], true)) {
                $query->where('gender', $request->gender);
            }

            // --- 日付範囲 ---
            if ($request->filled('from')) {
                $query->whereDate('created_at', '>=', $request->from);
            }
            if ($request->filled('to')) {
                $query->whereDate('created_at', '<=', $request->to);
            }

            // chunk で順次出力
            $query->chunk(200, function ($contacts) use ($handle, $genderLabel) {
                foreach ($contacts as $c) {

                    // ★ tel1 / tel2 / tel3 から TEL を組み立て
                    $parts = array_filter([
                        $c->tel1,
                        $c->tel2,
                        $c->tel3,
                    ], fn ($v) => $v !== null && $v !== '');

                    $tel = implode('-', $parts); // 例: 090-1234-5678

                    fputcsv($handle, [
                        $c->id,
                        optional($c->created_at)->format('Y-m-d'),
                        $c->last_name,
                        $c->first_name,
                        $genderLabel[$c->gender] ?? '',
                        $c->email,
                        $tel,
                        optional($c->category)->content,
                        $c->detail,
                    ]);
                }
            });

            fclose($handle);
        };

        return response()->streamDownload($callback, $fileName, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }
}
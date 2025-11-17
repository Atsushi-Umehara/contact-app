<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    // フォームから一括代入するカラムを許可
    protected $fillable = [
        'category_id',
        'first_name',
        'last_name',
        'gender',
        'email',
        'tel1',
        'tel2',
        'tel3',
        'address',
        'building',
        'detail',
    ];

    // カテゴリーとのリレーション（contacts.category_id → categories.id）
    public function category()
    {
        return $this->belongsTo(\App\Models\Category::class);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\ContactRequest;

class ContactController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        return view('index', compact('categories'));
    }

    public function confirm(ContactRequest $request)
    {
        $inputs = $request->validated();

        if ($request->has('back')) {
            return redirect()->route('contacts.index')->withInput($inputs);
        }

        $category = \App\Models\Category::find($inputs['category_id']);

        return view('confirm', compact('inputs', 'category'));
    }

    public function store(ContactRequest $request)
    {
        \App\Models\Contact::create($request->validated());

        return redirect()->route('contacts.thanks');
    }

    public function thanks()
    {
    return view('thanks');
    }
}

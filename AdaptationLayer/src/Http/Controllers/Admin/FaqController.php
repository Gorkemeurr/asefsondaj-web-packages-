<?php

namespace AsefSondaj\AdaptationLayer\Http\Controllers\Admin;

use AsefSondaj\AdaptationLayer\Models\AsefFaq;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class FaqController extends Controller
{
    public function index()
    {
        $items = AsefFaq::orderBy('sort')->orderBy('id')->get();
        return view('asef-adaptation::admin.faq.index', compact('items'));
    }

    public function create()
    {
        return view('asef-adaptation::admin.faq.form', [
            'item' => new AsefFaq(['is_active' => true, 'sort' => 0]),
            'mode' => 'create',
        ]);
    }

    public function store(Request $req)
    {
        $data = $req->validate([
            'q' => 'required|string|max:500',
            'a' => 'required|string|max:5000',
            'sort' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);
        $data['sort'] = $data['sort'] ?? 0;
        $data['is_active'] = (bool) ($data['is_active'] ?? true);
        AsefFaq::create($data);
        return redirect()->route('admin.asef.faqs.index')->with('success', 'Soru eklendi.');
    }

    public function edit(int $id)
    {
        $item = AsefFaq::findOrFail($id);
        return view('asef-adaptation::admin.faq.form', ['item' => $item, 'mode' => 'edit']);
    }

    public function update(Request $req, int $id)
    {
        $item = AsefFaq::findOrFail($id);
        $data = $req->validate([
            'q' => 'required|string|max:500',
            'a' => 'required|string|max:5000',
            'sort' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);
        $data['sort'] = $data['sort'] ?? 0;
        $data['is_active'] = (bool) ($data['is_active'] ?? true);
        $item->update($data);
        return redirect()->route('admin.asef.faqs.index')->with('success', 'Soru güncellendi.');
    }

    public function destroy(int $id)
    {
        $item = AsefFaq::findOrFail($id);
        $item->delete();
        return redirect()->route('admin.asef.faqs.index')->with('success', 'Soru silindi.');
    }
}

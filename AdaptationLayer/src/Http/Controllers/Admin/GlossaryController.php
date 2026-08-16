<?php

namespace AsefSondaj\AdaptationLayer\Http\Controllers\Admin;

use AsefSondaj\AdaptationLayer\Models\AsefGlossaryTerm;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class GlossaryController extends Controller
{
    public function index()
    {
        $items = AsefGlossaryTerm::orderBy('term')->get();
        return view('asef-adaptation::admin.glossary.index', compact('items'));
    }

    public function create()
    {
        return view('asef-adaptation::admin.glossary.form', [
            'item' => new AsefGlossaryTerm(['is_active' => true, 'sort' => 0]),
            'mode' => 'create',
        ]);
    }

    public function store(Request $req)
    {
        $data = $req->validate([
            'term' => 'required|string|max:200|unique:asef_glossary_terms,term',
            'definition' => 'required|string|max:2000',
            'sort' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);
        $data['sort'] = $data['sort'] ?? 0;
        $data['is_active'] = (bool) ($data['is_active'] ?? true);
        AsefGlossaryTerm::create($data);
        return redirect()->route('admin.asef.glossary.index')->with('success', 'Terim eklendi.');
    }

    public function edit(int $id)
    {
        $item = AsefGlossaryTerm::findOrFail($id);
        return view('asef-adaptation::admin.glossary.form', ['item' => $item, 'mode' => 'edit']);
    }

    public function update(Request $req, int $id)
    {
        $item = AsefGlossaryTerm::findOrFail($id);
        $data = $req->validate([
            'term' => 'required|string|max:200|unique:asef_glossary_terms,term,' . $id,
            'definition' => 'required|string|max:2000',
            'sort' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);
        $data['sort'] = $data['sort'] ?? 0;
        $data['is_active'] = (bool) ($data['is_active'] ?? true);
        $item->update($data);
        return redirect()->route('admin.asef.glossary.index')->with('success', 'Terim güncellendi.');
    }

    public function destroy(int $id)
    {
        $item = AsefGlossaryTerm::findOrFail($id);
        $item->delete();
        return redirect()->route('admin.asef.glossary.index')->with('success', 'Terim silindi.');
    }
}

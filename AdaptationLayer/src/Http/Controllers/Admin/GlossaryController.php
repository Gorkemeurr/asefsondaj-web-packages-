<?php

namespace AsefSondaj\AdaptationLayer\Http\Controllers\Admin;

use Illuminate\Routing\Controller;

class GlossaryController extends Controller
{
    public function index()
    {
        return view('asef-adaptation::admin.placeholder', [
            'title' => 'Sondaj Sözlüğü',
            'desc'  => '50+ terim şu an sondaj-sozlugu.blade.php içinde. Faz 2\'de DB\'ye taşınacak (asef_glossary_terms tablosu + admin CRUD).',
            'items' => [],
        ]);
    }
}

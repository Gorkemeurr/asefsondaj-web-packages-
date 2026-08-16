<?php

namespace AsefSondaj\AdaptationLayer\Http\Controllers\Admin;

use Illuminate\Routing\Controller;

class FaqController extends Controller
{
    public function index()
    {
        return view('asef-adaptation::admin.placeholder', [
            'title' => 'SSS (Sıkça Sorulan Sorular)',
            'desc'  => '20 soru şu an sss.blade.php içinde. Faz 2\'de DB\'ye taşınacak (asef_faqs tablosu + admin CRUD).',
            'items' => [],
        ]);
    }
}

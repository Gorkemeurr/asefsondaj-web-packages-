<?php

namespace AsefSondaj\Theme\Http\Controllers;

use Illuminate\Routing\Controller;

class AsefContactController extends Controller
{
    public function index()
    {
        return view('asef-theme::shop.contact.index');
    }
}

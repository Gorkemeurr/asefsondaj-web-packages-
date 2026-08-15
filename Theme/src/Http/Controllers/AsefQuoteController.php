<?php

namespace AsefSondaj\Theme\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AsefQuoteController extends Controller
{
    public function index(Request $request)
    {
        // The quote list itself lives in the client (localStorage). Server just renders the shell.
        return view('asef-theme::shop.quote.index');
    }

    /**
     * Optional server-side WhatsApp URL builder (client normally builds this).
     */
    public function send(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.sku'  => 'required|string',
            'items.*.name' => 'required|string',
            'items.*.qty'  => 'required|integer|min:1',
        ]);

        $lines = collect($validated['items'])->map(function ($i) {
            return sprintf('• %s (%s) — %d adet', $i['name'], $i['sku'], $i['qty']);
        })->implode("\n");

        $message = str_replace(':items', $lines, config('asef-theme.whatsapp.quote_template'));

        $url = 'https://wa.me/'.config('asef-theme.contact.whatsapp').
               '?text='.urlencode($message);

        return redirect()->away($url);
    }
}

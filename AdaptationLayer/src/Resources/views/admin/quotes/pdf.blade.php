<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Proforma Fatura {{ $quote->quote_no }}</title>
    <style>
        @page { margin: 14mm 14mm 12mm 14mm; }
        * { box-sizing: border-box; }
        body {
            font-family: "DejaVu Sans", sans-serif;
            color: #1D1D1F;
            font-size: 9pt;
            line-height: 1.35;
            margin: 0;
            padding: 0;
        }
        .muted { color: #6E6E73; }
        .hr-strong { border: 0; border-top: 1.5px solid #1D1D1F; margin: 8px 0 10px; height: 0; }

        /* HEADER */
        .header { width: 100%; border-collapse: collapse; }
        .header td { vertical-align: middle; padding: 0; }
        .brand-name { font-size: 18pt; font-weight: bold; color: #1D1D1F; letter-spacing: -0.4px; line-height: 1; }
        .brand-sub  { font-size: 8.5pt; color: #6E6E73; margin-top: 4px; }

        .doc-title { font-size: 16pt; font-weight: bold; color: #1D1D1F; letter-spacing: -0.4px; text-align: right; line-height: 1; }
        .doc-sub   { font-size: 7.5pt; color: #6E6E73; text-align: right; margin-top: 3px; letter-spacing: 1px; text-transform: uppercase; }
        .doc-meta  { font-size: 8.5pt; color: #6E6E73; text-align: right; margin-top: 6px; line-height: 1.5; }
        .doc-meta b { color: #1D1D1F; font-weight: 600; }

        /* MUSTERI KUTUSU */
        .cust-box {
            background: #F5F5F7; border-radius: 8px; padding: 10px 12px;
        }
        .cust-title { font-size: 7pt; color: #6E6E73; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px; }
        .cust-name  { font-size: 11pt; font-weight: bold; color: #1D1D1F; }
        .cust-line  { font-size: 8.5pt; color: #1D1D1F; margin-top: 3px; }
        .cust-line span.k { color: #6E6E73; }

        /* URUN TABLOSU */
        .items { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .items thead th {
            font-size: 7pt; color: #6E6E73; font-weight: 600;
            text-transform: uppercase; letter-spacing: 0.8px; text-align: left;
            padding: 6px 4px; border-bottom: 1px solid #1D1D1F;
        }
        .items thead th.r { text-align: right; }
        .items thead th.c { text-align: center; }
        .items tbody td {
            padding: 7px 4px; border-bottom: 1px solid #EBEBEB;
            vertical-align: middle;
        }
        .items tbody td.r { text-align: right; }
        .items tbody td.c { text-align: center; }
        .items .img-cell { width: 46px; }
        .items .img-cell img {
            width: 40px; height: 40px; object-fit: cover;
            border-radius: 5px; border: 1px solid #EBEBEB;
        }
        .items .name { font-size: 9pt; color: #1D1D1F; font-weight: 600; line-height: 1.25; }
        .items .sku  { font-size: 7pt; color: #6E6E73; font-family: "DejaVu Sans Mono", monospace; margin-top: 2px; }

        /* TOPLAM */
        .totals { width: 100%; margin-top: 6px; border-collapse: collapse; }
        .totals td { padding: 3px 4px; font-size: 9pt; }
        .totals .k { color: #6E6E73; text-align: right; }
        .totals .v { color: #1D1D1F; text-align: right; width: 120px; }
        .totals .grand-k {
            font-size: 10pt; font-weight: bold; color: #1D1D1F; text-align: right;
            border-top: 1.5px solid #1D1D1F; padding-top: 6px;
        }
        .totals .grand-v {
            font-size: 12pt; font-weight: bold; color: #0071E3; text-align: right;
            border-top: 1.5px solid #1D1D1F; padding-top: 6px; width: 120px;
        }

        /* SABIT TESEKKUR NOTU */
        .thanks-box {
            margin-top: 10px; padding: 10px 14px;
            background: #F5F9FF; border-left: 3px solid #0071E3;
            border-radius: 4px;
            font-size: 9pt; color: #1D1D1F; line-height: 1.5;
            font-style: italic;
        }

        /* KOSULLAR */
        .terms-box {
            margin-top: 8px; padding: 10px 12px; background: #F5F5F7; border-radius: 8px;
        }
        .terms-title { font-size: 7pt; color: #6E6E73; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 5px; }
        .terms-line { font-size: 8pt; color: #1D1D1F; margin: 2px 0; line-height: 1.4; }
        .terms-line b { font-weight: 600; }
        .terms-para { font-size: 7.5pt; color: #3A3A3C; margin-top: 4px; line-height: 1.45; text-align: justify; }

        /* PARTNER SERIT */
        .partners {
            margin-top: 12px; padding: 4px 0;
            text-align: center;
        }
        .partners .k { font-size: 7pt; color: #6E6E73; text-transform: uppercase; letter-spacing: 1.2px; margin-bottom: 6px; }
        .partners img { height: 26px; margin: 0 14px; vertical-align: middle; }

        /* FOOTER */
        .footer {
            margin-top: 6px; padding-top: 6px;
            font-size: 7.5pt; color: #6E6E73; text-align: center; line-height: 1.45;
        }
        .footer .brand { font-weight: bold; color: #1D1D1F; font-size: 8pt; }
    </style>
</head>
<body>

    {{-- HEADER: sol logo+marka, sag PROFORMA + meta --}}
    @php
        $asefLogo    = public_path('asef/asef-logo-blue.jpg');
        $qrdrillLogo = public_path('asef/qrdrill-logo.jpg');
        $numoLogo    = public_path('asef/numo-logo.jpg');
    @endphp
    <table class="header">
        <tr>
            <td style="width: 55%;">
                <table style="border-collapse: collapse;">
                    <tr>
                        @if(file_exists($asefLogo))
                            <td style="vertical-align: middle; padding: 0 12px 0 0; width: 60px;">
                                <img src="{{ $asefLogo }}" alt="Asef Sondaj" style="height: 54px; width: 54px; border-radius: 999px;">
                            </td>
                        @endif
                        <td style="vertical-align: middle;">
                            <div class="brand-name">Asef Sondaj</div>
                            <div class="brand-sub">Sondaj Makineleri, Ekipmanlar ve Yedek Parça</div>
                        </td>
                    </tr>
                </table>
            </td>
            <td style="width: 45%;">
                <div class="doc-title">PROFORMA FATURA</div>
                <div class="doc-sub">Fiyat Teklifi</div>
                @php
                    // Turkiye saati zorunlu — sunucu timezone'undan bagimsiz
                    $tz = 'Europe/Istanbul';
                    $createdTr = $quote->created_at->copy()->setTimezone($tz);
                    $validTr   = $createdTr->copy()->addDays(7);
                @endphp
                <div class="doc-meta">
                    <b>Teklif No:</b> {{ $quote->quote_no }}<br>
                    <b>Tarih:</b> {{ $createdTr->format('d.m.Y H:i') }}<br>
                    <b>Geçerlilik Tarihi:</b> <span style="color: #0071E3; font-weight: 600;">{{ $validTr->format('d.m.Y H:i') }}</span>
                </div>
            </td>
        </tr>
    </table>

    <hr class="hr-strong">

    {{-- MUSTERI --}}
    <div class="cust-box">
        <div class="cust-title">Müşteri Bilgileri</div>
        <div class="cust-name">{{ $quote->customer_name }}</div>
        @if($quote->customer_company)
            <div class="cust-line">
                <span class="k">Firma:</span> {{ $quote->customer_company }}@if($quote->customer_position)<span class="muted"> - {{ $quote->customer_position }}</span>@endif
            </div>
        @endif
        <div class="cust-line">
            <span class="k">Telefon:</span> {{ $quote->customer_phone }}@if($quote->customer_email) &nbsp;&nbsp;<span class="k">E-posta:</span> {{ $quote->customer_email }}@endif
        </div>
        @if($quote->customer_city || $quote->customer_district)
            <div class="cust-line">
                <span class="k">Konum:</span>
                {{ $quote->customer_city }}@if($quote->customer_city && $quote->customer_district) / @endif{{ $quote->customer_district }}
            </div>
        @endif
    </div>

    {{-- URUNLER --}}
    <table class="items">
        <thead>
            <tr>
                <th style="width: 46px;"></th>
                <th>Ürün</th>
                <th class="c" style="width: 46px;">Adet</th>
                <th class="r" style="width: 92px;">Birim</th>
                <th class="r" style="width: 100px;">Toplam</th>
            </tr>
        </thead>
        <tbody>
            @foreach($quote->items as $it)
                <tr>
                    <td class="img-cell">
                        @php
                            $img = $it->product_image
                                ? public_path('asef/' . $it->product_image)
                                : public_path('asef/asef-hero-equipment.jpg');
                        @endphp
                        @if(file_exists($img))
                            <img src="{{ $img }}" alt="">
                        @endif
                    </td>
                    <td>
                        <div class="name">{{ $it->product_name }}</div>
                        @if($it->product_sku)
                            <div class="sku">{{ $it->product_sku }}</div>
                        @endif
                    </td>
                    <td class="c">{{ $it->quantity }}</td>
                    <td class="r">{{ number_format((float) $it->unit_price, 2, ',', '.') }} TL</td>
                    <td class="r">{{ number_format((float) $it->line_total, 2, ',', '.') }} TL</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- TOPLAM (tek satir — KDV bilgisi terms kutusunda "KDV dahil degildir" olarak var) --}}
    <table class="totals">
        <tr>
            <td class="grand-k">TOPLAM</td>
            <td class="grand-v">{{ number_format((float) $quote->subtotal, 2, ',', '.') }} TL</td>
        </tr>
    </table>

    {{-- SABIT TESEKKUR NOTU --}}
    <div class="thanks-box">
        Teklifimize gösterdiğiniz ilgi için teşekkür ederiz.
        Detaylı teknik danışmanlık ve sipariş süreci için ekibimizle iletişime geçebilirsiniz.
    </div>

    {{-- KOSULLAR (her madde alt alta) --}}
    <div class="terms-box">
        <div class="terms-title">Açıklamalar ve Özel Koşullar</div>
        <div class="terms-line"><b>Vergi:</b> Fiyatlarımıza KDV dahil değildir.</div>
        <div class="terms-line"><b>Ödeme Şekli:</b> Peşin ödeme</div>
        <div class="terms-line"><b>Teslim Tarihi:</b> 2 iş günü</div>
        <div class="terms-line"><b>Teslim Şekli:</b> Merkez Fabrika Bursa Teslim</div>
        <div class="terms-para">
            <b>Ödeme Kuru:</b> Satış faturasında veya proformada belirtilen bankanın satış kuru baz alınacaktır.
            Ödemenin satış faturası tarihinden sonra olması durumunda, proformada belirtilen bankanın satış kuru baz alınır.
            Ödemenin yapıldığı gün oluşacak cari hesap farkı için kur farkı faturası kesilir.
        </div>
        <div class="terms-para">
            <b>Masraflar:</b> Her türlü nakliye ve taşıma sırasında doğacak masrafların bedeli Alıcı'ya aittir.
        </div>
        <div class="terms-para">
            <b>Gecikmeler ve Hasar:</b> Kargo ve diğer sevkiyat hallerinde ürüne gelebilecek hasar ve ziyandan taşımacılık firması sorumludur.
            Kendi imalatımız dışında olan ve Üretici Fabrika'dan kaynaklanan ve mücbir sebeplerden doğan gecikmelerden Satıcı sorumlu tutulamaz.
        </div>
    </div>

    {{-- PARTNER LOGOLARI --}}
    @if(file_exists($qrdrillLogo) || file_exists($numoLogo))
        <div class="partners">
            <div class="k">Yetkili Bayii</div>
            @if(file_exists($qrdrillLogo))
                <img src="{{ $qrdrillLogo }}" alt="QRDrill">
            @endif
            @if(file_exists($numoLogo))
                <img src="{{ $numoLogo }}" alt="Numo">
            @endif
        </div>
    @endif

    {{-- FOOTER --}}
    <div class="footer">
        <div class="brand">Asef Sondaj</div>
        Duaçınarı Mah. 1. Özgünay Sk No:10, Yıldırım / Bursa &nbsp;•&nbsp;
        +90 532 054 29 75 &nbsp;•&nbsp; iletisim@asefsondaj.com &nbsp;•&nbsp; www.asefsondaj.com
    </div>

</body>
</html>

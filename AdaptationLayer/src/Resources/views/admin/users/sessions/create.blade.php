{{-- ============================================================
     Asef Sondaj — Admin Login Sayfası (Bagisto override)
     Design: Apple minimalist, mavi #0071E3, beyaz canvas.
     Bagisto core view'a dokunulmadan adaptation-layer'da override edilir.
     Tüm stiller inline attr olarak — Bagisto admin CSS'i baskılamaz.
     ============================================================ --}}
<x-admin::layouts.anonymous>
    <x-slot:title>Asef Sondaj Yönetim Paneli — Giriş</x-slot>

    @php
        $fontStack = "-apple-system, BlinkMacSystemFont, 'SF Pro Display', 'Helvetica Neue', 'Inter', Arial, sans-serif";
    @endphp

    <div style="min-height:100vh; background:#F5F5F7; display:flex; align-items:center; justify-content:center; padding:20px; font-family:{{ $fontStack }};">
        <div style="width:100%; max-width:400px; display:flex; flex-direction:column; align-items:center; gap:24px;">

            {{-- BRAND — mavi logo inline SVG (server file dependency yok, garantili render) --}}
            <div style="display:flex; flex-direction:column; align-items:center; gap:12px;">
                <div style="width:72px; height:72px; border-radius:999px; background:#0071E3; display:flex; align-items:center; justify-content:center; box-shadow:0 6px 20px -8px rgba(0,113,227,0.5);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none">
                        <path d="M20 6 L34 32 L28 32 L25 26 L15 26 L12 32 L6 32 Z M17 21 L23 21 L20 15 Z" fill="#FFFFFF"/>
                    </svg>
                </div>
                <div style="text-align:center;">
                    <div style="font-family:{{ $fontStack }}; font-size:22px; font-weight:700; color:#1D1D1F; letter-spacing:-0.3px; line-height:1.2;">Asef Sondaj</div>
                    <div style="font-family:{{ $fontStack }}; font-size:14px; color:#6E6E73; margin-top:4px;">Yönetim Paneli</div>
                </div>
            </div>

            {{-- CARD --}}
            <div style="background:#FFFFFF; border-radius:14px; box-shadow:0 8px 24px -8px rgba(0,0,0,0.12); border:1px solid #E8E8ED; padding:28px 24px; width:100%; box-sizing:border-box;">
                <p style="font-family:{{ $fontStack }}; font-size:17px; font-weight:600; color:#1D1D1F; margin:0 0 20px; text-align:center;">Giriş Yap</p>

                <form method="POST" action="{{ route('admin.session.store') }}" novalidate>
                    @csrf

                    {{-- E-POSTA --}}
                    <div style="margin-bottom:14px;">
                        <label for="asef-login-email" style="display:block; font-family:{{ $fontStack }}; font-size:12px; font-weight:500; color:#6E6E73; margin-bottom:6px;">E-posta</label>
                        <input type="email" id="asef-login-email" name="email" required autofocus
                               value="{{ old('email') }}" placeholder="ornek@asefsondaj.com"
                               style="width:100%; padding:11px 14px; border:1px solid #D2D2D7; border-radius:10px; font-family:{{ $fontStack }}; font-size:14px; color:#1D1D1F; background:#FFFFFF; outline:none; box-sizing:border-box; transition:border-color 150ms ease, box-shadow 150ms ease;"
                               onfocus="this.style.borderColor='#0071E3'; this.style.boxShadow='0 0 0 3px rgba(0,113,227,0.15)';"
                               onblur="this.style.borderColor='#D2D2D7'; this.style.boxShadow='none';">
                        @error('email')
                            <div style="background:#FEF2F2; border:1px solid #FECACA; color:#B91C1C; padding:8px 10px; border-radius:8px; font-size:12px; margin-top:6px; font-family:{{ $fontStack }};">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- SIFRE --}}
                    <div style="margin-bottom:14px;">
                        <label for="asef-login-password" style="display:block; font-family:{{ $fontStack }}; font-size:12px; font-weight:500; color:#6E6E73; margin-bottom:6px;">Şifre</label>
                        <div style="position:relative;">
                            <input type="password" id="asef-login-password" name="password" required placeholder="••••••••"
                                   style="width:100%; padding:11px 44px 11px 14px; border:1px solid #D2D2D7; border-radius:10px; font-family:{{ $fontStack }}; font-size:14px; color:#1D1D1F; background:#FFFFFF; outline:none; box-sizing:border-box; transition:border-color 150ms ease, box-shadow 150ms ease;"
                                   onfocus="this.style.borderColor='#0071E3'; this.style.boxShadow='0 0 0 3px rgba(0,113,227,0.15)';"
                                   onblur="this.style.borderColor='#D2D2D7'; this.style.boxShadow='none';">
                            <button type="button" onclick="asefTogglePw()" aria-label="Şifreyi göster/gizle"
                                    style="position:absolute; right:8px; top:50%; transform:translateY(-50%); background:transparent; border:0; cursor:pointer; color:#6E6E73; padding:6px; display:flex; align-items:center;">
                                <svg id="asef-pw-eye-open" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                <svg id="asef-pw-eye-closed" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none;"><path d="M17.94 17.94A10.94 10.94 0 0 1 12 20c-7 0-11-8-11-8a19.6 19.6 0 0 1 5.06-5.94M9.9 4.24A10.94 10.94 0 0 1 12 4c7 0 11 8 11 8a19.6 19.6 0 0 1-2.16 3.19"/><path d="M1 1l22 22"/><path d="M14.12 14.12a3 3 0 1 1-4.24-4.24"/></svg>
                            </button>
                        </div>
                        @error('password')
                            <div style="background:#FEF2F2; border:1px solid #FECACA; color:#B91C1C; padding:8px 10px; border-radius:8px; font-size:12px; margin-top:6px; font-family:{{ $fontStack }};">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- AKSIYONLAR --}}
                    <div style="display:flex; align-items:center; justify-content:space-between; gap:12px; margin-top:20px;">
                        <a href="{{ route('admin.forget_password.create') }}"
                           style="font-family:{{ $fontStack }}; font-size:13px; color:#0071E3; text-decoration:none; font-weight:500;"
                           onmouseover="this.style.textDecoration='underline';"
                           onmouseout="this.style.textDecoration='none';">Şifremi unuttum</a>
                        <button type="submit"
                                style="background:#0071E3; color:#FFFFFF; padding:11px 22px; border:0; border-radius:10px; font-family:{{ $fontStack }}; font-size:14px; font-weight:600; cursor:pointer; transition:background 150ms ease; min-width:110px;"
                                onmouseover="this.style.background='#005FBF';"
                                onmouseout="this.style.background='#0071E3';">Giriş Yap</button>
                    </div>
                </form>
            </div>

            {{-- FOOTER --}}
            <div style="font-family:{{ $fontStack }}; font-size:12px; color:#86868B; text-align:center;">
                © {{ date('Y') }} Asef Sondaj — Tüm hakları saklıdır
            </div>

        </div>
    </div>

    @push('scripts')
        <script>
            function asefTogglePw() {
                var input = document.getElementById('asef-login-password');
                var eyeOpen = document.getElementById('asef-pw-eye-open');
                var eyeClosed = document.getElementById('asef-pw-eye-closed');
                if (input.type === 'password') {
                    input.type = 'text';
                    eyeOpen.style.display = 'none';
                    eyeClosed.style.display = 'block';
                } else {
                    input.type = 'password';
                    eyeOpen.style.display = 'block';
                    eyeClosed.style.display = 'none';
                }
            }
        </script>
    @endpush
</x-admin::layouts.anonymous>

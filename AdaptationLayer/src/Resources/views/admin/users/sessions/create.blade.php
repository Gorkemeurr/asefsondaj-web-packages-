{{-- ============================================================
     Asef Sondaj — Admin Login Sayfası (Bagisto override)
     Design: Apple minimalist, mavi #0071E3 vurgu, beyaz canvas,
     Asef mavi logo. Bagisto core view'a dokunulmadan
     adaptation-layer'dan override edilir.
     ============================================================ --}}
<x-admin::layouts.anonymous>
    <x-slot:title>Asef Sondaj Yönetim Paneli — Giriş</x-slot>

    <style>
        body { background: #F5F5F7 !important; }
        .asef-login-shell {
            min-height: 100vh; display: flex; align-items: center; justify-content: center;
            padding: 20px;
        }
        .asef-login-inner {
            display: flex; flex-direction: column; align-items: center; gap: 24px;
            width: 100%; max-width: 400px;
        }
        .asef-login-brand {
            display: flex; flex-direction: column; align-items: center; gap: 12px;
        }
        .asef-login-logo {
            width: 68px; height: 68px; border-radius: 999px;
            display: block;
        }
        .asef-login-brand-name {
            font-family: -apple-system, BlinkMacSystemFont, "SF Pro Display", "Helvetica Neue", "Inter", Arial, sans-serif;
            font-size: 22px; font-weight: 700; color: #1D1D1F; letter-spacing: -0.3px;
        }
        .asef-login-brand-sub {
            font-family: -apple-system, BlinkMacSystemFont, "SF Pro Display", "Helvetica Neue", "Inter", Arial, sans-serif;
            font-size: 14px; color: #6E6E73; margin-top: 2px;
        }
        .asef-login-card {
            background: #FFFFFF; border-radius: 14px; box-shadow: 0 8px 24px -8px rgba(0,0,0,0.12);
            border: 1px solid #E8E8ED; padding: 28px 24px; width: 100%;
        }
        .asef-login-title {
            font-family: -apple-system, BlinkMacSystemFont, "SF Pro Display", "Helvetica Neue", "Inter", Arial, sans-serif;
            font-size: 17px; font-weight: 600; color: #1D1D1F; margin: 0 0 20px; text-align: center;
        }
        .asef-login-field { margin-bottom: 14px; }
        .asef-login-label {
            display: block; font-family: -apple-system, BlinkMacSystemFont, "SF Pro Display", "Helvetica Neue", "Inter", Arial, sans-serif;
            font-size: 12px; font-weight: 500; color: #6E6E73; margin-bottom: 6px;
        }
        .asef-login-input {
            width: 100%; padding: 11px 14px; border: 1px solid #D2D2D7; border-radius: 10px;
            font-family: -apple-system, BlinkMacSystemFont, "SF Pro Display", "Helvetica Neue", "Inter", Arial, sans-serif;
            font-size: 14px; color: #1D1D1F; background: #FFFFFF; outline: none;
            transition: border-color 150ms ease, box-shadow 150ms ease;
            box-sizing: border-box;
        }
        .asef-login-input:focus {
            border-color: #0071E3; box-shadow: 0 0 0 3px rgba(0,113,227,0.15);
        }
        .asef-login-password-wrap { position: relative; }
        .asef-login-password-toggle {
            position: absolute; right: 12px; top: 50%; transform: translateY(-50%);
            background: none; border: 0; cursor: pointer; color: #6E6E73;
            padding: 4px; display: flex; align-items: center;
        }
        .asef-login-password-toggle:hover { color: #1D1D1F; }
        .asef-login-actions {
            display: flex; align-items: center; justify-content: space-between;
            margin-top: 20px; gap: 12px;
        }
        .asef-login-forgot {
            font-family: -apple-system, BlinkMacSystemFont, "SF Pro Display", "Helvetica Neue", "Inter", Arial, sans-serif;
            font-size: 13px; color: #0071E3; text-decoration: none; font-weight: 500;
        }
        .asef-login-forgot:hover { text-decoration: underline; }
        .asef-login-submit {
            background: #0071E3; color: #FFFFFF; padding: 11px 22px; border: 0; border-radius: 10px;
            font-family: -apple-system, BlinkMacSystemFont, "SF Pro Display", "Helvetica Neue", "Inter", Arial, sans-serif;
            font-size: 14px; font-weight: 600; cursor: pointer;
            transition: background 150ms ease, transform 80ms ease;
            min-width: 120px;
        }
        .asef-login-submit:hover { background: #005FBF; }
        .asef-login-submit:active { transform: scale(0.98); }
        .asef-login-footer {
            margin-top: 8px; text-align: center;
            font-family: -apple-system, BlinkMacSystemFont, "SF Pro Display", "Helvetica Neue", "Inter", Arial, sans-serif;
            font-size: 12px; color: #86868B;
        }
        .asef-login-error {
            background: #FEF2F2; border: 1px solid #FECACA; color: #B91C1C;
            padding: 10px 12px; border-radius: 8px; font-size: 12px; margin-top: 8px;
        }
    </style>

    <div class="asef-login-shell">
        <div class="asef-login-inner">
            @php
                // Mavi logo öncelikli; deploy sonrasi public/asef/asef-logo-blue.jpg
                // install.sh tarafindan kopyalanir. Yoksa asef-mark-dark.png fallback.
                $logoBlue = public_path('asef/asef-logo-blue.jpg');
                $logoDark = public_path('asef/asef-mark-dark.png');
                $loginLogoUrl = file_exists($logoBlue)
                    ? url('asef/asef-logo-blue.jpg')
                    : (file_exists($logoDark) ? url('asef/asef-mark-dark.png') : url('asef/asef-logo.png'));
            @endphp
            <div class="asef-login-brand">
                <img class="asef-login-logo" src="{{ $loginLogoUrl }}" alt="Asef Sondaj">
                <div style="text-align: center;">
                    <div class="asef-login-brand-name">Asef Sondaj</div>
                    <div class="asef-login-brand-sub">Yönetim Paneli</div>
                </div>
            </div>

            <div class="asef-login-card">
                <p class="asef-login-title">Giriş Yap</p>

                <form method="POST" action="{{ route('admin.session.store') }}" novalidate>
                    @csrf

                    <div class="asef-login-field">
                        <label class="asef-login-label" for="asef-login-email">E-posta</label>
                        <input type="email" id="asef-login-email" name="email" required autofocus
                               value="{{ old('email') }}"
                               placeholder="ornek@asefsondaj.com"
                               class="asef-login-input">
                        @error('email')
                            <div class="asef-login-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="asef-login-field">
                        <label class="asef-login-label" for="asef-login-password">Şifre</label>
                        <div class="asef-login-password-wrap">
                            <input type="password" id="asef-login-password" name="password" required
                                   placeholder="••••••••"
                                   class="asef-login-input"
                                   style="padding-right: 44px;">
                            <button type="button" class="asef-login-password-toggle"
                                    onclick="asefTogglePw()" aria-label="Şifreyi göster/gizle">
                                <svg id="asef-pw-eye-open" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                <svg id="asef-pw-eye-closed" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none;"><path d="M17.94 17.94A10.94 10.94 0 0 1 12 20c-7 0-11-8-11-8a19.6 19.6 0 0 1 5.06-5.94M9.9 4.24A10.94 10.94 0 0 1 12 4c7 0 11 8 11 8a19.6 19.6 0 0 1-2.16 3.19"/><path d="M1 1l22 22"/><path d="M14.12 14.12a3 3 0 1 1-4.24-4.24"/></svg>
                            </button>
                        </div>
                        @error('password')
                            <div class="asef-login-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="asef-login-actions">
                        <a class="asef-login-forgot" href="{{ route('admin.forget_password.create') }}">Şifremi unuttum</a>
                        <button type="submit" class="asef-login-submit">Giriş Yap</button>
                    </div>
                </form>
            </div>

            <div class="asef-login-footer">
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

@php
    $cookieBannerEnabled = ! in_array(setting('cookie_banner_enabled', true), [false, 0, '0', 'false'], true);
    $cookieTitle = trim((string) setting('cookie_banner_title', '')) ?: 'Cookies';
    $cookieBody = trim((string) setting('cookie_banner_body', '')) ?: 'We use cookies to understand how visitors use this website. Analytics load only after you accept. See our Privacy Policy for details.';
@endphp
@if($cookieBannerEnabled)
    <div
        id="cookie-banner"
        class="pointer-events-none fixed inset-x-0 bottom-0 z-[60] p-4 sm:p-6"
        role="dialog"
        aria-modal="false"
        aria-labelledby="cookie-banner-title"
        aria-describedby="cookie-banner-body"
        hidden
    >
        <div class="container-site">
            <div class="pointer-events-auto flex flex-col gap-4 rounded-2xl border border-[#E5E7EB] bg-white p-5 shadow-[0_24px_60px_rgba(10,22,40,0.16)] sm:flex-row sm:items-center sm:justify-between">
                <div class="min-w-0">
                    <p id="cookie-banner-title" class="text-sm font-semibold text-[#101828]">{{ $cookieTitle }}</p>
                    <p id="cookie-banner-body" class="mt-1 text-sm leading-6 text-[#475467]">
                        {{ $cookieBody }}
                        <a href="{{ url('/privacy-policy') }}" class="font-semibold text-[#0B59AC] underline underline-offset-2 hover:text-[#084785]">Privacy Policy</a>
                    </p>
                </div>
                <div class="flex shrink-0 flex-wrap gap-3">
                    <button type="button" data-cookie-decline class="inline-flex items-center justify-center rounded-full border border-[#E5E7EB] bg-white px-5 py-2.5 text-sm font-semibold text-[#101828] hover:border-[#0B59AC] hover:text-[#0B59AC]">Decline</button>
                    <button type="button" data-cookie-accept class="inline-flex items-center justify-center rounded-full bg-[#0B59AC] px-5 py-2.5 text-sm font-semibold text-white hover:bg-[#084785]">Accept</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        (function () {
            const storageKey = 'sf_cookie_consent';
            const banner = document.getElementById('cookie-banner');

            if (! banner) {
                return;
            }

            const readStorage = function () {
                try {
                    return window.localStorage.getItem(storageKey);
                } catch (error) {
                    return null;
                }
            };

            const readCookie = function () {
                const match = document.cookie.match(/(?:^|; )sf_cookie_consent=([^;]*)/);
                return match ? decodeURIComponent(match[1]) : null;
            };

            const persist = function (value) {
                try {
                    window.localStorage.setItem(storageKey, value);
                } catch (error) {}

                document.cookie = 'sf_cookie_consent=' + encodeURIComponent(value) + '; Max-Age=15552000; Path=/; SameSite=Lax';
            };

            const hide = function () {
                banner.hidden = true;
            };

            const show = function () {
                banner.hidden = false;
            };

            const accept = function () {
                persist('accepted');
                hide();
                if (typeof window.sfLoadAnalytics === 'function') {
                    window.sfLoadAnalytics();
                }
            };

            const decline = function () {
                persist('declined');
                hide();
            };

            const choice = readStorage() || readCookie();

            if (choice === 'accepted') {
                hide();
                if (typeof window.sfLoadAnalytics === 'function') {
                    window.sfLoadAnalytics();
                }
            } else if (choice === 'declined') {
                hide();
            } else {
                show();
            }

            banner.querySelector('[data-cookie-accept]')?.addEventListener('click', accept);
            banner.querySelector('[data-cookie-decline]')?.addEventListener('click', decline);

            document.querySelectorAll('[data-cookie-settings]').forEach(function (button) {
                button.addEventListener('click', show);
            });
        })();
    </script>
@endif

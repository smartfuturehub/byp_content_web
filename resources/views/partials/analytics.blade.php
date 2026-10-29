@php
    $googleAnalyticsId = trim((string) setting('google_analytics_id', ''));
    $googleTagManagerId = trim((string) setting('google_tag_manager_id', ''));
    $googleAdsId = trim((string) setting('google_ads_id', ''));
    $hasAnalytics = $googleAnalyticsId !== '' || $googleTagManagerId !== '' || $googleAdsId !== '';
    $cookieBannerEnabled = ! in_array(setting('cookie_banner_enabled', true), [false, 0, '0', 'false'], true);
    $firstPartyEnabled = ! in_array(setting('first_party_analytics_enabled', true), [false, 0, '0', 'false'], true);
@endphp
@if($hasAnalytics || $firstPartyEnabled)
    @if($firstPartyEnabled)
        <meta name="sf-collect" content="{{ url('/analytics/collect') }}">
    @endif
    <script>
        window.sfAnalytics = {{ \Illuminate\Support\Js::from([
            'ga' => $googleAnalyticsId !== '' ? $googleAnalyticsId : null,
            'gtm' => $googleTagManagerId !== '' ? $googleTagManagerId : null,
            'ads' => $googleAdsId !== '' ? $googleAdsId : null,
        ]) }};
        window.sfTrackPageView = function () {
            const collectMeta = document.querySelector('meta[name="sf-collect"]');
            const config = Object.assign({}, window.sfAnalytics || {}, {
                collect: collectMeta ? collectMeta.getAttribute('content') : null,
            });
            if (! config.collect || window.sfPageViewSent) {
                return;
            }

            window.sfPageViewSent = true;

            let sessionId = null;
            try {
                sessionId = window.localStorage.getItem('sf_analytics_session');
                if (! sessionId) {
                    sessionId = (window.crypto && window.crypto.randomUUID)
                        ? window.crypto.randomUUID()
                        : String(Date.now()) + '-' + Math.random().toString(16).slice(2);
                    window.localStorage.setItem('sf_analytics_session', sessionId);
                }
            } catch (error) {
                sessionId = String(Date.now());
            }

            const params = new URLSearchParams(window.location.search);
            const payload = {
                path: window.location.pathname + window.location.search,
                title: document.title || '',
                referrer: document.referrer || '',
                utm_source: params.get('utm_source'),
                utm_medium: params.get('utm_medium'),
                utm_campaign: params.get('utm_campaign'),
                session_id: sessionId,
                language: navigator.language || '',
            };

            fetch(config.collect, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                credentials: 'same-origin',
                body: JSON.stringify(payload),
            }).catch(function () {});
        };
        window.sfLoadAnalytics = function () {
            window.sfTrackPageView();

            if (window.sfAnalyticsLoaded) {
                return;
            }

            const ids = window.sfAnalytics || {};
            if (! ids.ga && ! ids.gtm && ! ids.ads) {
                return;
            }

            window.sfAnalyticsLoaded = true;
            window.dataLayer = window.dataLayer || [];

            if (ids.gtm) {
                window.dataLayer.push({ 'gtm.start': new Date().getTime(), event: 'gtm.js' });
                const tagManager = document.createElement('script');
                tagManager.async = true;
                tagManager.src = 'https://www.googletagmanager.com/gtm.js?id=' + encodeURIComponent(ids.gtm);
                document.head.appendChild(tagManager);
            }

            if (ids.ga || ids.ads) {
                window.gtag = window.gtag || function () { window.dataLayer.push(arguments); };
                const measurementId = ids.ga || ids.ads;
                const tag = document.createElement('script');
                tag.async = true;
                tag.src = 'https://www.googletagmanager.com/gtag/js?id=' + encodeURIComponent(measurementId);
                document.head.appendChild(tag);
                window.gtag('js', new Date());
                if (ids.ga) {
                    window.gtag('config', ids.ga);
                }
                if (ids.ads) {
                    window.gtag('config', ids.ads);
                }
            }
        };
    </script>
    @unless($cookieBannerEnabled)
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                if (typeof window.sfLoadAnalytics === 'function') {
                    window.sfLoadAnalytics();
                }
            });
        </script>
    @endunless
@endif
@if(setting('chat_widget_enabled'))
<script>
      window.SFWidgetConfig = {
        chatUrl: "{{ setting('chat_widget_url', 'https://assistant.oursmartfuture.com/embed') }}",
        title: "{{ setting('chat_widget_title', setting('site_name', 'BYP Health').' Virtual Consultant') }}",
        message: "{{ setting('chat_widget_message', 'Have questions about RPM or EMR integrations? Let\'s talk!') }}",
        position: "bottom-right",
      };
</script>
<script src="{{ setting('chat_widget_script', 'https://assistant.oursmartfuture.com/sf-widget.js') }}" defer></script>
@endif
 

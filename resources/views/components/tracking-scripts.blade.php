@php
    $fbPixelId = \App\Models\SiteSetting::get('fb_pixel_enabled') === '1' ? \App\Models\SiteSetting::get('fb_pixel_id') : null;
    $gaId = \App\Models\SiteSetting::get('ga_enabled') === '1' ? \App\Models\SiteSetting::get('ga_measurement_id') : null;
@endphp

@if ($fbPixelId || $gaId)
    <script>
        // Central tracking helper — loads Meta Pixel / Google Analytics only after the
        // visitor accepts the cookie banner below, and only ever once. `Tracking.event()`
        // is the single call site pages use to fire an event on both platforms at once,
        // so a page never has to know whether Pixel/GA are actually enabled or consented.
        window.Tracking = {
            fbPixelId: @js($fbPixelId),
            gaId: @js($gaId),
            consent: null,

            init() {
                try {
                    this.consent = localStorage.getItem('cookie_consent');
                } catch (e) {
                    this.consent = null;
                }
                if (this.consent === 'accepted') this.load();
            },

            load() {
                if (this.fbPixelId && !window.fbq) this.loadFacebookPixel();
                if (this.gaId && !window.gtag) this.loadGoogleAnalytics();
            },

            accept() {
                try { localStorage.setItem('cookie_consent', 'accepted'); } catch (e) {}
                this.consent = 'accepted';
                this.load();
            },

            reject() {
                try { localStorage.setItem('cookie_consent', 'rejected'); } catch (e) {}
                this.consent = 'rejected';
            },

            loadFacebookPixel() {
                /* eslint-disable */
                !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
                n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
                n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
                t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
                document,'script','https://connect.facebook.net/en_US/fbevents.js');
                /* eslint-enable */
                fbq('init', this.fbPixelId);
                fbq('track', 'PageView');
            },

            loadGoogleAnalytics() {
                var s = document.createElement('script');
                s.async = true;
                s.src = 'https://www.googletagmanager.com/gtag/js?id=' + this.gaId;
                document.head.appendChild(s);
                window.dataLayer = window.dataLayer || [];
                window.gtag = function () { dataLayer.push(arguments); };
                gtag('js', new Date());
                gtag('config', this.gaId);
            },

            /**
             * Fire the same logical event on whichever platforms are active.
             * @param {string|null} fbEvent   Meta standard/custom event name, e.g. 'Lead'
             * @param {string|null} gaEvent   GA4 recommended/custom event name, e.g. 'generate_lead'
             * @param {object} params         Event parameters (content_name, value, currency, ...)
             * @param {string|null} eventId   Shared ID for Pixel/CAPI deduplication (leads only)
             */
            event(fbEvent, gaEvent, params, eventId) {
                if (this.consent !== 'accepted') return;
                params = params || {};
                if (fbEvent && window.fbq) {
                    fbq('track', fbEvent, params, eventId ? { eventID: eventId } : undefined);
                }
                if (gaEvent && window.gtag) {
                    gtag('event', gaEvent, params);
                }
            },
        };
        Tracking.init();
    </script>

    <div
        x-data="{ show: !window.Tracking || (window.Tracking.consent !== 'accepted' && window.Tracking.consent !== 'rejected') }"
        x-cloak
        x-show="show"
        x-transition
        class="fixed inset-x-0 bottom-0 z-50 border-t border-slate-200 bg-white/98 px-4 py-4 shadow-[0_-4px_20px_rgba(0,0,0,0.08)] backdrop-blur sm:px-6"
        role="region"
        aria-label="Cookie consent"
    >
        <div class="mx-auto flex max-w-6xl flex-col items-center gap-3 sm:flex-row sm:justify-between">
            <p class="text-center text-xs text-slate-600 sm:text-left">
                We use cookies for analytics and to measure ad performance, so we only spend on what actually works. No data is shared until you accept.
                <a href="{{ route('home') }}#quote" class="font-semibold text-navy-700 underline underline-offset-2 hover:text-gold-600">Contact us</a> with any questions.
            </p>
            <div class="flex shrink-0 items-center gap-2">
                <button
                    type="button"
                    @click="Tracking.reject(); show = false"
                    class="rounded-full border border-slate-300 px-4 py-2 text-xs font-bold text-slate-600 transition hover:bg-slate-50"
                >
                    Reject
                </button>
                <button
                    type="button"
                    @click="Tracking.accept(); show = false"
                    class="rounded-full bg-navy-900 px-5 py-2 text-xs font-bold text-white transition hover:bg-navy-800"
                >
                    Accept
                </button>
            </div>
        </div>
    </div>
@endif

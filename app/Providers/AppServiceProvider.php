<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Applies everywhere Password::defaults() is used (registration, admin
        // user creation, client creation, password changes/resets) — centralizing
        // it here means every one of those call sites gets strengthened together
        // instead of drifting out of sync. Not using ->uncompromised() (checks
        // against HaveIBeenPwned) by default since that adds an external API call
        // and network dependency to every password submission; add it here later
        // if desired.
        Password::defaults(fn () => Password::min(10)->mixedCase()->numbers());

        // Forces route()/url()/asset() to generate https:// links in production,
        // even when the request reaches PHP as plain HTTP internally (the normal
        // case behind a TLS-terminating proxy/load balancer) — pairs with the
        // TRUSTED_PROXIES setting. Without this, forms/redirects/assets can end
        // up pointing at http:// and trigger mixed-content warnings or broken
        // "secure" cookies even though the site is genuinely served over HTTPS.
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}

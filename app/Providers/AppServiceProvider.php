<?php

namespace App\Providers;

use App\Events\TransactionCreated;
use App\Listeners\CheckHighValueThreshold;
use App\Services\PaymentGateways\LocalBankAdapter;
use App\Services\PaymentGateways\PaymentGatewayInterface;
use App\Services\PaymentGateways\StripeAdapter;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(\App\Services\AuditLogger::class, function ($app) {
            return new \App\Services\AuditLogger();
        });

        Event::listen(
            TransactionCreated::class,
            CheckHighValueThreshold::class
        );


        $this->app->bind(PaymentGatewayInterface::class, function ($app) {

            // $provider = 'stripe';

            $provider = config('services.payment.default', 'stripe');

            return match ($provider) {
                'stripe' => new StripeAdapter(),
                'local' => new LocalBankAdapter(),
                default => new StripeAdapter(),
            };
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(\App\Models\Account::class, \App\Policies\AccountPolicy::class);
        Gate::policy(\App\Models\Transaction::class, \App\Policies\TransactionPolicy::class);

        // General limiter (120 requests per minute)
        RateLimiter::for('general', function (Request $request) {
            return Limit::perMinute(120)
                ->by($request->user()?->id ?: $request->ip());
        });

        // Authentication limiter (5 requests per minute)
        RateLimiter::for('authentication', function (Request $request) {
            return Limit::perMinute(5)
                ->by($request->user()?->id ?: $request->ip());
        });
    }
}

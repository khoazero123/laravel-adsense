<?php

/**
 * Google Adsense Ads for Laravel
 *
 * Package for easily including Google Adsense Ad units
 * in Laravel and Lumen.
 *
 * @developer Crypto Technology srl <https://cryptotech.srl/>
 * @copyright Copyright (c) 2019 Crypto Technology srl
 * @license   MIT
 *
 * Copyright (c) 2016 Galen Han
 * Copyright (c) 2019 Crypto Technology srl
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of
 * this software and associated documentation files (the "Software"), to deal in
 * the Software without restriction, including without limitation the rights to
 * use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of
 * the Software, and to permit persons to whom the Software is furnished to do so,
 * subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
 * FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
 * COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
 * IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
 * CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

declare(strict_types=1);

namespace CryptoTech\Laravel\Adsense\Providers;

use CryptoTech\Laravel\Adsense\AdsenseBuilder;
use Illuminate\Support\ServiceProvider;

/**
 * Class AdsenseServiceProvider.
 */
class AdsenseServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $configFile = __DIR__.'/../resources/config/adsense.php';

        if ($this->isLumen()) {
            $this->app->configure('adsense');
        } else {
            $this->publishes([
                $configFile => config_path('adsense.php'),
            ]);
        }

        $this->mergeConfigFrom($configFile, 'adsense');

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'adsense');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(AdsenseBuilder::class, function () {
            return new AdsenseBuilder();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'adsense',
        ];
    }
}

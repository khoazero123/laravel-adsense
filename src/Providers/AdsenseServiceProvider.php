<?php

/**
 * Google Adsense Ads for Laravel.
 *
 * Package for easily including Google Adsense Ad units
 * in Laravel and Lumen.
 *
 * @developer Martin Butt <https://www.martinbutt.com/>
 *
 * @copyright Copyright (c) 2021 Martin Butt
 * @license   MIT
 *
 * Copyright (c) 2016 Galen Han
 * Copyright (c) 2019 Crypto Technology srl
 * Copyright (c) 2021 Martin Butt
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

namespace MartinButt\Laravel\Adsense\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Application as LumenApplication;
use MartinButt\Laravel\Adsense\AdsenseBuilder;

/**
 * Class AdsenseServiceProvider.
 *
 * @see \Illuminate\Support\ServiceProvider
 */
class AdsenseServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'adsense');

        if ($this->app instanceof LumenApplication) {
            /* @scrutinizer ignore-call */ $this->app->configure('adsense');
        } else {
            // Publishing the configuration file.
            $this->publishes([
                $this->getConfigFile() => config_path('adsense.php'),
            ], 'config');
            // Publishing the views.
            $this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/adsense'),
            ], 'views');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            $this->getConfigFile(),
            'adsense'
        );

        $config = $this->app->make('config');
        if ($config->get('adsense.test', false)) {
            $config->set('adsense.client_id', 'ca-google');
        }

        $this->app->bind(AdsenseBuilder::class, function () {
            return new AdsenseBuilder();
        });

        $this->app->alias(AdsenseBuilder::class, 'adsense');
    }

    /**
     * {@inheritdoc}
     */
    public function provides(): array
    {
        return [
            AdsenseBuilder::class,
            'adsense',
        ];
    }

    /**
     * Return the path of configuration file.
     */
    protected function getConfigFile(): string
    {
        return __DIR__.'/../resources/config/adsense.php';
    }
}

<?php

namespace Modules\Payment\Providers;

use Gate;
use Modules\Payment\Gateways\Gateway;
use Illuminate\Support\ServiceProvider;
use Modules\Payment\Entities\Settlement;
use Illuminate\Database\Eloquent\Factory;
use Modules\Payment\Policies\SettlementPolicy;
use Modules\RolePermission\Entities\Permission;
use Modules\Payment\Gateways\Zarinpal\ZarinpalAdaptor;

class PaymentServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'Payment';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'payment';

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));

        $this->app->singleton(Gateway::class, function ($app) {
            return new ZarinpalAdaptor();
        });

        config()->set('sidebar.items.payments', [
            "icon" => "i-transactions",
            "title" => "تراکنش ها",
            "url" => url('payments'),
            "permission" => [
                Permission::PERMISSION_MANAGE_PAYMENTS,
            ]
        ]);

        config()->set('sidebar.items.my-purchases', [
            "icon" => "i-my__purchases",
            "title" => "خریدهای من",
            "url" => url('purchases'),
        ]);

        config()->set('sidebar.items.settlements', [
            "icon" => "i-checkouts",
            "title" => " تسویه حساب ها",
            "url" => url('settlements'),
            "permission" => [
                Permission::PERMISSION_TEACH,
                Permission::PERMISSION_MANAGE_SETTLEMENTS
            ]
        ]);

        config()->set('sidebar.items.settlementsRequest', [
            "icon" => "i-checkout__request",
            "title" => "درخواست تسویه",
            "url" => url('settlements/create'),
            "permission" => [
                Permission::PERMISSION_TEACH,
            ]
        ]);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
        Gate::policy(Settlement::class,SettlementPolicy::class);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            module_path($this->moduleName, 'Config/config.php') => config_path($this->moduleNameLower . '.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path($this->moduleName, 'Config/config.php'), $this->moduleNameLower
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/' . $this->moduleNameLower);

        $sourcePath = module_path($this->moduleName, 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ], ['views', $this->moduleNameLower . '-module-views']);

        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), $this->moduleNameLower);
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/' . $this->moduleNameLower);

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->moduleNameLower);
        } else {
            $this->loadJsonTranslationsFrom(module_path($this->moduleName, 'Resources/lang'), $this->moduleNameLower);
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

    private function getPublishableViewPaths(): array
    {
        $paths = [];
        foreach (\Config::get('view.paths') as $path) {
            if (is_dir($path . '/modules/' . $this->moduleNameLower)) {
                $paths[] = $path . '/modules/' . $this->moduleNameLower;
            }
        }
        return $paths;
    }
}

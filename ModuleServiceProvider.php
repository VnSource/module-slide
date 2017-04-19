<?php namespace VnsModules\Slide;

use Illuminate\Support\ServiceProvider;
use VnSource\Traits\ModuleServiceProviderTrait;

class ModuleServiceProvider extends ServiceProvider
{
    use ModuleServiceProviderTrait;

    public $hookView = [
        'admin.layout' => 'hook.admin'
    ];
    public $gadget = [
        'slide' => [
            'callback' => 'VnsModules\Slide\Gadget',
            'name' => 'Slide'
        ]
    ];
    public $permissions = [
        'slide' => 'Slide management'
    ];

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->initializationModule();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            SlideRepositoryInterface::class,
            SlideRepository::class
        );
    }
}

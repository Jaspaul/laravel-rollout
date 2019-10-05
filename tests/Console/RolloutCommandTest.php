<?php

namespace Tests\Console;

use Mockery;
use Tests\TestCase;
use Opensoft\Rollout\Feature;
use Opensoft\Rollout\Rollout;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Console\Kernel;
use Jaspaul\LaravelRollout\Drivers\Cache;
use Jaspaul\LaravelRollout\FeaturePresenter;
use Jaspaul\LaravelRollout\Console\RolloutCommand;

class RolloutCommandTest extends TestCase
{
    /**
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            TestServiceProvider::class,
        ];
    }

    /**
     * @test
     */
    function render_feature_as_a_table_renders_the_feature_as_a_table()
    {
        Artisan::call('rollout:test', [
            'feature' => 'derp'
        ]);

        $output = $this->app[Kernel::class]->output();

        $this->assertStringContainsString('derp', $output);
    }
}

class TestCommand extends RolloutCommand
{
    protected $signature = 'rollout:test {feature}';
    protected $description = 'A simple helper for testing.';

    public function handle()
    {
        $name = $this->argument('feature');
        $this->renderFeatureAsTable($name);
    }
}

class TestServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton(Rollout::class, function ($app) {
            return new Rollout(new Cache($app->make('cache.store')));
        });

        $this->commands([
            TestCommand::class
        ]);
    }
}

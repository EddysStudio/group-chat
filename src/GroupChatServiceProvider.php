<?php

namespace EddysStudio\GroupChat;

use Filament\Support\Assets\AlpineComponent;
use Filament\Support\Assets\Asset;
use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Facades\FilamentIcon;
use Illuminate\Filesystem\Filesystem;
use Livewire\Features\SupportTesting\Testable;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use EddysStudio\GroupChat\Commands\GroupChatCommand;
use EddysStudio\GroupChat\Testing\TestsGroupChat;

class GroupChatServiceProvider extends PackageServiceProvider
{
    public static string $name = 'group-chat';

    public static string $viewNamespace = 'group-chat';

    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package->name(static::$name)
            ->hasCommands($this->getCommands())
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->publishMigrations()
                    ->askToRunMigrations()
                    ->askToStarRepoOnGitHub('eddysstudio/group-chat');
            });

        $configFileName = $package->shortName();

        if (file_exists($package->basePath("/../config/{$configFileName}.php"))) {
            $package->hasConfigFile();
        }

        if (file_exists($package->basePath('/../database/migrations'))) {
            $package->hasMigrations($this->getMigrations());
        }

        if (file_exists($package->basePath('/../resources/lang'))) {
            $package->hasTranslations();
        }

        if (file_exists($package->basePath('/../resources/views'))) {
            $package->hasViews(static::$viewNamespace);
        }
    }

    public function packageRegistered(): void {}

    public function packageBooted(): void
    {
        // Asset Registration
        FilamentAsset::register(
            $this->getAssets(),
            $this->getAssetPackageName()
        );

        FilamentAsset::registerScriptData(
            $this->getScriptData(),
            $this->getAssetPackageName()
        );

        // Icon Registration
        FilamentIcon::register($this->getIcons());

        // Handle Stubs
        if (app()->runningInConsole()) {
            foreach (app(Filesystem::class)->files(__DIR__ . '/../stubs/') as $file) {
                $this->publishes([
                    $file->getRealPath() => base_path("stubs/group-chat/{$file->getFilename()}"),
                ], 'group-chat-stubs');
            }
        }
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');  
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'group-chat'); 
        $this->publishes([
            __DIR__.'/../resources/js/axios.min.js' => public_path('vendor/group-chat/axios.min.js'),
            __DIR__.'/../resources/js/alpine.min.js' => public_path('vendor/group-chat/alpine.min.js'),
            __DIR__.'/../resources/css/main.css' => public_path('vendor/group-chat/main.css')
        ], 'group-chat-assets');
        // Testing
        Testable::mixin(new TestsGroupChat);
    }

    protected function getAssetPackageName(): ?string
    {
        return 'eddysstudio/group-chat';
    }

    /**
     * @return array<Asset>
     */
    protected function getAssets(): array
    {
        return [
            // AlpineComponent::make('group-chat', __DIR__ . '/../resources/dist/components/group-chat.js'),
            // Css::make('group-chat-styles', __DIR__ . '/../resources/dist/group-chat.css'),
            // Js::make('group-chat-scripts', __DIR__ . '/../resources/dist/group-chat.js'),
            Js::make('group-chat-scripts', __DIR__ . '/../resources/js/axios.min.js'),
        ];
    }

    /**
     * @return array<class-string>
     */
    protected function getCommands(): array
    {
        return [
            GroupChatCommand::class,
        ];
    }

    /**
     * @return array<string>
     */
    protected function getIcons(): array
    {
        return [];
    }

    /**
     * @return array<string>
     */
    protected function getRoutes(): array
    {
        return [];
    }

    /**
     * @return array<string, mixed>
     */
    protected function getScriptData(): array
    {
        return [];
    }

    /**
     * @return array<string>
     */
    protected function getMigrations(): array
    {
        return [
            'create_group-chat_table',
        ];
    }
}

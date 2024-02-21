<?php

namespace App\Providers;

use App\Services\AwsSecretsManager;
use Illuminate\Support\ServiceProvider;

class AwsSecretsManagerProvider extends ServiceProvider
{
/**
     * Bootstrap the application services.
     */
    public function boot()
    {
        // Load Secrets
        if (config('aws-secrets-manager.enable-secrets-manager')) {
            $secretsManager = new AwsSecretsManager();
            $secretsManager->loadSecrets();
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        //
    }
}

<?php

namespace App\Services;

use Aws\SecretsManager\SecretsManagerClient;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class AwsSecretsManager
{
    protected $client;
    protected $cache;
    protected $cacheExpiry;
    protected $cacheStore;
    protected $cacheName;
    protected $debug;
    protected $enabledEnvironments;

    public function __construct()
    {
        $this->cache = config('aws-secrets-manager.cache-enabled', true);

        $this->cacheExpiry = config('aws-secrets-manager.cache-expiry', 0);

        $this->cacheStore = config('aws-secrets-manager.cache-store', 'file');

        $this->cacheName = config('aws-secrets-manager.cache-name');

        $this->debug = config('aws-secrets-manager.debug', false);
    }

    public function loadSecrets()
    {
        // Load vars from datastore to env
        if ($this->debug) {
            $start = microtime(true);
        }

        $this->getVariables();

        if ($this->debug) {
            $time_elapsed_secs = microtime(true) - $start;
            error_log('Datastore secret request time: '.$time_elapsed_secs);
        }
    }

    protected function checkCache()
    {
        return Cache::store($this->cacheStore)->has($this->cacheName);
    }

    protected function getFromAwsSecretsManager()
    {
        try {
            $this->client = new SecretsManagerClient([
                'version' => 'latest',
            ]);

            $secrets = $this->client->listSecrets([
                'MaxResults' => 100,
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return;
        }

        $environments = [];

        foreach ($secrets['SecretList'] as $secret) {
            if (isset($secret['ARN'])) {
                $result = $this->client->getSecretValue([
                    'SecretId' => $secret['ARN'],
                ]);

                $secretValues = json_decode($result['SecretString'], true);

                if (is_array($secretValues) && count($secretValues) > 0) {
                    if (isset($secretValues['name']) && isset($secretValues['value'])) {

                        $key = $secretValues['name'];
                        $secret = $secretValues['value'];
                        putenv("$key=$secret");

                        $environments[$key] = $secret;
                    } else {
                        foreach ($secretValues as $key => $value) {
                            putenv("$key=$value");
                            $environments[$key] = $value;
                        }
                    }
                }
            }
        }

        if (count($environments)) {
            $this->storeToCache($environments);
        }
    }

    public function getFromCache()
    {
        $environments = Cache::store($this->cacheStore)->get($this->cacheName);

        foreach($environments as $key => $value) {
            putenv("$key=$value");
        }
    }

    protected function getVariables()
    {
        if (! $this->checkCache()) {
            $this->getFromAwsSecretsManager();
        } else {
            $this->getFromCache();
        }
    }

    protected function storeToCache(array $values)
    {
        if ($this->cache) {
            Cache::store($this->cacheStore)->put($this->cacheName, $values, $this->cacheExpiry * 60);
        }
    }
}

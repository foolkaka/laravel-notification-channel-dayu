<?php

namespace NotificationChannels\Dayusms;

use NotificationChannels\Dayusms\Exceptions\InvalidConfiguration;
use Illuminate\Support\ServiceProvider;

class DayusmsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->app->when(DayusmsChannel::class)
            ->needs(\TopClient::class)
            ->give(function () {
                $config = config('services.dayu');

                if (is_null($config) || !isset($config['app_key']) || !isset($config['app_secret'])) {
                    throw InvalidConfiguration::configurationNotSet();
                }

                if (!defined("TOP_SDK_WORK_DIR")){
                    $logDir = isset($config['log_dir']) && !is_null($config['log_dir'])
                        ? $config['log_dir']
                        : storage_path();
                    define("TOP_SDK_WORK_DIR", $logDir);
                }

                $topClient = new \TopClient(
                    $config['app_key'],
                    $config['app_secret']
                );
                $topClient->format = isset($config['format']) && !is_null($config['format'])
                    ? $config['format']
                    : 'json';

                return $topClient;
            });
    }
}

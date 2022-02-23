<?php

namespace App\Providers;

use Exception;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\Facades\Storage;
use Justijndepover\Teamleader\Teamleader;

class TeamleaderServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function register()
    {
        $this->app->singleton(Teamleader::class, function ($app) {
            $teamleader = new Teamleader(
                config('d4edfc96ff1d0814c57f3ed0a72cebc8'),
                config('5970126c1d1c11eecda444da5c4a4a85'),
                config('https://vbdashboard.test/teamleader/accept'),
                config('test'),
            );

            $teamleader->setTokenUpdateCallback(function ($teamleader) {
                Storage::disk('local')->put('teamleader.json', json_encode([
                    'accessToken' => $teamleader->getAccessToken(),
                    'refreshToken' => $teamleader->getRefreshToken(),
                    'expiresAt' => $teamleader->getTokenExpiresAt(),
                ]));
            });

            if (Storage::exists('teamleader.json') && $json = Storage::get('teamleader.json')) {
                try {
                    $json = json_decode($json);
                    $teamleader->setAccessToken($json->accessToken);
                    $teamleader->setRefreshToken($json->refreshToken);
                    $teamleader->setTokenExpiresAt($json->expiresAt);
                } catch (Exception $e) {
                }
            }

            if (! empty($teamleader->getRefreshToken()) && $teamleader->shouldRefreshToken()) {
                try {
                    $teamleader->connect();
                } catch (\Throwable $th) {
                    $teamleader->setRefreshToken('');

                    Storage::disk('local')->put('teamleader.json', json_encode([
                    'accessToken' => $teamleader->getAccessToken(),
                    'refreshToken' => $teamleader->getRefreshToken(),
                    'expiresAt' => $teamleader->getTokenExpiresAt(),
                ]));
                }
            }

            return $teamleader;
        });
    }

    public function provides()
    {
        return [Teamleader::class];
    }
}

<?php

namespace App\Providers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Storage::extend('google', function ($app, $config) {
            $client = new \Google_Client();
            $client->setClientId($config['clientId']);
            $client->setClientSecret($config['clientSecret']);
            $client->setAccessType('offline');
            $client->setPrompt('select_account consent');

            // Refresca y obtiene el access token
            $accessToken = $client->fetchAccessTokenWithRefreshToken($config['refreshToken']);

            // Verifica que no haya errores en la respuesta
            if (isset($accessToken['error'])) {
                throw new \Exception('Error al obtener access token: ' . json_encode($accessToken));
            }

            // 🛠️ Aseguramos que el refresh_token esté presente
            $accessToken['refresh_token'] = $config['refreshToken'];

            // 🧠 Añade campo 'created' si falta (Google lo usa internamente)
            if (!isset($accessToken['created'])) {
                $accessToken['created'] = time();
            }

            // Asigna el token completo
            $client->setAccessToken($accessToken);

            // Crea el servicio de Drive
            $service = new \Google_Service_Drive($client);

            // Crea el adaptador de Flysystem
            $adapter = new \Masbug\Flysystem\GoogleDriveAdapter($service, $config['folderId'] ?? null);

            return new \Illuminate\Filesystem\FilesystemAdapter(
                new \League\Flysystem\Filesystem($adapter),
                $adapter,
                $config
            );
        });
    }
}

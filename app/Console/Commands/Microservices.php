<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class Microservices extends Command
{
    protected $signature = 'make:microservice';

    protected $description = 'Descripción de mi comando personalizado';

    public function handle()
    {
        $nombreClase = $this->ask('Ingrese el nombre de la clase que desea crear');

        // Define la ruta donde se creará el archivo de clase
        $ruta = app_path('Microservices/' . $nombreClase . '.php');

        // Verifica si el archivo ya existe
        if (File::exists($ruta)) {
            $this->error('La clase ya existe.');
            return;
        }

        // Crea el archivo de clase
        File::put($ruta, '<?php

namespace App\Microservices;

class ' . $nombreClase . " extends Microservice" .'
{
    // Código de la clase...
}
');

        $this->info('Clase creada exitosamente en: ' . $ruta);
    }
}

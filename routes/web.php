<?php

// routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SoapDemoController;

// ... rutas existentes ...

/*
|--------------------------------------------------------------------------
| Rutas para Servicios SOAP - Información de Países
|--------------------------------------------------------------------------
|
| Rutas que interactúan con el servicio SOAP de información de países
| Servicio: http://webservices.oorsprong.org/websamples.countryinfo/CountryInfoService.wso?WSDL
|
| Métodos disponibles:
| - getCountryName() - Obtener nombre del país
| - getCapitalCity() - Obtener capital
| - getCountryCurrency() - Obtener moneda
| - getCountryIntPhone() - Obtener código telefónico
| - getFullCountryInfo() - Obtener información completa
| - getCountryISOCode() - Buscar código por nombre
| - listCountryNamesByCode() - Listar todos los países
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Página principal del demo SOAP
Route::get('soap-');

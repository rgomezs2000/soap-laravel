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
Route::get('/soap-demo', [SoapDemoController::class, 'index'])->name('soap-demo');

// ======================== ENDPOINTS INDIVIDUALES ========================

// Obtener nombre del país por código ISO
Route::post('/soap/get-country-name', [SoapDemoController::class, 'getCountryName'])->name('soap.get-country-name');

// Obtener capital del país
Route::post('/soap/get-capital-city', [SoapDemoController::class, 'getCapitalCity'])->name('soap.capital-city');

//Obtener moneda del país
Route::post('/soap/get-country-currency', [SoapDemoController::class, 'getCountryCurrency'])->name('soap.get-country-currency');

// Obtener código telefónico internacional
Route::post('/soap/get-phone-code', [SoapDemoController::class, 'getCountryIntPhone'])->name('soap.get-phone-code');

// ====================== ENDPOINT INFORMACIÓN COMPLETA ======================

// Obtener toda la información del país
Route::post('/soap/get-full-country-info', [SoapDemoController::class, 'getFullCountryInfo'])->name('soap.get-full-country-info');

// ====================== ENDPOINT DE BÚSQUEDA =============================

// Buscar código ISO por nombre del país
Route::post('/soap/search-country-iso-code', [SoapDemoController::class, 'getCountryISOCode'])->name('soap.search-country-iso-code');

// ====================== ENDPOINT DE LISTADO ==============================

// Listar todos los países
Route::post('/soap/list-all-countries', [SoapDemoController::class, 'listCountryNameByCode'])->name('soap.list-all-countries');

// Obtener bandera del país
Route::post('/soap/get-country-flag', [SoapDemoController::class, 'getCountryFlag'])->name('soap.get-country-flag');

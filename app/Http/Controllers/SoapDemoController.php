<?php

namespace App\Http\Controllers;

use App\Services\CountryInfoService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use SoapFault;

/**
 * Controlador para demostración de Web Services SOAP
 *
 * Maneja las peticiones relacionadas con el consumo de servicios SOAP
 * Proporciona endpoints para obtener información de países
 *
 * @package App\Http\Controllers
 * @author Roger Alejandro Gomez Sanabria
 */
class SoapDemoController extends Controller
{
    /**
     * Mostrar página principal de demostración
     *
     * Retorna la vista con el formulario para consultar información de países
     *
     * @return View Vista del demo SOAP
     *
     * @example
     * GET /soap-demo
     */
    public function index() : view
    {
        return view('soap-demo');
    }

    /**
     * Obtener nombre del país por código ISO
     *
     * Endpoint AJAX que obtiene el nombre del país usando su código ISO
     *
     * @param Request $request Petición HTTP con el parámetro 'country_code'
     *
     * @return JsonResponse Respuesta JSON con el nombre del país o error
     *
     * @example
     * POST /soap/get-country-name
     * {
     *     "country_code": "CL"
     * }
     *
     * Response (éxito):
     * {
     *     "success": true,
     *     "country_code": "CL",
     *     "country_name": "Chile"
     * }
     */
    public function getCountryName(Request $request) : JsonResponse
    {
        try
        {
            // Validar entrada del usuario
            $request->validate([
                'country_code' => 'required|string|size:2'
            ]);

            $countryCode = strtoupper($request->country_code);

            // Crear servicio SOAP
            $service = new CountryInfoService();

            // Obtener nombre del país
            $name = $service->getCountryName($countryCode);

            // Retornar respuesta exitosa
            return response()->json([
                'success' => true,
                'country_code' => $countryCode,
                'country_name' => $name
            ]);
        }catch(SoapFault $sf)
        {
            // Error de SOAP
            return response()->json([
                'success' => false,
                'error' => 'Error de SOAP: '.$sf->getMessage()
            ], 400);
        }catch(Exception $ex)
        {
            // Otro error
            return response()->json([
                'success' => false,
                'error' => $ex->getMessage()
            ], 500);
        }
    }

        /**
     * Obtener capital del país
     *
     * Endpoint AJAX que obtiene la capital de un país
     *
     * @param Request $request Petición HTTP con el parámetro 'country_code'
     *
     * @return JsonResponse Respuesta JSON con la capital o error
     *
     * @example
     * POST /soap/get-capital-city
     * {
     *     "country_code": "CL"
     * }
     *
     * Response (éxito):
     * {
     *     "success": true,
     *     "country_code": "CL",
     *     "capital_city": "Santiago"
     * }
     */
    public function getCapitalCity(Request $request) : JsonResponse
    {
        try{
            // Validar entrada del usuario
            $request->validate([
                'country_code' => 'required|string|size:2'
            ]);

            $countryCode = strtoupper($request->country_code);

            // Crear servicio SOAP
            $service = new CountryInfoService();

            // Obtener capital
            $capital = $service->getCapitalCity($countryCode);

            // Retornar respuesta exitosa
            return response()->json([
                'success' => true,
                'country_code' => $countryCode,
                'capital_city' => $capital
            ]);
        }catch(SoapFault $sf)
        {
            // Error de SOAP
            return response()->json([
                'success' => false,
                'error ' => 'Error de SOAP: '.$sf->getMessage()
            ], 400);
        }catch(Exception $ex)
        {
            // Otro error
            return response()->json([
                'success' => false,
                'error' => $ex->getMessage()
            ]);
        }
    }

    /**
     * Obtener moneda del país
     *
     * Endpoint AJAX que obtiene la moneda de un país
     *
     * @param Request $request Petición HTTP con el parámetro 'country_code'
     *
     * @return JsonResponse Respuesta JSON con la moneda o error
     *
     * @example
     * POST /soap/get-country-currency
     * {
     *     "country_code": "CL"
     * }
     *
     * Response (éxito):
     * {
     *     "success": true,
     *     "country_code": "CL",
     *     "currency": "CLP"
     * }
     */
    public function getCountryCurrency(Request $request) : JsonResponse
    {
        try
        {
            // Validar entrada del usuario
            $request->validate([
                'country_code' => 'required|string|size:2'
            ]);

            $countryCode = strtoupper($request->country_code);

            // Crear servicio SOAP
            $service = new CountryInfoService();

            // Obtener moneda
            $currency = $service->getCountryCurrency($countryCode);

            // Retornar respuesta exitosa
            return response()->json([
                'success' => true,
                'country_code' => $countryCode,
                'currency' => $currency
            ]);

        }catch(SoapFault $sf)
        {
            // Error de SOAP
            return response()->json([
                'success' => false,
                'error' => 'Error de SOAP: '.$sf->getMessage()
            ]);
        }catch(Exception $ex)
        {
            // Otro error
            return response()->json([
                'success' => false,
                'error' => $ex->getMessage()
            ]);
        }
    }

    /**
     * Obtener código de teléfono internacional
     *
     * Endpoint AJAX que obtiene el código de marcación internacional
     *
     * @param Request $request Petición HTTP con el parámetro 'country_code'
     *
     * @return JsonResponse Respuesta JSON con el código telefónico o error
     *
     * @example
     * POST /soap/get-phone-code
     * {
     *     "country_code": "CL"
     * }
     *
     * Response (éxito):
     * {
     *     "success": true,
     *     "country_code": "CL",
     *     "phone_code": "+56"
     * }
     */
    public function getCountryIntPhone(Request $request) : JsonResponse
    {
        try
        {
            // Validar entrada del usuario
            $request->validate([
                'country_code' => 'required|string|size:2'
            ]);

            $countryCode = strtoupper($request->country_code);

            // Crear servicio SOAP
            $service = new CountryInfoService();

            // Obtener código telefónico
            $phoneCode = $service->getCountryIntPhone($countryCode);

            // Retornar respuesta exitosa
            return response()->json([
                'success'       => true,
                'country_code'  => $countryCode,
                'phone_code'    => $phoneCode
            ]);
        }catch(SoapFault $sf)
        {
            // Error de SOAP
            return response()->json([
                'success' => false,
                'error' => 'Error de SOAP: '.$sf->getMessage()
            ]);
        }catch(Exception $ex)
        {
            // Otro error
            return response()->json([
                'success' => false,
                'error' => $ex->getMessage()
            ]);
        }
    }

    /**
     * Obtener información completa del país
     *
     * Endpoint AJAX que obtiene toda la información disponible del país
     * en una sola llamada SOAP
     *
     * @param Request $request Petición HTTP con el parámetro 'country_code'
     *
     * @return JsonResponse Respuesta JSON con toda la información o error
     *
     * @example
     * POST /soap/get-full-country-info
     * {
     *     "country_code": "CL"
     * }
     *
     * Response (éxito):
     * {
     *     "success": true,
     *     "country_code": "CL",
     *     "data": {
     *         "name": "Chile",
     *         "capital": "Santiago",
     *         "continent": "South America",
     *         "currency_code": "CLP",
     *         "flag_url": "http://example.com/flag.png"
     *     }
     * }
     */
    public function getFullCountryInfo(Request $request): JsonResponse
    {
        try
        {
            // Validar entrada del usuario
            $request->validate([
                'country_code' => 'required|string|size:2'
            ]);

            $countryCode = strtoupper($request->country_code);

            // Crear servicio SOAP
            $service = new CountryInfoService();

            // Obtener información completa del país
            $info = $service->getFullCountryInfo($countryCode);

            // Retornar respuesta exitosa
            return response()->json([
                'success' => true,
                'country_code' => $countryCode,
                'data' => [
                    'name' => $info->sName ?? 'N/A',
                    'capital' => $info->sCapitalCity ?? 'N/A',
                    'continent' => $info->sContinent ?? 'N/A',
                    'currency_code' => $info->sCurrencyISOCode ?? 'N/A',
                    'flag_url' => $info->sCountryFlag ?? 'N/A',
                    'language_code' => $info->sLanguageISOCode ?? 'N/A',
                ]
            ]);
        }catch(SoapFault $sf)
        {
            // Error de SOAP
            return response()->json([
                'success' => false,
                'error' => 'Error de SOAP: '.$sf->getMessage()
            ]);
        }catch(Exception $ex)
        {
            // Otro error
            return response()->json([
                'success' => false,
                'error' => $ex->getMessage()
            ]);
        }
    }
}

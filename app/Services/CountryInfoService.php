<?php
namespace App\Services;

use Override;

/**
 * Servicio para convertir números a palabras
 *
 * Utiliza el servicio SOAP público de DataAccess para convertir
 * números enteros a sus representaciones en palabras en inglés
 *
 * @package App\Services
 * @author Roger Alejandro Gomez Sanabria
 */
class CountryInfoService extends SoapService
{
    /**
     * URL del WSDL de DataAccess
     *
     * @var string
     */
    private const WSDL_URL = "http://webservices.oorsprong.org/websamples.countryinfo/CountryInfoService.wso?WSDL";

    /**
     * Constructor
     *
     * Inicializa la conexión al servicio SOAP de información de países
     *
     * @throws \SoapFault Si no puede conectar al servicio
     *
     * @example
     * $service = new CountryInfoService();
     * echo $service->getCountryName('CL');      // Output: Chile
     * echo $service->getCapitalCity('CL');      // Output: Santiago
     */
    public function __construct()
    {
        return parent::__construct(self::WSDL_URL);
    }

    /**
     * Obtener nombre del país por código ISO
     *
     * Busca el nombre del país usando su código ISO de 2 letras
     *
     * @param string $countryCode Código ISO del país (ej: CL, US, ES)
     *
     * @return string Nombre del país
     *
     * @throws \SoapFault Si hay error en la consulta SOAP
     *
     * @example
     * $service = new CountryInfoService();
     * echo $service->getCountryName('CL');      // Output: Chile
     * echo $service->getCountryName('US');      // Output: United States
     * echo $service->getCountryName('ES');      // Output: Spain
     */
    public function getCountryName($countryCode) : string
    {
        // Llamar a la operación SOAP 'CountryName'
        $response = $this->call('CountryName', [
            'sCountryISOCode' => strtoupper((string) $countryCode)
        ]);

        return (string) $response->CountryNameResult;
    }

    /**
     * Obtener capital del país
     *
     * Obtiene el nombre de la capital para un código de país específico
     *
     * @param string $countryCode Código ISO del país (ej: CL, US, ES)
     *
     * @return string Nombre de la capital
     *
     * @throws \SoapFault Si hay error en la consulta SOAP
     *
     * @example
     * $service = new CountryInfoService();
     * echo $service->getCapitalCity('CL');      // Output: Santiago
     * echo $service->getCapitalCity('US');      // Output: Washington
     * echo $service->getCapitalCity('ES');      // Output: Madrid
     */
    public function getCapitalCity($countryCode) : string
    {
        // Llamar a la operación SOAP 'CapitalCity'
        $response = $this->call('CapitalCity', [
            'sCountryISOCode' => strtoupper((string) $countryCode)
        ]);

        return (string) $response->CapitalCityResult;
    }

    /**
     * Obtener información de moneda del país
     *
     * Obtiene el código ISO y nombre de la moneda para un país
     *
     * @param string $countryCode Código ISO del país (ej: CL, US, ES)
     *
     * @return object Objeto con propiedades:
     *                - sISOCode: Código ISO de la moneda (ej: CLP, USD, EUR)
     *                - sName: Nombre de la moneda (ej: Chilean Peso, US Dollar)
     *
     * @throws \SoapFault Si hay error en la consulta SOAP
     *
     * @example
     * $service = new CountryInfoService();
     * $currency = $service->getCountryCurrency('CL');
     * echo $currency->sISOCode;  // Output: CLP
     * echo $currency->sName;     // Output: Chilean Peso
     */
    public function getCountryCurrency($countryCode) : string
    {
        // Llamar a la operación SOAP 'CountryCurrency'
        $response = $this->call('CountryCurrency', [
            'sCountryISOCode' => strtoupper((string) $countryCode)
        ]);

        return (string) $response->CountryCurrencyResult;
    }
}

?>

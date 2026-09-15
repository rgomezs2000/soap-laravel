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

    /**
     * Obtener código de teléfono internacional
     *
     * Obtiene el código de marcación internacional para un país
     *
     * @param string $countryCode Código ISO del país (ej: CL, US, ES)
     *
     * @return string Código de teléfono internacional (ej: +56, +1, +34)
     *
     * @throws \SoapFault Si hay error en la consulta SOAP
     *
     * @example
     * $service = new CountryInfoService();
     * echo $service->getCountryIntPhoneCode('CL');   // Output: +56
     * echo $service->getCountryIntPhoneCode('US');   // Output: +1
     * echo $service->getCountryIntPhoneCode('ES');   // Output: +34
     */
    public function getCountryIntPhone($countryCode) : string
    {
        // Llamar a la operación SOAP 'CountryIntPhoneCode'
        $response = $this->call('CountryIntPhoneCode', [
            'sCountryISOCode' => strtoupper((string) $countryCode)
        ]);

        return (string) $response->CountryIntPhoneCodeResult;
    }

    /**
     * Obtener información completa del país
     *
     * Obtiene toda la información disponible para un país en una sola llamada
     * (capital, moneda, continente, códigos, idiomas, etc.)
     *
     * @param string $countryCode Código ISO del país (ej: CL, US, ES)
     *
     * @return object Objeto con todas las propiedades del país:
     *                - sISOCode: Código ISO (2 letras)
     *                - sName: Nombre del país
     *                - sCapitalCity: Capital
     *                - sContinent: Continente
     *                - sCountryISOCode: Código ISO
     *                - sCurrencyISOCode: Código de moneda
     *                - sCountryFlag: URL a la bandera
     *                - sLanguageISOCode: Código de idioma principal
     *
     * @throws \SoapFault Si hay error en la consulta SOAP
     *
     * @example
     * $service = new CountryInfoService();
     * $info = $service->getFullCountryInfo('CL');
     * echo $info->sName;           // Output: Chile
     * echo $info->sCapitalCity;    // Output: Santiago
     * echo $info->sCurrencyISOCode; // Output: CLP
     * echo $info->sContinent;      // Output: South America
     */
    public function getFullCountryInfo($countryCode) : object
    {
        // Llamar a la operación SOAP 'FullCountryInfo'
        $response = $this->call('FullCountryInfo', [
            'sCountryISOCode' => strtoupper((string) $countryCode)
        ]);

        return $response->FullCountryInfoResult;
    }

    /**
     * Obtener código ISO del país por nombre
     *
     * Busca el código ISO de un país basándose en su nombre
     *
     * @param string $countryName Nombre del país (ej: Chile, United States)
     *
     * @return string Código ISO del país (2 letras)
     *
     * @throws \SoapFault Si hay error en la consulta SOAP
     *
     * @example
     * $service = new CountryInfoService();
     * echo $service->getCountryISOCode('Chile');          // Output: CL
     * echo $service->getCountryISOCode('United States');  // Output: US
     * echo $service->getCountryISOCode('Spain');          // Output: ES
     */
    public function getCountryISOCode($countryName) : string
    {
        // Llamar a la operación SOAP 'CountryISOCode'
        $response = $this->call('CountryISOCode', [
            'sCountryName' => (string) $countryName
        ]);

        return (string) $response->CountryISOCodeResult;
    }

    /**
     * Obtener lista de países ordenados por código
     *
     * Retorna un array con todos los países disponibles ordenados por código ISO
     *
     * @return array Array de objetos con:
     *               - sISOCode: Código ISO
     *               - sName: Nombre del país
     *
     * @throws \SoapFault Si hay error en la consulta SOAP
     *
     * @example
     * $service = new CountryInfoService();
     * $countries = $service->listCountryNamesByCode();
     * foreach ($countries as $country) {
     *     echo $country->sISOCode . ' - ' . $country->sName . "\n";
     * }
     */
    public function listCountryNamesByCode(): array
    {
        // Llamar a la operación SOAP 'ListOfCountryNamesByCode'
        $response = $this->call('ListOfCountryNamesByCode', []);

        // Convertir a array si es necesario
        if(isset($response->ListOfCountryNamesByCodeResult->tCountryCodeAndName))
        {
            $result = $response->ListOfCountryNamesByCodeResult->tCountryCodeAndName;

            return is_array($result) ? $result : [$result];
        }

        return [];
    }
}

?>

<?php
namespace App\Services;

use SoapClient;
use SoapFault;

/**
 * Clase base para consumir Web Services SOAP
 *
 * Esta clase maneja la conexión y comunicación con servicios SOAP
 * Proporciona métodos útiles para trabajar con SOAP de forma segura
 *
 * @package App\Services
 * @author Roger Alejandro Gomez Sanabria
 */
class SoapService{
    /**
     * Instancia del cliente SOAP
     *
     * @var SoapClient
     */
    protected $client;

    /**
     * URL del WSDL del servicio
     *
     * @var string
     */
    protected $wsdlUrl;

    /**
     * Opciones de conexión
     *
     * @var array
     */
    protected $options = [];

    /**
     * Constructor
     *
     * Inicializa el servicio SOAP con la URL del WSDL y opciones personalizadas
     *
     * @param string $wsdlUrl URL del archivo WSDL del servicio
     * @param array  $options Opciones adicionales de SoapClient (opcional)
     *
     * @throws SoapFault Si no puede conectar al servicio
     */
    public function __construct($wsdlUrl, $options = [])
    {
        $this->wsdlUrl = $wsdlUrl;

        // Configurar opciones por defecto
        $this->options = array_merge([
            'trace'                 => true,           // Habilitar debugging
            'exceptions'            => true,           // Lanzar excepciones en errores
            'cache_wsdl'            => WSDL_CACHE_BOTH, // Cachear WSDL para mejor rendimiento
            'timeout'               => 30,              // Timeout en segundos
            'connection_timeout'    => 30,              // Timeout de conexión
        ], $options);

        // Conectar al servicio
        $this->connect();
    }

    /**
     * Conectar al servicio SOAP
     *
     * Intenta establecer una conexión con el servidor SOAP
     * Si falla, lanza una excepción con detalles del error
     *
     * @return void
     *
     * @throws SoapFault Si no puede conectar al servidor
     */
    protected function connect()
    {
        try {
            $this->client = new SoapClient($this->wsdlUrl, $this->options);

        } catch (SoapFault $e) {
            throw new SoapFault(
                'connection_error',
                'No se pudo conectar al servicio SOAP: ' . $e->getMessage()
            );
        }
    }

    /**
     * Llamar a un método SOAP
     *
     * Ejecuta una operación SOAP en el servidor remoto
     *
     * @param string $methodName Nombre del método SOAP a ejecutar
     * @param array  $params     Parámetros del método (opcional)
     *
     * @return object Respuesta del servidor SOAP
     *
     * @throws SoapFault Si hay error al ejecutar la operación
     *
     * @example
     * $service = new SoapService('http://ejemplo.com/servicio.wsdl');
     * $response = $service->call('MiMetodo', ['param' => 'valor']);
     */
    public function call($methodName, $params = [])
    {
        try {
            $response = $this->client->$methodName($params);
            return $response;

        } catch (SoapFault $e) {
            throw new SoapFault(
                'method_call_error',
                'Error al llamar ' . $methodName . ': ' . $e->getMessage()
            );
        }
    }

    /**
     * Obtener lista de operaciones disponibles
     *
     * Retorna un array con todas las operaciones SOAP disponibles en el servidor
     *
     * @return array Lista de operaciones SOAP
     *
     * @example
     * $service = new SoapService('http://ejemplo.com/servicio.wsdl');
     * $operaciones = $service->getOperations();
     * foreach ($operaciones as $op) {
     *     echo $op . "\n";
     * }
     */
    public function getOperations()
    {
        return $this->client->__getFunctions();
    }

    /**
     * Obtener tipos disponibles
     *
     * Retorna un array con todos los tipos de datos definidos en el WSDL
     *
     * @return array Lista de tipos SOAP
     *
     * @example
     * $service = new SoapService('http://ejemplo.com/servicio.wsdl');
     * $tipos = $service->getTypes();
     */
    public function getTypes()
    {
        return $this->client->__getTypes();
    }

    /**
     * Obtener última petición XML (para debugging)
     *
     * Útil para inspeccionar el XML que se envió al servidor SOAP
     * Solo funciona si 'trace' está habilitado en las opciones
     *
     * @return string XML de la última petición enviada
     *
     * @example
     * $service = new SoapService('http://ejemplo.com/servicio.wsdl');
     * $service->call('MiMetodo', ['param' => 'valor']);
     * echo $service->getLastRequest();
     */
    public function getLastRequest()
    {
        return $this->client->__getLastRequest();
    }

    /**
     * Obtener última respuesta XML (para debugging)
     *
     * Útil para inspeccionar el XML que recibió del servidor SOAP
     * Solo funciona si 'trace' está habilitado en las opciones
     *
     * @return string XML de la última respuesta recibida
     *
     * @example
     * $service = new SoapService('http://ejemplo.com/servicio.wsdl');
     * $service->call('MiMetodo', ['param' => 'valor']);
     * echo $service->getLastResponse();
     */
    public function getLastResponse()
    {
        return $this->client->__getLastResponse();
    }
}
?>

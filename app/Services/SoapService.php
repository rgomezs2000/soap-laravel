<?php
    namespace App\Services;

use SoapClient;
use SoapFault;

    /*** * Clase base para consumir Web Services SOAP * * Esta clase maneja la conexión y comunicación con servicios SOAP * Proporciona métodos útiles para trabajar con SOAP de forma segura */
    class SoapService{
        //Instancia del cliente SOAP
        protected $client;
        //URL del WSDL del servicio
        protected $wsdlUrl;
        //Opciones de conexión
        protected $options = [];

        /**
         * * Constructor * *
         *  @param string $wsdlUrl URL del archivo WSDL *
         *  @param array $options Opciones adicionales de SoapClient
         * */
        public function __construct($wsdlUrl, $options = []){
            $this->wsdlUrl = $wsdlUrl;
            //Opciones por defecto
            $this->option = array_merge([
                'trace' => true,
                // Para debugging
                'exceptions' => true,
                // Lanzar excepciones en errores
                'cache_wsdl' => WSDL_CACHE_BOTH,
                // Cachear WSDL
                'timeout' => 30,
                // Timeout en segundos
                'connection_timeout' => 30, ],
                $options
            );
            $this->connect();
        }

        /** * Conectar al servicio SOAP */
        protected function connect(){
            try{
                $this->client = new SoapClient($this->wsdlUrl, $this->options);
            }catch(SoapFault $sf){
                throw new SoapFault(
                    'connection_error',
                    'No se pudo conectar al servicio SOAP: '. $sf->getMessage()
                );
            }
        }

        /**
         *  Llamar a un método SOAP *
         * @param string $methodName Nombre del método *
         * @param array $params Parámetros del método *
         * @return object Respuesta del servidor
         * */
        public function call($methodName, $params = []){
            try{
                $response = $this->client->$methodName($params);

                return $response;
            }catch(SoapFault $sf){
                throw new SoapFault(
                    'method_call_error',
                    'Error al llamar '. $methodName.': '. $sf->getMessage()
                );
            }
        }
    }

?>

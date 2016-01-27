<?php
namespace BreakCheck;

    /**
     * Manipula as mensagens recebidas pelo socket.
     */
    class SocketController
    {
        private $_model;
        private $_action;
        private $_params;
        public function __construct($model, string $action, array $params)
        {
            $this->_action = $action;
            $this->_model = $model;
            if (!method_exists($this, strtolower($this->_action))) {
                throw new \Exception('Invalid action', 40);

                return false;
            }
            $this->_params = $params;

            return true;
        }

        public function getMarkers()
        {
            $lat = $this->_params['latitude'];
            $lon = $this->_params['longitude'];
            $this->_model->setCoordinates($lat, $lon);
            $this->_model->getMarkers();

            return true;
        }
        

        public function setMarker()
        {
            $lat = $this->_params['latitude'];
            $lon = $this->_params['longitude'];
            $nome = $this->_params['nome'];
            $this->_model->setNome($nome);
            $this->_model->setCoordinates($lat, $lon);
            $this->_model->setMarker();
        }
    }

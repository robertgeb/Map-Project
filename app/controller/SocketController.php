<?php
    namespace BreakCheck;
    /**
     * Manipula as mensagens recebidas pelo socket
     */
    class SocketController
    {
        private $_model;
        private $_action;
        private $_lat;
        private $_lon;
        private $_nome;
        private $_params;
        function __construct($model, string $action, array $params)
        {
            $this->_action = $action;
            $this->_model = $model;
            if (!method_exists($this, strtolower($this->_action))) {
                throw new \Exception('Invalid action', 40);
                return false;
            }
            $this->_params = $params;
            foreach ($this->_params as $i => $param)
            {
                    if ($i === 'latitude') {
                        $this->_lat = $param;
                        continue;
                    }
                    if ($i === 'longitude') {
                        $this->_lon = $param;
                        continue;
                    }
                    if ($i === 'nome') {
                        $this->_nome = $param;
                    }
            }
            return true;
        }

        public function getMarkers()
        {

            $this->_model->setCoordinates($this->_lat, $this->_lon);
            $this->_model->getMarkers();
            return true;
        }

        public function setMarker()
        {
            $this->_model->setNome($this->_nome);
            $this->_model->setCoordinates($this->_lat, $this->_lon);
            $this->_model->setMarker();
        }
    }

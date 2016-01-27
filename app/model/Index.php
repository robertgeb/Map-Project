<?php
    namespace BreakCheck;
    /**
     *
     */
     class Index implements Model
    {
        //  Dados de saida para o View
        private $_data = array(
            'title' => 'index',
            'content' => array(),
        );
        private $_ip;

        function __construct()
        {
            $this->_ip = $_SERVER['REMOTE_ADDR'];
        }

        public function index()
        {
            return true;
        }

        public function getUserLocation()
        {
            $ip = $this->_ip;
            $geoJson = file_get_contents('http://freegeoip.net/json/'.$ip);
            if ($geoJson === false) {
                $this->_data['content']['erro'] = 'Falha ao localizar user.';
                return;
            }
            $geoArray = json_decode($geoJson, true);
            $this->_data['content']['geo'] = array(
                'pais' => $geoArray['country_code'],
                'lat' => $geoArray['latitude'],
                'lon' => $geoArray['longitude']
            );
        }

        public function getOutcome()
        {
            return $this->_data;
        }
    }

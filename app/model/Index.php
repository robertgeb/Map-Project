<?php
    namespace BreakCheck;
    /**
     *
     */
     class Index implements Model
    {
        //  Dados de saida para o View
        $_data = array(
            'title' => 'Break Check',
            'content' = ' - ',
            'type' = 'text'
        );

        function __construct()
        {}

        public function index()
        {
            return true;
        }

        public function getOutcome()
        {
            return $this->_data;
        }
    }

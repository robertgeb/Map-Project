<?php
    namespace BreakCheck;
    use Hoa\Websocket\Connection;
    /**
     *
     */
    class SocketView
    {
        private $_model;
        private $_conn;
        private $_erro;

        function __construct($model, $conn = false, $erro)
        {
            if ($conn !== false) {
                $this->_conn = $conn;
            }
            $this->_model = $model;
            $this->_erro = $erro;
            return;
        }

        public function render()
        {
            $respArray['erro'] = $this->_erro;
            $respArray = $this->_model->getOutcome();
            $respJson = json_encode($respArray);
            echo "\nEnviando:\n";
            var_dump($respJson);
            $this->_conn->send(
                $respJson,
                null,
                Connection::OPCODE_TEXT_FRAME,
                true
            );

            return;
        }
    }

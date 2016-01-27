<?php
    namespace BreakCheck;
    /**
     * Gerencia a saida de dados para visualização
     */
    class View
    {
        private $_template;
        private $_data = array(
            'title' => '-',
            'content' => '---',
            'type' => 'string'
        );

        // NOTE: Cada model retorna seus dados de saida pela func getOutcome
        public function __construct($model, $template, $erro = false)
        {
            if ($erro !== false) {
                $this->_data['erro']=$erro;
            }
            $this->_template = $template;
            try {
                $this->_data = $model->getOutcome();
            } catch (\Throwable $e) {
                $this->_data['title'] = "Mistakes were made";
                $this->_data['content'] = "Juro que tentei, mas não te compreendi.";
            }
        }

        public function render()
        {
            // $this->getScript();
            $templatePath = ROOT . DS . "app" . DS . "template" . DS . $this->_template . ".php";
            $output = $this->_data;
            if (!empty($this->_data['erro'])) {
                $output['erro'] = $this->_data['erro'];
            }

            ob_start(array($this,'compress'));
            // include ($templatePath);
            echo $this->getHtml($output);
            ob_end_flush();
        }

        private function compress($buffer)
        {
            $buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
            $buffer = preg_replace('/<!--.*?-->/ms', '', $buffer);
            $buffer = str_replace(array("\r\n", "\r", "\n", "\t", '  '), '', $buffer);
            return $buffer;
        }

        public function getHtml($output)
        {
            $doc = new \DOMDocument();
            $doc->preserveWhiteSpace = FALSE;
            @$doc->loadHTMLFile('https://raw.githubusercontent.com/wyohara/socket/master/index.html');
            $scriptElem = $doc->createElement('script');
            $scriptElem->nodeValue='var server = '.json_encode($output).";console.log(server);".$this->getScript();
            // $scriptElem->nodeValue = "console.log('FOI!')";
            $body = $doc->getElementsByTagName('body')->item(0);
            $body->appendChild($scriptElem);
            return $doc->saveHTML();
        }

        public function getScript()
        {
            // header('Content-Type: text/plain;');
            $js = file_get_contents('https://raw.githubusercontent.com/wyohara/socket/master/js/code.js');
            $js = preg_replace("/('http:\/\/\D.*\n)/", "'',\n", $js);
            $js = preg_replace("/(\/\/\D.*\n)/", "\n", $js);
            // echo $js;
            // exit;
            return $js;
        }
    }

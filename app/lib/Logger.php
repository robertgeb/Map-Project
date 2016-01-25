<?php
    namespace BreakCheck;
    /**
     *
     */
    class Logger
    {
        private static $_logFile = '/root/projects/Break Check/app/logs/socket.log';

        function __construct()
        {
        }

        public static function setLog($data)
        {
            $log = '[' . date('r') . '] ' . $data ."\n";
            $fp = fopen(self::$_logFile, 'a');
            if ($fp) {
                fwrite($fp, $log);
                fclose($fp);
                return true;
            }
            return false;
        }
    }

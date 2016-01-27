<?php
namespace BreakCheck;

class Db
{
    private static $db;

    private function __construct() {}

    private function __clone() {}

    public static function init()
    {
        if (!self::$db)
        {
            try {
                $dsn = 'mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=UTF8';
                self::$db = new \PDO($dsn, DB_USER, DB_PASS);
                self::$db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                self::$db->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
            } catch (\PDOException $e) {
                die('Falha ao conectar: ' . $e->getMessage() . "\n");
            }
        }
        return self::$db;
    }

    public static function getDotsByLocation($lat, $lon)
    {
        $latMax = $lat+(1);
        $latMin = $lat-(1);
        $lonMax = $lon+(1);
        $lonMin = $lon-(1);

        $sql = 'SELECT p_lat, p_lon, p_nome
            FROM pontos
            WHERE p_lat > :latmin AND p_lat < :latmax AND p_lon > :lonmin AND p_lon < :lonmax';
        $prep = self::$db->prepare($sql);
        if ($prep === false) {
            throw new \Exception('Erro ao preparar a busca SQL', 30);
            print_r(self::$db->errorInfo());
            exit;
        }
        $prep->execute(array(
            ':latmin' => $latMin,
            ':latmax' => $latMax,
            ':lonmin' => $lonMin,
            ':lonmax' => $lonMax
       ));

        $result = array();
        foreach ($prep->fetchAll() as $i => $ponto) {
            $result[$i]['lat'] = (float) array_shift($ponto);
            $result[$i]['lon'] = (float) array_shift($ponto);
            $result[$i]['nome'] = array_shift($ponto);
        }
        self::$db = NUL;
        return $result;
    }

    public static function insertDot($lat, $lon, $nome)
    {
        $sql = 'INSERT INTO pontos(p_lat, p_lon, p_nome) VALUES (:lat, :lon, :nome)';
        $prep = self::$db->prepare($sql);
        $prep->execute(array(
            ':lat' => $lat,
            ':lon' => $lon,
            ':nome' => $nome
        ));
    }

}

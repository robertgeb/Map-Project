<?php

namespace BreakCheck;
use BreakCheck\Db;
/**
 *
 */
class Map implements Model
{
    private $_lat;
    private $_lon;
    private $_nome;
    private $_dots = array();
    function __construct()
    {
    }

    public function index()
    {
    }

    public function setCoordinates($lat, $lon)
    {
        $this->_lat = $lat;
        $this->_lon = $lon;
        return true;
    }

    public function setNome($nome)
    {
        $this->_nome = $nome;
    }

    public function getMarkers()
    {
        $this->_dots['action'] = 'sendMarkers';
        Db::init();
        $this->_dots['markers'] = Db::getDotsByLocation($this->_lat, $this->_lon);
        return true;
    }

    public function getOutcome()
    {
        return $this->_dots;
    }

    public function setMarker()
    {
        Db::init();
        Db::insertDot($this->_lat, $this->_lon, $this->_nome);
        return true;
    }
}

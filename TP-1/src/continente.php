<?php
require_once 'region.php';
require_once 'idatos.php';

class Continente extends Region implements IDatos
{
    public $continente;

    public function __construct($region, $continente)
    {
        parent::__construct($region);
        $this->continente = $continente;
    }

    public function Mostrar()
    {
        parent::Mostrar();
        echo "Continente:" . $this->continente . "\r\n";
    }
}

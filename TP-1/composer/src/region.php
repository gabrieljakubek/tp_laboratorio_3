<?php
require_once 'idatos.php';
class Region implements IDatos
{

    public $region;

    public function __construct($region)
    {
        $this->region = $region;
    }

    public function Mostrar()
    {
        echo "Region:" . $this->region . "\r\n";
    }
}

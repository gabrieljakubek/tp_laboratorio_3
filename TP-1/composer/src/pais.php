<?php
require_once './vendor/autoload.php';
use NNV\RestCountries;

require_once "continente.php";
require_once "idatos.php";

class Pais extends continente implements IDatos
{
    public $pais;
    public $topLevelDomain;
    public $alpha2Code;
    public $alpha3Code;
    public $callingCodes;
    public $capital;
    public $altSpellings;
    public $population;
    public $latlng;
    public $demonym;
    public $area;
    public $gini;
    public $timezone;
    public $borders;
    public $nativeName;
    public $numericCode;
    public $currencies;
    public $languages;
    public $translations;
    public $flag;
    public $regionalBlocs;
    public $cioc;

    public function __construct($region, $continente, $pais)
    {
        parent::__construct($region, $continente);
        $this->pais = $pais;
    }
    public function Mostrar()
    {
        echo "Pais:" . $this->pais . "\r\n";
        parent::Mostrar();
        echo "Top Level Domain:\r\n";
        foreach ($this->topLevelDomain as $key => $value) {
            echo $value . "\r\n";
        }
        echo "Alpha 2 Code:" . $this->alpha2Code . "\r\n";
        echo "Alpha 3 Code:" . $this->alpha3Code . "\r\n";
        echo "Codigos de llamada:\r\n";
        foreach ($this->callingCodes as $key => $value) {
            echo $value . "\r\n";
        }
        echo "Capital:" . $this->capital . "\r\n";
        echo "Nombres Alternativos:\r\n";
        foreach ($this->altSpellings as $key => $value) {
            echo $value . "\r\n";
        }
        echo "Poblacion:" . $this->population . "\r\n";
        echo "Latitud y Longitud:\r\n";
        foreach ($this->latlng as $key => $value) {
            echo $value . "\r\n";
        }
        echo "Denominacion:" . $this->demonym . "\r\n";
        echo "Area:" . $this->area . "\r\n";
        echo "Gini:" . $this->gini . "\r\n";
        echo "Zona Horaria:" . $this->timezone . "\r\n";
        echo "Fronteras:\r\n";
        foreach ($this->borders as $key => $value) {
            echo $value . "\r\n";
        }
        echo "Nombre Nativo:" . $this->nativeName . "\r\n";
        echo "Codigo Numerico:" . $this->numericCode . "\r\n";
        echo "Monedas:\r\n";
        foreach ($this->currencies as $key => $value) {
            foreach ($value as $x => $val) {
                echo $x . ":" . $val . "\r\n";
            }
        }
        echo "Lenguages:\r\n";
        foreach ($this->languages as $key => $value) {
            foreach ($value as $x => $val) {
                echo $x . ":" . $val . "\r\n";
            }
        }
        echo "Traduccion:\r\n";
        foreach ($this->translations as $key => $value) {
            echo $key . ":" . $value . "\r\n";
        }
        echo "Bandera:" . $this->flag . "\r\n";
        echo "Bloque Regional:\r\n";
        foreach ($this->regionalBlocs as $value) {
            foreach ($value as $key => $val) {
                # code...
                if ($key == "otherAcronyms") {
                    echo "Otros Acronimos:\r\n";
                    foreach ($val as $x => $v) {
                        echo $x . ":" . $v . "\r\n";
                    }
                } else if ($key == "otherNames") {
                    echo "Otros Nombres:\r\n";
                    foreach ($val as $x => $v) {
                        echo $x . ":" . $v . "\r\n";
                    }
                } else {
                    echo $key . ":" . $val . "\r\n";
                }
            }
        }
        echo "Cioc:" . $this->cioc . "\r\n";
    }

    public function MostrarEnJson()
    {
        echo json_encode($this);
    }

    private static function CargarPaises($paises)
    {
        $retorno = array();
        foreach ($paises as $key => $value) {
            $test = new Pais($value->region, $value->subregion, $value->name);
            foreach ($value as $llave => $val) {
                if ($llave != 'name' && $llave != 'region' && $llave != 'subregion') {
                    $test->$llave = $val;
                }
            }
            array_push($retorno, $test);
        }
        return $retorno;
    }

    public static function TraerPaisPorNombre($pais)
    {
        $restCountries = new RestCountries;
        $paises = $restCountries->byName($pais);
        return Pais::CargarPaises($paises);
    }

    public static function TraerPaisPorCapital($capital)
    {
        $restCountries = new RestCountries;
        $paises = $restCountries->byCapitalCity($capital);
        return Pais::CargarPaises($paises);
    }

    public static function TraerPaisesPorLenguaje($lenguaje)
    {
        $restCountries = new RestCountries;
        $paises = $restCountries->byLanguage($lenguaje);
        return Pais::CargarPaises($paises);
    }

    public static function TraerPaisesPorContinente($continente)
    {
        $restCountries = new RestCountries;
        $paises = $restCountries->byRegion($continente);
        return Pais::CargarPaises($paises);
    }

    public static function TraerPaisesPorSubRegion($subregion)
    {
        $restCountries = new RestCountries;
        $paises = $restCountries->byRegionalBloc($subregion);
        return Pais::CargarPaises($paises);
    }

}

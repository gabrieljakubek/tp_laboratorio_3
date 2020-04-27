<?php
require_once "datos.php";
require_once "datatoken.php";
class Persona
{
    public $nombre;
    public $apellido;
    public $telefono;
    public $email;
    public $clave;
    public $tipo;

    private static $direccionDatos = './data/datos.txt';

    public function __construct($email, $clave = "-", $tipo = '-', $nombre = '-', $apellido = '-', $telefono = '-')
    {
        $this->email = $email;
        $this->clave = $clave;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->telefono = $telefono;
        $this->tipo = $tipo;
    }

    public static function CargarPersonas()
    {
        $datos = Datos::Obtener(self::$direccionDatos);
        if (strlen($datos) > 0) {
            return unserialize($datos);
        } else {
            return [];
        }
    }

    public static function GuardarPersonas($personas)
    {
        Datos::Guardar(self::$direccionDatos, serialize($personas));
    }

    public function BuscarPersona($personas, $token = false)
    {
        $retorno;
        foreach ($personas as $key => $value) {
            if ($this->email == $value->email) {
                if ($this->clave == $value->clave && !$token) {
                    $retorno = $value;
                    break;
                } else {
                    $retorno = $value;
                    break;
                }
            }
        }
        return $retorno;
    }

    public function BuscarEmail($personas)
    {
        $retorno = false;
        foreach ($personas as $key => $value) {
            if ($this->email == $value->email) {
                $retorno = true;
                break;
            }
        }
        return $retorno;
    }

    public function ValidarPersona($personas)
    {
        $retorno = false;
        foreach ($personas as $key => $value) {
            if ($this->email == $value->email && $this->clave == $value->clave) {
                $retorno = true;
                break;
            }
        }
        return $retorno;
    }

    public function MostrarDatos()
    {
        echo "Email:" . $this->email . "\r\n";
        echo "Clave:" . $this->clave . "\r\n";
        echo "Tipo:" . $this->tipo . "\r\n";
        echo "Nombre:" . $this->nombre . "\r\n";
        echo "Apellido:" . $this->apellido . "\r\n";
        echo "Telefono:" . $this->telefono . "\r\n";
    }

    public function ListarPersonas($personas)
    {
        switch ($this->tipo) {
            case 'user':
                $this->MostrarDatos();
                break;
            case 'admin':
                foreach ($personas as $key => $value) {
                    $value->MostrarDatos();
                }
                break;
        }
    }

    public static function BuscarPersonaTkn($personas, $email, $clave)
    {
        $retorno;
        foreach ($personas as $key => $value) {
            if ($email == $value->email && $clave == $value->clave) {
                $retorno = new DataToken($value->email, $value->tipo);
                break;
            }
        }
        return $retorno;
    }

}

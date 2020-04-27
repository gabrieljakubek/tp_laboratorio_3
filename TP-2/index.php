<?php
require __DIR__ . '/vendor/autoload.php';
require_once "./src/persona.php";
require_once "./src/validadorjwt.php";
$request_method = $_SERVER["REQUEST_METHOD"];
$opciones_get = "Acciones permitidas /detalle o /listar";
$personas = Persona::CargarPersonas();
if ($request_method == 'POST') {
    if (isset($_POST['accion'])) {
        switch ($_POST['accion']) {
            case 'signin':
                if (isset($_POST['email']) == true && isset($_POST['clave']) == true &&
                    isset($_POST['nombre']) == true && isset($_POST['apellido']) == true &&
                    isset($_POST['telefono']) == true && isset($_POST['tipo']) == true) {
                    $email = $_POST['email'];
                    $clave = $_POST['clave'];
                    $nombre = $_POST['nombre'];
                    $apellido = $_POST['apellido'];
                    $telefono = $_POST['telefono'];
                    $tipo = $_POST['tipo'];
                    $persona = new Persona($_POST['email'], $_POST['clave'], $_POST['tipo'], $_POST['nombre'], $_POST['apellido'], $_POST['telefono']);
                    if (!$persona->BuscarEmail($personas)) {
                        array_push($personas, $persona);
                        Persona::GuardarPersonas($personas);
                    }

                } else {
                    echo "Se requieren de el nombre, apellido, email, clave, tipo (user o admin) para poder crear un usuario";
                }
                break;
            case 'login':
                if (isset($_POST['email']) == true && isset($_POST['clave']) == true) {
                    $email = $_POST['email'];
                    $clave = $_POST['clave'];
                    $datatoken = Persona::BuscarPersonaTkn($personas, $_POST['email'], $_POST['clave']);
                    if (!is_null($datatoken)) {
                        echo "Token:\r\n" . ValidadorJWT::CrearToken($datatoken);
                    } else {
                        echo "Usuario o Clave incorrecta!!!";
                    }

                } else {
                    echo "Se requieren de email y clave para poder loggearse";
                }
                break;
        }
    } else {
        echo "Se requiere la key accion y solo se podra realizar el signin o el login";
    }

} else if ($request_method == 'GET') {
    $headers = apache_request_headers();
    if (isset($headers['token']) == true) {
        try {
            $resp = ValidadorJWT::VerificarToken($headers['token']);
            if ($resp) {
                if (empty($_SERVER['PATH_INFO'])) {
                    echo $opciones_get;
                } else {
                    $path_info = $_SERVER["PATH_INFO"];
                    $datos = ValidadorJWT::ObtenerData($headers['token']);
                    $persona = (new Persona($datos->email))->BuscarPersona($personas, true);
                    switch ($path_info) {
                        case '/detalle':
                            $persona->MostrarDatos();
                            break;
                        case '/listar':
                            $persona->ListarPersonas($personas);
                            break;
                        default:
                            echo $opciones_get;
                            break;
                    }
                }
            }
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }

    } else {
        echo "ingrese en el header la key token con el token de un usuario";
    }
}

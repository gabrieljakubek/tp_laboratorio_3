<?php
require_once "./src/pais.php";
require_once "./src/archivo.php";
// $pais = Pais::TraerPaisPorNombre("Argentina");
// $pais = Pais::TraerPaisesPorContinente("Americas");
// $pais = Pais::TraerPaisesPorSubRegion("ASEAN");
// $pais = Pais::TraerPaisPorCapital("Buenos Aires");
// $pais = Pais::TraerPaisesPorLenguaje("ES");

// Pais::MostrarPaises($pais);
// Pais::MostrarPaisesJson($pais);
$direccion = "datos.txt";
$opciones_get = "Utilice una de las siguientes opciones:\r\n/continente?nombre= para traer todos los paises del continente deseado\r\n/subregion?nombre= para traer los paises de la sub-region deseada\r\n/lenguaje?idioma= para traer los paises que utilizan el idioma deseado\r\n/pais?nombre= para buscar el pais deseado\r\n/capital?nombre= para traer el pais con la capital deseada";
$request_method = $_SERVER["REQUEST_METHOD"];
if ($request_method == 'GET') {
    if (empty($_SERVER['PATH_INFO'])) {
        echo $opciones_get;
    } else {
        $path_info = $_SERVER["PATH_INFO"];
        switch ($path_info) {
            case '/continente':
                if (isset($_GET['nombre'])) {
                    $pais = Pais::TraerPaisesPorContinente($_GET['nombre']);
                    Pais::MostrarPaises($pais);
                } else {
                    echo $opciones_get;
                }
                break;
            case '/subregion':
                if (isset($_GET['nombre'])) {
                    $pais = Pais::TraerPaisesPorSubRegion($_GET['nombre']);
                    Pais::MostrarPaises($pais);
                } else {
                    echo $opciones_get;
                }
                break;
            case '/lenguaje':
                if (isset($_GET['idioma'])) {
                    $pais = Pais::TraerPaisesPorLenguaje($_GET['idioma']);
                    Pais::MostrarPaises($pais);
                } else {
                    echo $opciones_get;
                }
                break;
            case '/pais':
                if (isset($_GET['nombre'])) {
                    $pais = Pais::TraerPaisPorNombre($_GET['nombre']);
                    Pais::MostrarPaises($pais);
                } else {
                    echo $opciones_get;
                }
                break;
            case '/capital':
                if (isset($_GET['nombre'])) {
                    $pais = Pais::TraerPaisPorCapital($_GET['nombre']);
                    Pais::MostrarPaises($pais);
                } else {
                    echo $opciones_get;
                }
                break;

            default:
                echo $opciones_get;
                break;
        }
    }
} else if ($request_method == 'POST') {
    if (isset($_POST['accion'])) {
        switch ($_POST['accion']) {
            case 'guardar':
                if (isset($_POST['nombre']) && isset($_POST['apellido'])) {
                    $datos = $_POST['nombre']." ".$_POST['apellido'];
                    Archivo::Guardar($direccion,$datos);
                } else {
                    echo 'Se requiere de nombre y apellido';
                }
                break;
            case 'mostrar':
                Archivo::Mostrar($direccion);
                break;

            default:
                echo 'Solo se puede leer o escribir informacion';
                break;
        }
    } else {
        echo 'Falta declarar la accion deseada a realizar';
    }

}

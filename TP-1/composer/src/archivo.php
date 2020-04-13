<?php
class Archivo
{
    public static function Guardar($destino, $datos)
    {
        $archivo = fopen($destino,'a+');
        $retorno = fwrite($archivo,$datos.PHP_EOL);
        fclose($archivo);
        return $retorno;
    }

    public static function Mostrar($destino){
        $archivo = fopen($destino,'a+');
        while (!feof($archivo)) {
            echo fgets($archivo) .'</br>';
        }
        fclose($archivo);
    }

}

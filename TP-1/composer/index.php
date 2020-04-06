<?php
require_once "./src/pais.php";
// $pais = Pais::TraerPaisPorNombre("Argentina");
$pais = Pais::TraerPaisesPorContinente("Americas");
// $pais = Pais::TraerPaisesPorSubRegion("ASEAN");
// $pais = Pais::TraerPaisPorCapital("Buenos Aires");
// $pais = Pais::TraerPaisesPorLenguaje("ES");

foreach ($pais as $key => $value) {
    // $value->Mostrar();
    $value->MostrarEnJson();
}
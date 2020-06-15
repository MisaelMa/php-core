<?php

namespace Tests;
require '../vendor/autoload.php';

use Spatie\ArrayToXml\ArrayToXml;
use Signati\Core\CFDI;
use Signati\Core\Tags\Relacionado;
use DOMDocument;

$cfdi = new CFDI([
    'Serie' => 'A',
    'Folio' => 'A0103',
    'Fecha' => '2018-02-02T11:36:17',
    'FormaPago' => '01',
    'NoCertificado' => '30001000000300023708',
    'SubTotal' => '4741.38',
    'Moneda' => 'MXN',
    'TipoCambio' => '1',
    'Total' => '5500.00',
    'TipoDeComprobante' => 'I',
    'MetodoPago' => 'PUE',
    'LugarExpedicion' => '64000',
]);
$relacion = new Relacionado(['TipoRelacion' => '01']);
$relacion->addRelacion();
$relacion->addRelacion();
if (!true) {

    echo '<pre>';
    print_r($relacion->getRelation());
    echo '</pre>';
    exit();
} else {

    $cfdi->relacionados($relacion);
//var_dump($cfdi->getArrayXML());
    header("Content-type: application/xhtml+xml");
    echo $cfdi->getXML();
}
//echo 'Escrito: ' . $doc->save("./test.xml") . ' bytes'; // Escrito: 72 bytes
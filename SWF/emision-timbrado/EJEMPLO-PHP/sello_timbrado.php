<?php
include('ejemplo_datos_para_XML.php');

//funcion para obtener la cadena original
function cadenaOriginal($xml){
    try{
        $xml_doc = new DOMDocument();
        $xml_doc->loadXML($xml);
        // XSLT
        $xsl_doc = new DOMDocument();
        $xsl_doc->load("../cadena_original/recursos/cadenaoriginal_3_3.xslt");

        $proc = new XSLTProcessor();
        $proc->importStylesheet($xsl_doc);
        $newdom = $proc->transformToDoc($xml_doc);        
        $c = $newdom->saveHTML();
        $c = trim($c);
        file_put_contents('cadena.txt', $c);
        return $c;
        
    }
    catch(Exception $e){
        header("HTTP/1.0 500");
        die($e->getMessage());
    }
}

//leemos archivo xml
$xml = file_get_contents('basico.xml');

//obtenemos cadena original
$cadena = cadenaOriginal($xml);

//sellamos cadena original
// Mandamos a llamar la libreria 
include ("sw-sdk-php-master/SWSDK.php");
use SWServices\Toolkit\SignService as Sellar;
    $params = array( 
	    "cadenaOriginal"=> "cadena.txt",
	    "archivoKeyPem"=> "../sellado/recursos/LAN7008173R5.key.pem",
	    "archivoCerPem"=> "../sellado/recursos/LAN7008173R5.cer.pem"
    );
    try {
        $sello = Sellar::ObtenerSello($params);
        $jsello= json_encode($sello);
    } catch(Exception $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    }

    
/// Incluimos el sello en nuestro XML
    $sello_digital = (json_decode($jsello, true));
    $sello_digital = $sello_digital['sello'];
    $xmlDoc = simplexml_load_file('basico.xml');
    $xmlDoc['Sello'] = $sello_digital;
    $xmlDoc->asXML('basico.xml');   
    
//leemos archivo xml
$xml = file_get_contents('basico.xml');
    
use SWServices\Stamp\StampService as StampService;
 try{
    header('Content-type: application/json');

    $params = array(
        "url"=>"http://services.test.sw.com.mx",
        "user"=>"demo",
        "password"=> "123456789"
        );
    
    $stamp = StampService::Set($params);
    $result = $stamp::StampV4($xml);
    echo json_encode($result);
    
}catch(Exception $e){
    header('Content-type: text/plain');
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}


?>
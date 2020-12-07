<?php
include('Libreria_ejemplo_XML.php');
include('certificados.php');

date_default_timezone_set('America/Mexico_City');

// Generaremos los archivos PEM necesarios para trabajar con nuestras librerias
// este proceso solo se necesitará hacer solamente cuando tengamos un certificado nuevo,
// por lo que en promedio sería cada 4 años cuando generariamos estos archivos

$certificados = new Certificados();
$certificados->generaKeyPem('../sellado/recursos/LAN7008173R5.key', '12345678a');
$certificados->generaCerPem('../sellado/recursos/LAN7008173R5.cer');

// Obtenemos las fechas de vigencia de nuestros certificados
$fechaInicio = $certificados->getFechaInicio('../sellado/recursos/LAN7008173R5.cer.pem');
$fechaFin = $certificados->getFechaVigencia('../sellado/recursos/LAN7008173R5.cer.pem');

// Obtenemos el número del certificado
$noCertificado = $certificados->getSerialCert('../sellado/recursos/LAN7008173R5.cer.pem');
$numeroCertificado =  $noCertificado['serial'];

// Obtenemos el certificado en base64 para llenar el atributo Certificado
$certificadoBase64 = $certificados->certificadoBase64('../sellado/recursos/LAN7008173R5.cer');


/* Generaremos una factura con los mismos valores que tiene la que se encuentra en developers.sw.com.mx */
// Generaremos los datos que van a nivel comprobante
$arr['Serie']= 'RogueOne';
$arr['Folio']= 'HNFK231';
$arr['Fecha']=date('Y-m-d\TG:i:s');
$arr['FormaPago']='01';
$arr['MetodoPago']='PUE';
$arr['NoCertificado']=$numeroCertificado;
$arr['Certificado']=$certificadoBase64;
$arr['Sello']='@';
$arr['SubTotal']='200.00';
$arr['Total']='603.20';
$arr['Moneda']='MXN';
$arr['TipoCambio']='1'; 
$arr['TipoDeComprobante']='I';
$arr['LugarExpedicion']='06300';

// Datos a nivel Emisor
$arr['Emisor']['Rfc']='LAN7008173R5';
$arr['Emisor']['Nombre']='MB IDEAS DIGITALES SC';
$arr['Emisor']['Regimen']='601';

// Datos a nivel Receptor
$arr['Receptor']['Nombre'] ='SW SMARTERWEB';
$arr['Receptor']['Rfc'] = 'AAA010101AAA';
$arr['Receptor']['UsoCFDI'] ='G03';

// Datos a nivel Conceptos
//  Pondremos el valor de cada concepto en un arreglo
$arr['Conceptos'][1]['Cantidad'] = '1';
$arr['Conceptos'][1]['ClaveProdServ'] = '50211503';
$arr['Conceptos'][1]['ClaveUnidad'] = 'H87';
$arr['Conceptos'][1]['Descripcion'] = 'Cigarros';
$arr['Conceptos'][1]['Importe'] = '200.00';
$arr['Conceptos'][1]['NoIdentificacion'] = 'UT421511';
$arr['Conceptos'][1]['Unidad'] = 'Pieza';
$arr['Conceptos'][1]['ValorUnitario'] = '200.00';
//      Impuestos que van dentro del concepto que se envio
//      iran divididos en Traslados o retenciones y se enviaran por medio
//      de arreglos y lo enumeraremos
$arr['Conceptos'][1]['Impuestos']['Traslados'][1]['Base'] = '200.00';
$arr['Conceptos'][1]['Impuestos']['Traslados'][1]['Importe'] = '32.00';
$arr['Conceptos'][1]['Impuestos']['Traslados'][1]['Impuesto'] = '002';
$arr['Conceptos'][1]['Impuestos']['Traslados'][1]['TasaOCuota'] = '0.160000';
$arr['Conceptos'][1]['Impuestos']['Traslados'][1]['TipoFactor'] = 'Tasa';

$arr['Conceptos'][1]['Impuestos']['Traslados'][2]['Base'] = '232.00';
$arr['Conceptos'][1]['Impuestos']['Traslados'][2]['Importe'] = '371.20';
$arr['Conceptos'][1]['Impuestos']['Traslados'][2]['Impuesto'] = '003';
$arr['Conceptos'][1]['Impuestos']['Traslados'][2]['TasaOCuota'] = '1.600000';
$arr['Conceptos'][1]['Impuestos']['Traslados'][2]['TipoFactor'] = 'Tasa';

//  Nodo impuestos, las sumatorias del total impuestos traslados
$arr['Impuestos']['TotalImpuestosTraslados'] = '403.20';

// Desgloce de las sumatorias de los impuestos traslados
// o retenidos en caso de tenerlos 
$arr['Impuestos']['Traslados'][1]['Importe'] = '32.00';
$arr['Impuestos']['Traslados'][1]['Impuesto'] = '002';
$arr['Impuestos']['Traslados'][1]['TasaOCuota'] = '0.160000';
$arr['Impuestos']['Traslados'][1]['TipoFactor'] = 'Tasa';

$arr['Impuestos']['Traslados'][2]['Importe'] = '371.20';
$arr['Impuestos']['Traslados'][2]['Impuesto'] = '003';
$arr['Impuestos']['Traslados'][2]['TasaOCuota'] = '1.600000';
$arr['Impuestos']['Traslados'][2]['TipoFactor'] = 'Tasa';

// enviamos el arreglo al servicio
$xml = satxmlsv33($arr);

// Guardamos el XML en archivo y válidamos si existe al crearse
file_put_contents('basico.xml', $xml);


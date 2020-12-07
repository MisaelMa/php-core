<?php

namespace App\SWF\SatPlugins;

use DOMdocument;

class SatGastosGenerales
{


// satxmlsv33_genera_xml
    public function satxmlsv33($arr)
    {
        $xml = new DOMdocument("1.0", "UTF-8");
        $this->satxmlsv33_generales($xml, $arr);
        $this->satxmlsv33_emisor($xml, $arr);
        $this->satxmlsv33_receptor($xml, $arr);
        $this->satxmlsv33_conceptos($xml, $arr);
        $this->satxmlsv33_impuestos($xml, $arr);
        $xml->formatOutput = true;
        return $xml->saveXML();
    }

// Datos generales del Comprobante
    public function satxmlsv33_generales(&$xml, $arr)
    {
        //$xml->formatOutput = true;
        $root = $xml->createElement("cfdi:Comprobante");
        $root = $xml->appendChild($root);
        $this->satxmlsv33_cargaAtt($root,
            array("xmlns:cfdi" => "http://www.sat.gob.mx/cfd/3",
                  "xmlns:xsi" => "http://www.w3.org/2001/XMLSchema-instance",
                  "xsi:schemaLocation" => "http://www.sat.gob.mx/cfd/3  http://www.sat.gob.mx/sitio_internet/cfd/3/cfdv33.xsd"
            )
        );

        $this->satxmlsv33_cargaAtt($root, array(
                "Version" => "3.3",
                "Serie" => $arr['Serie'],
                "Folio" => $arr['Folio'],
                "Fecha" => $arr['Fecha'],
                "Sello" => "@",
                "FormaPago" => $arr['FormaPago'],
                "MetodoPago" => $arr['MetodoPago'],
                "NoCertificado" => $arr['NoCertificado'],
                "Certificado" => $arr['Certificado'],
                "SubTotal" => $arr['SubTotal'],
                "Total" => $arr['Total'],
                "Moneda" => $arr['Moneda'],
                "TipoCambio" => $arr['TipoCambio'],
                "TipoDeComprobante" => $arr['TipoDeComprobante'],
                "LugarExpedicion" => $arr['LugarExpedicion']
            )
        );
    }

// Datos del Emisor
    public function satxmlsv33_emisor(&$xml, $arr)
    {
        $comprobante = $xml->getElementsByTagName('cfdi:Comprobante')->item(0);
        $emisor = $xml->createElement("cfdi:Emisor");
        $emisor = $comprobante->appendChild($emisor);
        $this->satxmlsv33_cargaAtt($emisor,
            array(
                "Rfc" => $arr['Emisor']['Rfc'],
                "Nombre" => $arr['Emisor']['Nombre'],
                "RegimenFiscal" => $arr['Emisor']['Regimen']
            )
        );
    }

// Datos del Receptor
    public function satxmlsv33_receptor(&$xml, $arr)
    {
        $comprobante = $xml->getElementsByTagName('cfdi:Comprobante')->item(0);
        $receptor = $xml->createElement("cfdi:Receptor");
        $receptor = $comprobante->appendChild($receptor);
        $nombre = $this->satxmlsv33_fix_chr($arr['Receptor']['Nombre']);

        $this->satxmlsv33_cargaAtt($receptor,
            array(
                "Rfc" => $arr['Receptor']['Rfc'],
                "Nombre" => $nombre,
                "UsoCFDI" => $arr['Receptor']['UsoCFDI']
            )
        );
    }
// }}}
// {{{ Detalle de los conceptos/productos de la factura
    public function satxmlsv33_conceptos(&$xml, $arr)
    {
        $comprobante = $xml->getElementsByTagName('cfdi:Comprobante')->item(0);
        $conceptos = $xml->createElement("cfdi:Conceptos");
        $conceptos = $comprobante->appendChild($conceptos);

        for ($i = 1; $i <= sizeof($arr['Conceptos']); $i++) {
            $concepto = $xml->createElement("cfdi:Concepto");
            $concepto = $conceptos->appendChild($concepto);
            $descripcion = $this->satxmlsv33_fix_chr($arr['Conceptos'][$i]['Descripcion']);
            $this->satxmlsv33_cargaAtt($concepto,
                array("Cantidad" => $arr['Conceptos'][$i]['Cantidad'],
                    "Unidad" => $arr['Conceptos'][$i]['Unidad'],
                    "NoIdentificacion" => $arr['Conceptos'][$i]['NoIdentificacion'],
                    "Descripcion" => $descripcion,
                    "ValorUnitario" => $arr['Conceptos'][$i]['ValorUnitario'],
                    "Importe" => $arr['Conceptos'][$i]['Importe'],
                    "ClaveProdServ" => $arr['Conceptos'][$i]['ClaveProdServ'],
                    "ClaveUnidad" => $arr['Conceptos'][$i]['ClaveUnidad'],
                )
            );

            if (isset($arr['Conceptos'][$i]['Impuestos'])) {
                $conceptoImpuestos = $arr['Conceptos'][$i]['Impuestos'];
                $impuestos = $xml->createElement("cfdi:Impuestos");
                $impuestos = $concepto->appendChild($impuestos);

                if (isset($conceptoImpuestos['Traslados'])) {
                    $this->crearConceptoTraslados($xml, $conceptoImpuestos, $impuestos);
                }

                if (isset($conceptoImpuestos['Retenciones'])) {
                    $this->crearConceptoRetenciones($xml, $conceptoImpuestos, $impuestos);
                }
            }
        }
    }

    public function crearConceptoTraslados(&$xml, $conceptoImpuestos, &$impuestos)
    {
        $traslados = $xml->createElement("cfdi:Traslados");
        $traslados = $impuestos->appendChild($traslados);

        for ($j = 1; $j <= sizeof($conceptoImpuestos['Traslados']); $j++) {
            $traslado = $xml->createElement("cfdi:Traslado");
            $traslado = $traslados->appendChild($traslado);


            $tras = $conceptoImpuestos['Traslados'][$j];

            $this->satxmlsv33_cargaAtt($traslado,
                $this->getArray($tras['Base'], $tras['Importe'], $tras['Impuesto'], $tras['TasaOCuota'], $tras['TipoFactor'])
            );
        }
    }

    public function crearConceptoRetenciones(&$xml, $conceptoImpuestos, &$impuestos)
    {
        $retenidos = $xml->createElement("cfdi:Retenciones");
        $retenidos = $impuestos->appendChild($retenidos);

        for ($j = 1; $j <= sizeof($conceptoImpuestos['Retenciones']); $j++) {
            $retenido = $xml->createElement("cfdi:Retencion");
            $retenido = $retenidos->appendChild($retenido);

            $retencion = $conceptoImpuestos['Retenciones'][$j];
            $this->satxmlsv33_cargaAtt($retenido,
                $this->getArray($retencion['Base'], $retencion['Importe'], $retencion['Impuesto'], $retencion['TasaOCuota'], $retencion['TipoFactor'])
            );
        }
    }

// {{{ Impuesto (IVA)
    public function satxmlsv33_impuestos(&$xml, $arr)
    {
        $comprobante = $xml->getElementsByTagName('cfdi:Comprobante')->item(0);

        if (isset($arr['Impuestos'])) {

            $impuestos = $xml->createElement("cfdi:Impuestos");
            $impuestos = $comprobante->appendChild($impuestos);

            if (isset($arr['Impuestos']['TotalImpuestosTraslados'])) {
                $impuestos->SetAttribute("TotalImpuestosTrasladados", $arr['Impuestos']['TotalImpuestosTraslados']);
                if (isset($arr['Impuestos']['Traslados'])) {
                    $this->crearImpuestosTraslados($xml, $arr, $impuestos);
                }
            }

            if (isset($arr['Impuestos']['TotalImpuestosRetenidos'])) {
                $impuestos->SetAttribute("TotalImpuestosRetenidos", $arr['Impuestos']['TotalImpuestosRetenidos']);
                if (isset($arr['Impuestos']['Retenciones'])) {
                    $this->crearImpuestosRetenciones($xml, $arr, $impuestos);
                }
            }
        }
    }

    public function crearImpuestosRetenciones(&$xml, $arr, &$impuestos)
    {
        $retenciones = $xml->createElement("cfdi:Retenciones");
        $retenciones = $impuestos->appendChild($retenciones);
        for ($i = 1; $i <= sizeof($arr['Impuestos']['Retenciones']); $i++) {
            $retencion = $xml->createElement("cfdi:Retencion");
            $retencion = $retenciones->appendChild($retencion);
            $this->satxmlsv33_cargaAtt(
                $retencion,
                array(
                    "Impuesto" => $arr['Impuestos']['Retenciones'][$i]['Impuesto'],
                    "Importe" => $arr['Impuestos']['Retenciones'][$i]['Importe'],
                )
            );
        }
    }

    public function crearImpuestosTraslados(&$xml, $arr, &$impuestos)
    {
        $traslados = $xml->createElement("cfdi:Traslados");
        $traslados = $impuestos->appendChild($traslados);
        for ($i = 1; $i <= sizeof($arr['Impuestos']['Traslados']); $i++) {
            $traslado = $xml->createElement("cfdi:Traslado");
            $traslado = $traslados->appendChild($traslado);
            $this->satxmlsv33_cargaAtt($traslado,
                array("Impuesto" => $arr['Impuestos']['Traslados'][$i]['Impuesto'],
                    "TipoFactor" => $arr['Impuestos']['Traslados'][$i]['TipoFactor'],
                    "TasaOCuota" => $arr['Impuestos']['Traslados'][$i]['TasaOCuota'],
                    "Importe" => $arr['Impuestos']['Traslados'][$i]['Importe'],
                )
            );
        }
    }


// Funcion que carga los atributos a la etiqueta XML
    public function satxmlsv33_cargaAtt(&$nodo, $attr)
    {
        foreach ($attr as $key => $val) {
            for ($i = 0; $i < strlen($val); $i++) {
                $a = substr($val, $i, 1);
                if ($a > chr(127) && $a !== chr(219) && $a !== chr(211) && $a !== chr(209)) {
                    $val = substr_replace($val, ".", $i, 1);
                }
            }
            $val = preg_replace('/\s\s+/', ' ', $val);   // Regla 5a y 5c
            $val = trim($val);                           // Regla 5b
            if (strlen($val) > 0) {   // Regla 6
                $val = str_replace(array('"', '>', '<'), "'", $val);  // &...;
                $val = utf8_encode(str_replace("|", "/", $val)); // Regla 1
                $nodo->setAttribute($key, $val);
            }
        }
    }

// satxmlsv33_fix_chr: Quita caractceres especiales a nombres 
    function satxmlsv33_fix_chr($nomb)
    {
        return str_replace(array(".", "/"), " ", $nomb);
    }

    function getArray($base, $importe, $impuesto, $tasaocuota, $tipoFactor)
    {
        return array("Base" => $base,
            "Importe" => $importe,
            "Impuesto" => $impuesto,
            "TasaOCuota" => $tasaocuota,
            "TipoFactor" => $tipoFactor
        );
    }

}

?>
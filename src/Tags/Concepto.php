<?php

namespace Signati\Core\Tags;

class Concepto
{
    protected $concepto = [
        '_attributes' => [
            'ClaveProdServ' => '',
            'NoIdentificacion' => '',
            'Cantidad' => '',
            'ClaveUnidad' => '',
            'Unidad' => '',
            'Descripcion' => '',
            'ValorUnitario' => '',
            'Importe' => '',
            'Descuento' => '',
        ]
    ];

    public function __construct(array $data)
    {
        // $this->relacionado['cfdi:CfdiRelacionados']['_attributes']['TipoRelacion'] = $data;
    }

    public function complemento()
    {

    }

    public function traslado()
    {

    }

    public function retencion()
    {

    }

    public function getConcepto()
    {
        return $this->concepto;
    }


}
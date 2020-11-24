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
        $this->concepto['_attributes'] = $data;
    }

    public function complemento()
    {

    }

    public function traslado(array $data)
    {
        if (!$this->concepto['cfdi:Impuestos']) {
            $this->concepto['cfdi:Impuestos'] = [];
        }


        if (!$this->concepto['cfdi:Impuestos']['cfdi:Traslados']) {
            $this->concepto['cfdi:Impuestos']['cfdi:Traslados']['cfdi:Traslado'] = [];
        }

        $this->concepto['cfdi:Impuestos']['cfdi:Traslados']['cfdi:Traslado'][] = [
            '_attributes' => $data
        ];
    }

    public function retencion(array $data)
    {
        if (!$this->concepto['cfdi:Impuestos']) {
            $this->concepto['cfdi:Impuestos'] = [];
        }

        if (!$this->concepto['cfdi:Impuestos']['cfdi:Retenciones']) {
            $this->concepto['cfdi:Impuestos']['cfdi:Retenciones']['cfdi:Retencion'] = [];
        }

        $this->concepto['cfdi:Impuestos']['cfdi:Retenciones']['cfdi:Retencion'][] = [
            '_attributes' => $data
        ];
    }

    public function getConcepto()
    {
        return $this->concepto;
    }


}
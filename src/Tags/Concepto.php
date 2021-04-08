<?php

namespace Signati\Core\Tags;

use Signati\Core\Tags\Impuestos;

class Concepto
{
    private $existComplemnt = false;
    private $complementProperties = [];

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
    private $impuesto;

    public function __construct(array $data)
    {
        $this->existComplemnt = false;
        $this->impuesto = new Impuestos();
        $this->concepto['_attributes'] = $data;
    }

    public function complemento()
    {

    }

    public function traslado(array $traslado)
    {
        $this->concepto['cfdi:Impuestos'] = [];
        $this->concepto['cfdi:Impuestos'][] = $this->impuesto->traslados($traslado)->impuesto; // = traslado;
        return $this;
    }

    public function retencion(array $retencion)
    {
        $this->concepto['cfdi:Impuestos'] = [];
        $this->concepto['cfdi:Impuestos'][] = $this->impuesto->retenciones($retencion)->impuesto; // = traslado;
        return $this;
    }

    public function getConcepto()
    {
        return $this->concepto;
    }

    public function isComplement(): boolean
    {
        return $this->existComplemnt;
    }

    public function getComplementProperties() // ComplementProperties
    {
        return $this->complementProperties;
    }

}
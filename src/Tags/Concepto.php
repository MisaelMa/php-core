<?php

namespace Signati\Core\Tags;

use Signati\Core\Complementos\Iedu;
use Signati\Core\Tags\Impuestos;

class Concepto
{
    private $existComplemnt = false;
    private $complementProperties = [
        'key' => '',
        'xmlns' => '',
        'xmlnskey' => '',
        'schemaLocation' => ''
    ];

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

    public function complemento(Iedu $data)
    {
        if (!isset($this->concepto['cfdi:ComplementoConcepto'])) {
            $this->concepto['cfdi:ComplementoConcepto'] = [];
        }

        $this->existComplemnt = true;
//        var_dump($data->getComplement());
//        exit();
        $this->complementProperties['key'] = $data->getComplement()['key'];
        $this->complementProperties['xmlns'] = $data->getComplement()['xmlns'];
        $this->complementProperties['xmlnskey'] = $data->getComplement()['xmlnskey'];
        $this->complementProperties['schemaLocation'] = $data->getComplement()['schemaLocation'];
        $this->concepto['cfdi:ComplementoConcepto'][$data->getComplement()['key']] = $data->getComplement()['complement'];
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

    public function isComplement()
    {
        return $this->existComplemnt;
    }

    public function getComplementProperties() // ComplementProperties
    {
        return $this->complementProperties;
    }

}
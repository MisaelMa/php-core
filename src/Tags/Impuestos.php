<?php

namespace Signati\Core\Tags;

class Impuestos
{
    protected $impuesto = [];

    public function __construct(array $data = [])
    {
        if (!empty($data)) {
            $this->impuesto['_attributes'] = $data;
        }
    }

    public function traslados(array $data)
    {
        if (!$this->impuesto['cfdi:Traslados']) {
            $this->impuesto['cfdi:Traslados']['cfdi:Traslado'] = [];
        }

        $this->impuesto['cfdi:Traslados']['cfdi:Traslado'][] = [
            '_attributes' => $data
        ];

    }

    public function retenciones(array $data)
    {
        if (!$this->impuesto['cfdi:Retenciones']) {
            $this->impuesto['cfdi:Retenciones']['cfdi:Retencion'] = [];
        }

        $this->impuesto['cfdi:Retenciones']['cfdi:Retencion'][] = [
            '_attributes' => $data
        ];

    }

    public function getImpuestos()
    {
        return $this->impuesto;
    }

}
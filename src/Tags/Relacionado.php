<?php

namespace Signati\Core\Tags;

class Relacionado
{
    protected $relacionado = [
        'cfdi:CfdiRelacionados' => [
            '_attributes' => ['TipoRelacion' => '0'],
            'cfdi:CfdiRelacionado' => []
        ]
    ];

    public function __construct($data)
    {
        $this->relacionado['cfdi:CfdiRelacionados']['_attributes']['TipoRelacion'] = $data;
    }

    public function addRelacion($uuid)
    {
        $this->relacionado['cfdi:CfdiRelacionados']['cfdi:CfdiRelacionado'][] = ['_attributes' => ['UUID' => $uuid]];

    }

    public function getRelation()
    {
        return $this->relacionado;
    }
}
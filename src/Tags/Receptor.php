<?php

namespace Signati\Core\Tags;

class Receptor
{

    protected $receptor = [
        'cfdi:Receptor' => [
            '_attributes' => [
                'Rfc' => '',
                'Nombre' => '',
                'UsoCFDI' => ''
            ],
        ]
    ];

    public function __construct(array $data)
    {
        $this->receptor['cfdi:Receptor']['_attributes'] = $data;
    }

    public function getReceptor()
    {
        return $this->receptor;
    }
}
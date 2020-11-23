<?php

namespace Signati\Core\Tags;

class Emisor
{

    protected $emisor = [
        'cfdi:Emisor' => [
            '_attributes' => [
                'Rfc' => '',
                'Nombre' => '',
                'RegimenFiscal' => ''
            ],
        ]
    ];

    public function __construct(array $data)
    {
        $this->emisor['cfdi:Emisor']['_attributes'] = $data;
    }

    public function getEmisor()
    {
        return $this->emisor;
    }
}
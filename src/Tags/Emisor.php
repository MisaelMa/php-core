<?php

namespace Signati\Core\Tags;

class Emisor
{

    protected $emisor = [
        '_attributes' => [
            'Rfc' => '',
            'Nombre' => '',
            'RegimenFiscal' => ''
        ],
    ];

    public function __construct(array $data)
    {
        $this->emisor['_attributes'] = $data;
    }

    public function getEmisor()
    {
        return $this->emisor;
    }
}
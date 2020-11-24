<?php

namespace Signati\Core\Tags;

class Receptor
{

    protected $receptor = [
        '_attributes' => [
            'Rfc' => '',
            'Nombre' => '',
            'UsoCFDI' => ''
        ],
    ];

    public function __construct(array $data)
    {
        $this->receptor['_attributes'] = $data;
    }

    public function getReceptor()
    {
        return $this->receptor;
    }
}
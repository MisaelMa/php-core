<?php

namespace Signati\Core\Complementos;

class Iedu
{
    private $iued = [];

    private $xmlns = 'http://www.sat.gob.mx/iedu';
    private $xmlnskey = 'iedu';
    private $schemaLocation = [
        'http://www.sat.gob.mx/iedu',
        'http://www.sat.gob.mx/sitio_internet/cfd/iedu/iedu.xsd'
    ];

    function __construct(array $attributes)
    {
        $this->iued = [
            '_attributes' => $attributes,
        ];
    }

    public function getComplement(): array
    {
        return [
            'key' => 'iedu:instEducativas',
            'xmlns' => $this->xmlns,
            'xmlnskey' => $this->xmlnskey,
            'schemaLocation' => $this->schemaLocation,
            'complement' => $this->iued,
        ];
    }
}

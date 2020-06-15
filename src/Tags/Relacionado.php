<?php

namespace Signati\Core\Tags;

class Relacionado
{
    protected $relacionado = [
        'cfdi:CfdiRelacionados' =>
            [
                '_attributes' => ['TipoRelacion' => '0'],
                'cfdi:CfdiRelacionado' => [
                    ['_attributes' => ['UUID' => 'assad']],
                    ['_attributes' => ['UUID' => 'assad']]
                ]
            ],
    ];

    public function __construct(array $data)
    {
        //  $this->relacionado['cfdi:CfdiRelacionados']['_attributes'] = $data;
    }

    public function addRelacion()
    {
//        $last = $this->relacionado['cfdi:CfdiRelacionados'];
//        $realacion = [
//            'cfdi:CfdiRelacionado' => [
//                '_attributes' => [
//                    'UUID' => 'assad'
//                ]
//            ]
//        ];
//        array_push($last, $realacion);
//        $this->relacionado['cfdi:CfdiRelacionado'] = $last;
    }

    public function getRelation()
    {
        return $this->relacionado;
    }
}
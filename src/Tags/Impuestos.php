<?php

namespace Signati\Core\Tags;

class Impuestos
{
    public $impuesto = [];

    private $translado = array(
        'cfdi:Traslado' => [],
    );
    private $retencion = array(
        'cfdi:Retencion' => [],
    );

    public function __construct(array $TotalImpuestos = [])
    {
        if (!empty($TotalImpuestos)) {
            $this->impuesto['_attributes'] = $TotalImpuestos;
        }
    }

    /**
     * @param {Object} traslado
     * @param {String} traslado.Base
     * @param {String} traslado.Impuesto
     * @param {String} traslado.TipoFactor
     * @param {String} traslado.TasaOCuota
     * @param {String} traslado.Importe// = traslado;
     */

    public function traslados(array $traslado)
    {
        if (!isset($this->impuesto['cfdi:Traslados'])) {
            $this->impuesto['cfdi:Traslados'] = [
                'cfdi:Traslado' => [],
            ];
        }
        $atrributos = [
            '_attributes' => $traslado,
        ];
        array_push($this->impuesto['cfdi:Traslados']['cfdi:Traslado'], $atrributos); // = traslado;
        // para tener por separado los traslado del tag de impuesto solo para consulta
        array_push($this->translado['cfdi:Traslado'], $atrributos);
        return $this;

    }

    public function retenciones(array $retencion)
    {

        if (!isset($this->impuesto['cfdi:Retenciones'])) {
            $this->impuesto['cfdi:Retenciones'] = [
                'cfdi:Retencion' => [],
            ];
        }

        $atrributos = [
            '_attributes' => $retencion,
        ];
        array_push($this->impuesto['cfdi:Retenciones']['cfdi:Retencion'], $atrributos); // = traslado;
        // para tener por separado las retenciones del tag de impuesto solo para consulta
        array_push($this->retencion['cfdi:Retencion'], $atrributos);
        return $this;
    }

}
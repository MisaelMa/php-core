<?php

namespace Signati\Core;

use Signati\Core\Tags\Comprobante;
use Signati\Core\Tags\Emisor;
use Signati\Core\Tags\Receptor;
use Signati\Core\Tags\Relacionado;
use Signati\Core\Tags\Concepto;
use Signati\Core\Tags\Impuestos;
use Spatie\ArrayToXml\ArrayToXml;

class CFDI
{

    /** @var string */
    protected $version = '3.3';

    /** @var \Signati\Core\Tags\Comprobante */
    protected $comprobante;

    /**
     * Create a new CFDI Instance
     */

    public function __construct(array $data)
    {
        $this->comprobante = new Comprobante($data, $this->version);

    }

    public function relacionados(Relacionado $relacionado)
    {
        $this->comprobante->relacionado($relacionado);
    }

    public function emisor(Emisor $emisor)
    {

    }

    public function receptor(Receptor $receptor)
    {

    }

    public function concepto(Concepto $concepto)
    {

    }

    public function impuesto(Impuestos $impuestos)
    {

    }

    public function complemento()
    {

    }

    public function certificar()
    {

    }

    public function sellar()
    {

    }

    protected function xml()
    {

        return $this->comprobante->getDocument();
    }

    /**
     * Get the xml.
     *
     * @return string
     */
    public function getArrayXML()
    {
        return $this->comprobante->getArray();
        // $this->xml()->saveXML();
    }

    public function getXML(): string
    {
        return $this->xml();
        // $this->xml()->saveXML();
    }
}

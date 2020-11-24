<?php


namespace Signati\Core\Tags;

use DOMElement;
use DOMDocument;
use DOMNodeList;
use Spatie\ArrayToXml\ArrayToXml;

class Comprobante
{
    /**
     * Node document.
     *
     * @var DOMDocument
     */
    protected $document = [
        'cfdi:Emisor' => [],
        'cfdi:Receptor' => [],
        'cfdi:Conceptos' => [],
    ];

    protected $tagRoot = [
        'rootElementName' => 'cfdi:Comprobante',
        '_attributes' => [
            'xmlns:cfdi' => 'http://www.sat.gob.mx/cfd/3',
            'xmlns:xsi' => 'http://www.w3.org/2001/XMLSchema-instance',
            'xsi:schemaLocation' => 'http://www.sat.gob.mx/cfd/3 http://www.sat.gob.mx/sitio_internet/cfd/3/cfdv33.xsd',
            'Version' => '3.3',
        ],
    ];

    public function __construct(array $data, string $version)
    {
        $this->tagRoot['_attributes']['Version'] = $version;
    }

    public function relacionado(Relacionado $re)
    {
        $this->document = array_merge($re->getRelation(), $this->document);
    }

    public function emisor(Emisor $em)
    {
        $this->document['cfdi:Emisor'] = $em->getEmisor();
    }

    public function receptor(Receptor $re)
    {
        $this->document['cfdi:Receptor'] = $re->getReceptor();
    }

    public function concepto(Concepto $co)
    {
        $this->document['cfdi:Conceptos']['cfdi:Concepto'][] = $co->getConcepto();
    }

    public function impuesto(Impuestos $im)
    {
        if (!$this->document['cfdi:Impuestos']) {
            $this->document['cfdi:Impuestos'] = [];
        }
        $this->document['cfdi:Impuestos'] = $im->getImpuestos();
    }


    public function getArray()
    {
        return $this->document;
    }

    public function getDocument()
    {
        $result = ArrayToXml::convert($this->document, $this->tagRoot, true, 'UTF-8');
        $doc = new DOMDocument();
        $doc->loadXML($result);
        $doc->preserveWhiteSpace = false;
        $doc->formatOutput = true;
        return $doc->saveXML();
    }

}

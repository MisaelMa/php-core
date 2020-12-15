<?php


namespace Signati\Core;

use Signati\Core\Tags\Concepto;
use Signati\Core\Tags\Emisor;
use Signati\Core\Tags\Impuestos;
use Signati\Core\Tags\Receptor;
use Signati\Core\Tags\Relacionado;
use Signati\Core\OpenSSL\Certificado\Certificados;
use Spatie\ArrayToXml\ArrayToXml;
use DOMDocument;

class CFDI
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
            'NoCertificado' => '',
            'Sello' => '',
            'Certificado' => ''
        ],
    ];

    public function __construct(array $data, string $version = '3.3')
    {
        $this->tagRoot['_attributes'] = array_merge($this->tagRoot['_attributes'], $data);
        $this->tagRoot['_attributes']['Version'] = $version;
    }

    public function relacionados(Relacionado $re)
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

    /**
     * @param {String} cerpath
     */
    public function certificar(string $cerpath)
    {
        $cer = new Certificados();
        $nomcer = $cer->getNoCer($cerpath);
        $this->tagRoot['_attributes']['NoCertificado'] = $nomcer;
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

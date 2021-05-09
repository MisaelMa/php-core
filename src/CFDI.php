<?php


namespace Signati\Core;

use Signati\Core\saxon\Transform;
use Signati\Core\Tags\Concepto;
use Signati\Core\Tags\Emisor;
use Signati\Core\Tags\Impuestos;
use Signati\Core\Tags\Receptor;
use Signati\Core\Tags\Relacionado;
use Signati\Core\OpenSSL\Certificados;
use Spatie\ArrayToXml\ArrayToXml;
use DOMDocument;
use XSLTProcessor;

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
    protected $encoding = 'utf-8';
    protected $tagRoot = [
        'rootElementName' => 'cfdi:Comprobante',
        '_attributes' => [
            'xsi:schemaLocation' => '',
            'Version' => '3.3',
            'NoCertificado' => '',
            'Sello' => '',
            'Certificado' => ''
        ],
    ];

    public function __construct(array $data, string $version = '3.3')
    {
        $this->tagRoot['_attributes'] = array_merge($this->tagRoot['_attributes'], $data);
        $this->addXmlns('xsi', 'http://www.w3.org/2001/XMLSchema-instance');
        $this->addXmlns('cfdi', 'http://www.sat.gob.mx/cfd/3');

        $this->addSchemaLocation([
            'http://www.sat.gob.mx/cfd/3',
            'http://www.sat.gob.mx/sitio_internet/cfd/3/cfdv33.xsd',
        ]);
        $this->tagRoot['_attributes']['Version'] = $version;
    }

    public function setAttributesXml(string $version = '1.0', string $encoding = 'utf-8')
    {
        $this->tagRoot['_attributes']['Version'] = $version;
        $this->encoding = $encoding;
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
        if ($co->isComplement()) {
            $properties = $co->getComplementProperties();
            $this->addXmlns($properties['xmlnskey'], $properties['xmlns']);
            $this->addSchemaLocation($properties['schemaLocation']);
        }
        $this->document['cfdi:Conceptos']['cfdi:Concepto'][] = $co->getConcepto();
    }

    private function addXmlns(string $xmlnsKey, string $xmlns)
    {
        $this->tagRoot['_attributes']['xmlns:' . $xmlnsKey] = $xmlns;
    }

    private function addSchemaLocation(array $locations)
    {

        if (!$this->tagRoot['_attributes']['xsi:schemaLocation']) {
            $this->tagRoot['_attributes']['xsi:schemaLocation'] = '';
        }
        $schemaLocation = $this->schema($locations);
        $this->tagRoot['_attributes']['xsi:schemaLocation'] .= ' ' . $schemaLocation;
    }

    private function schema(array $locations): string
    {
        $schemaL = '';
        $i = 0;
        foreach ($locations as $location) {
            if ($i === 0) {
                $schemaL .= $location;
            } else {
                $schemaL .= ' ' . $location;
            }
            $i++;
        }
        return $schemaL;
    }

    public function impuesto(Impuestos $impuesto)
    {
        if (!isset($this->document['cfdi:Impuestos'])) {
            $this->document['cfdi:Impuestos'] = [];
        }
        $this->document['cfdi:Impuestos'] = $impuesto->impuesto;
    }

    /**
     * @param {String} cerpath
     */
    public function certificar(string $cerpath)
    {
        $cer = new Certificados();
        $nomcer = $cer->getNoCer($cerpath);
        $this->tagRoot['_attributes']['NoCertificado'] = $nomcer;
        $this->tagRoot['_attributes']['Certificado'] = $cer->getCer($cerpath);
    }

    private function getCadenaOriginal(): string
    {
        try {

            $name = uniqid(rand(), true);
            $pathdir = sys_get_temp_dir() . '/' . $name . '.xml';
            file_put_contents($pathdir, $this->getDocument());
            $stylesheetDir = join([dirname(__DIR__), '/src/resources/xslt33/cadenaoriginal_3_3.xslt']);
            $transform = new Transform();
            $cadena = $transform->s($pathdir)->xsl($stylesheetDir)->warnings('silent')->run();
            unlink($pathdir);
            return $cadena;

        } catch (Exception $e) {
            header("HTTP/1.0 500");
            die($e->getMessage());
        }
    }

    private function getSello(string $cadenaOriginal, string $keyfile, string $password)
    {
        $cadena_original = $cadenaOriginal;
        $openss = new Certificados();
        $archivoKeyPem = $openss->generaKeyPem($keyfile, $password);
        $pkeyid = openssl_get_privatekey($archivoKeyPem['privateKeyPem']);
        openssl_sign($cadena_original, $crypttext, $pkeyid, OPENSSL_ALGO_SHA256);
        openssl_free_key($pkeyid);
        $sello = base64_encode($crypttext);
        return $sello;
    }

    public function sellar(string $keyfile, string $password)
    {
        $cadena = $this->getCadenaOriginal();
        $sello = $this->getSello($cadena, $keyfile, $password);
        $this->tagRoot['_attributes']['Sello'] = $sello;

    }

    public function getArray()
    {
        return $this->document;
    }

    public function getDocument()
    {
        $result = ArrayToXml::convert($this->document, $this->tagRoot, true, $this->encoding);
        $doc = new DOMDocument();
        $doc->loadXML($result);
        $doc->preserveWhiteSpace = false;
        $doc->formatOutput = true;
        return $doc->saveXML();
    }

}

<?php


namespace Signati\Core\Tags;


class Comprobante
{

    public function __construct(array $data, string $version)
    {
        $this->version = $version;

        $data = array_merge($this->attributes(), $data);

        parent::__construct($data);
    }

}
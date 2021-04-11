<?php


namespace Signati\Core\saxon;
use Signati\Core\saxon\CliShare;

class Transform extends CliShare
{
    public $commandline = '';
    public $commandlineArray = [];
    public $saxonBin = '';

    public function __construct()
    {
        $this->saxonBin = $this->getOS();
        $this->commandline = $this->saxonBin;
    }

    public function a($options = 'on' | 'off')
    {
        $this->commandline .= ' -a:' . $options;
        $this->commandlineArray[] = '-a:' . $options;
        return $this;
    }

    public function ea($options = 'on' | 'off')
    {
        $this->commandline .= ' -ea:' . $options;
        $this->commandlineArray[] = '-ea:' . $options;
        return $this;
    }


    public function explain($filename)
    {
        $this->commandline .= ' -explain:' . $filename;
        $this->commandlineArray[] = '-explain:' . $filename;
        return $this;
    }

    public function export($filename)
    {
        $this->commandline .= ' -export:' . $filename;
        $this->commandlineArray[] = '-export:' . $filename;
        return $this;
    }

    public function im($modename)
    {
        $this->commandline .= ' -im:' . $modename;
        $this->commandlineArray[] = '-im:' . $modename;
        return $this;
    }

    public function it($template)
    {
        $this->commandline .= ' -it:' . $template;
        $this->commandlineArray[] = '-it:' . $template;
        return $this;
    }


    public function jit($options = 'on' | 'off')
    {
        $this->commandline .= ' -jit:' . $options;
        $this->commandlineArray[] = '-jit:' . $options;
        return $this;
    }


    public function lib($filenames)
    {
        $this->commandline .= ' -lib:' . $filenames;
        $this->commandlineArray[] = '-lib:' . $filenames;
        return $this;
    }

    public function license($options = 'on' | 'off')
    {
        $this->commandline .= ' -license:' . $options;
        $this->commandlineArray[] = '-license:' . $options;
        return $this;
    }

    public function m($classname)
    {
        $this->commandline .= ' -m:' . $classname;
        $this->commandlineArray[] = '-m:' . $classname;
        return $this;
    }

    public function nogo()
    {
        $this->commandline .= ' -nogo';
        $this->commandlineArray[] = '-nogo';
        return $this;
    }

    public function ns($options = 'uri' | '##any' | '##html5')
    {
        $this->commandline .= ' -ns:' . $options;
        $this->commandlineArray[] = '-ns:' . $options;
        return $this;
    }

    public function or($classname)
    {
        $this->commandline .= ' -or:' . $classname;
        $this->commandlineArray[] = '-or:' . $classname;
        return $this;
    }

    public function relocate($options = 'on' | 'off')
    {
        $this->commandline .= ' -relocate:' . $options;
        $this->commandlineArray[] = '-relocate:' . $options;
        return $this;
    }


    public function target($target = 'EE' | 'PE' | 'HE' | 'JS')
    {
        $this->commandline .= ' -target:' . $target;
        $this->commandlineArray[] = '-target:' . $target;
        return $this;
    }


    public function threads(number $N)
    {
        // todo only -S is activate
        $this->commandline .= ' -threads:' . $N;
        $this->commandlineArray[] = '-threads:' . $N;
        return $this;
    }


    public function warnings($validation = 'silent' | 'recover' | 'fatal')
    {
        $this->commandline .= ' -warnings:' . $validation;
        $this->commandlineArray[] = '-warnings:' . $validation;
        return $this;
    }


    public function xsl(string $filename)
    {
        if (!file_exists($filename)) {
            // throw new Error('No se puede encontrar el archivo para la cadena original!.');
        }
        $this->commandline .= ' -xsl:' . $filename;
        $this->commandlineArray[] = '-xsl:' . $filename;
        return $this;
    }

    public function y(string $filename)
    {
        $this->commandline .= ' -y:' . $filename;
        $this->commandlineArray[] = '-y:' . $filename;
        return $this;
    }


    public function params($value)
    {
        // todo
    }


    private function getOS(): string
    {
        if (stristr(PHP_OS, 'WIN')) {
            return 'transform.exe';
        } else if (stristr(PHP_OS, 'LINUX')) {
            return 'saxon-xslt';
        } else if (stristr(PHP_OS, 'DAR')) {
            return 'transform';
        }
        return 'transform';
    }

}
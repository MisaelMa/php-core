<?php


namespace Signati\Core\saxon;


class cliShare
{
    public $commandline = "";
    public $commandlineArray = [];
    public $saxonBin = '';

    public function __construct()
    {
        $this->commandline = $this->saxonBin;
    }

    public function catalog($filenames)
    {
        $this->commandline .= '-catalog:' . $filenames;
        $this->commandlineArray[] = '-catalog:' . $filenames;
        return $$this;
    }

    public function dtd($options = 'on' | 'off' | 'recover')
    {
        $this->commandline .= '-dtd:' . $options;
        $this->commandlineArray[] = '-dtd:' . $options;
        return $this;
    }

    public function expand($options = 'on' | 'off')
    {
        $this->commandline .= '-expand:' . $options;
        $this->commandlineArray[] = '-expand:' . $options;
        return $this;
    }

    public function ext($options = 'on' | 'off')
    {
        $this->commandline .= ' -ext:' . $options;
        $this->commandlineArray[] = '-ext:' . $options;
        return $this;
    }

    public function init($initializer)
    {
        $this->commandline .= ' -init:' . $initializer;
        $this->commandlineArray[] = '-init:' . $initializer;
        return $this;
    }

    public function l($options = 'on' | 'off')
    {
        $this->commandline .= ' -l:' . $options;
        $this->commandlineArray[] = '-l:' . $options;
        return $this;
    }

    public function now($format)
    {
        $this->commandline .= ' -now:' . $format;
        $this->commandlineArray[] = '-now:' . $format;
        return $this;
    }

    public function o(string $filename)
    {
        $this->commandline .= ' -o:' . $filename;
        $this->commandlineArray[] = '-o:' . $filename;
        return $this;
    }


    public function opt($flags = 'c' | 'd' | 'e' | 'f' | 'g' | 'j' | 'k' | 'l' | 'm' | 'n' | 'r' | 's' | 't' | 'v' | 'w' | 'x')
    {
        $this->commandline .= ' -opt:-' . $flags;
        $this->commandlineArray[] = '-opt:-' . $flags;
        return $this;
    }

    public function outval($options = 'recover' | 'fatal')
    {
        $this->commandline .= ' -outval:' . $options;
        $this->commandlineArray[] = '-outval:' . $options;
        return $this;
    }

    public function p($options = 'on' | 'off')
    {
        $this->commandline .= ' -p:' . $options;
        $this->commandlineArray[] = '-p:' . $options;
        return $this;
    }

    public function quit($options = 'on' | 'off')
    {
        $this->commandline .= ' -quit:' . $options;
        $this->commandlineArray[] = '-quit:' . $options;
        return $this;
    }

    public function r($classname)
    {
        $this->commandline .= ' -r:' . $classname;
        $this->commandlineArray[] = '-r:' . $classname;
        return $this;
    }

    public function repeat(number $integer)
    {
        $this->commandline .= ' -repeat:' . $integer;
        $this->commandlineArray[] = '-repeat:' . $integer;
        return $this;
    }

    public function s($filename)
    {
        if (!file_exists($filename)) {
           // throw new Error('No se puede encontrar el xml processar.');
        }
        $this->commandline .= ' -s:' . $filename;
        $this->commandlineArray[] = '-s:' . $filename;
        return $this;
    }

    public function sa()
    {
        $this->commandline .= ' -sa;
        $this->commandlineArray[] = ' - sa;
        return $this;
    }

    public function scmin(string $filename)
    {
        $this->commandline .= ' -scmin:' . $filename;
        $this->commandlineArray[] = '-scmin:' . $filename;
        return $this;
    }

    public function strip($options = 'all' | 'none' | 'ignorable')
    {
        $this->commandline .= ' -relocate:' . $options;
        $this->commandlineArray[] = '-relocate:' . $options;
        return $this;
    }

    public function t()
    {
        $this->commandline .= ' -t';
        $this->commandlineArray[] = '-t';
        return $this;
    }

    public function Te($classname)
    {
        $this->commandline .= ' -T:' . $classname;
        $this->commandlineArray[] = '-T:' . $classname;
        return $this;
    }

    public function TB(string $filename)
    {
        $this->commandline .= ' -TB:' . $filename;
        $this->commandlineArray[] = '-TB:' . $filename;
        return $this;
    }

    public function TJ()
    {
        $this->commandline .= ' -TJ;
        $this->commandlineArray[] = ' - TJ;
        return $this;
    }

    public function Tlevel($level = 'none' | 'low' | 'normal' | 'high')
    {
        $this->commandline .= ' -Tlevel:' . $level;
        $this->commandlineArray[] = '-Tlevel:' . $level;
        return $this;
    }

    public function Tout(string $filename)
    {
        $this->commandline .= ' -Tout:' . $filename;
        $this->commandlineArray[] = '-Tout:' . $filename;
        return $this;
    }

    public function TP(string $filename)
    {
        $this->commandline .= ' -TP:' . $filename;
        $this->commandlineArray[] = '-TP:' . $filename;
        return $this;
    }

    public function traceout(string $filename)
    {
        $this->commandline .= ' -traceout:' . $filename;
        $this->commandlineArray[] = '-traceout:' . $filename;
        return $this;
    }

    public function tree($level = 'linked' | 'tiny' | 'tinyc')
    {
        $this->commandline .= ' -tree:' . $level;
        $this->commandlineArray[] = '-tree:' . $level;
        return $this;
    }

    public function u()
    {
        $this->commandline .= ' -u;
        $this->commandlineArray[] = ' - u;
        return $this;
    }

    public function val($validation = 'strict' | 'lax')
    {
        $this->commandline .= ' -val:' . $validation;
        $this->commandlineArray[] = '-val:' . $validation;
        return $this;
    }

    public function x($classname)
    {
        $this->commandline .= ' -x:' . $classname;
        $this->commandlineArray[] = '-x:' . $classname;
        return $this;
    }

    public function xi($options = 'on' | 'off')
    {
        $this->commandline .= ' -xi:' . $options;
        $this->commandlineArray[] = '-xi:' . $options;
        return $this;
    }

    public function xmlversion($options = '1.0' | '1.1')
    {
        $this->commandline .= ' -xmlversion:' . $options;
        $this->commandlineArray[] = '-xmlversion:' . $options;
        return $this;
    }

    public function xsd(string $file)
    {
        $this->commandline .= ' -xsd:' . file;
        $this->commandlineArray[] = '-xsd:' . file;
        return $this;
    }

    public function xsdversion($options = '1.0' | '1.1')
    {
        $this->commandline .= ' -xsdversion:' . $options;
        $this->commandlineArray[] = '-xsdversion:' . $options;
        return $this;
    }

    public function xsiloc($options = 'on' | 'off')
    {
        $this->commandline .= ' -xsiloc:' . $options;
        $this->commandlineArray[] = '-xsiloc:' . $options;
        return $this;
    }

    public function feature($value)
    {
        $this->commandline .= ' --feature:' . $value;
        $this->commandlineArray[] = '--feature:' . value;
        return $this;
    }

    public function run()
    {
        try {
            $saxon = shell_exec($this->commandline);
            if ($saxon == '' || $saxon == false || $saxon == null) {
                return 'Error';
            }
            return  $saxon;
        } catch (\Exception $e) {

        }
    }
}
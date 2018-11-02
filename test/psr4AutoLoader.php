<?php

class Psr4AutoLoader
{
    function register()
    {
        spl_autoload_register([$this, "autoLoader"]);
    }

    function autoLoader($className)
    {
        $fullFilePath = $this->parseClassName2Path($className);
        $this->loadFile($fullFilePath);

    }


    private function parseClassName2Path($className): string
    {
        $ns2path = $this->namespace2BaseFilePath();
        $className = ltrim($className, "\\");
        $className = "\\" . $className;
        foreach ($ns2path as $ns => $basePath) {
            if (strpos($className, $ns) === 0) {
                $filePath = substr($className, strlen($ns));
                $fullFilePath = $basePath . str_replace("\\", "/", $filePath) . ".php";
                return $fullFilePath;
            }
        }

        return '';
    }

    private function namespace2BaseFilePath(): array
    {
        return [
            //\curl\libs对应当前调用文件的上级的libs目录,依次类推
            "\curl\libs" => realpath(getcwd() . "/../libs")
        ];
    }

    private function loadFile($filePath)
    {
        if (empty($filePath)) {
            return;
        } else {
            require_once "$filePath";
        }
    }

}


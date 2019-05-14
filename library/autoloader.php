<?php

/** Autoload any classes that are required **/

function __autoload($className) {
    $nSpaceSplit = explode("\\",$className);
    $codeRoot = $nSpaceSplit[0];
    if(in_array('PPHP', $nSpaceSplit)){
        $filePath = _ROOT . DS . 'library' . DS . 'system' . DS . $className . '.php';
        if (file_exists($filePath)) {
            require_once($filePath);return;
        }
    }else if($codeRoot != "system"){
        array_shift($nSpaceSplit);
        $className = implode(DS,$nSpaceSplit);
        $codePools = array('default');
        foreach($codePools as $codePool){
            $filePath = _ROOT . DS . 'app' . DS . 'code' . DS . $codeRoot . DS . $codePool . DS . $className . '.php';
            //echo $filePath."<br>";
            if (file_exists($filePath)) {
                    require_once($filePath);return;
            }
        }
    }else{
        $className = implode(DS,$nSpaceSplit);
        $filePath = _ROOT . DS . 'library' . DS . $className . '.php';
        if (file_exists($filePath)) {
                require_once($filePath);return;
        }
    }
}

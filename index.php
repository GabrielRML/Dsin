<?php

require 'config.php';

// funcao que carrega as classes automaticamente
spl_autoload_register(function ($class) {
    require LIBS . $class .".php";
});
// carrega o bootstrap - inicializador
$bootstrap = new Bootstrap();
// caminhos opcionais
//$bootstrap->setControllerPath();
//$bootstrap->setModelPath();
//$bootstrap->setDefaultFile();
//$bootstrap->setErrorFile();
$bootstrap->init();
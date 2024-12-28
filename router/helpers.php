<?php

function throw404(){
  require __DIR__ . DIRECTORY_SEPARATOR . "..". DIRECTORY_SEPARATOR ."pages". DIRECTORY_SEPARATOR ."404.php"; 
  exit;
}

function useTemplate($templatePath){
  require __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "templates" . DIRECTORY_SEPARATOR . $templatePath . ".php";
}
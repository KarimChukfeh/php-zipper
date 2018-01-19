<?php
/*
  Author: Karim Chukfeh
  01/19/2018
*/


class Pzipper{

  protected $zip;
  protected $zipName;
  protected $text; // A string
  protected $images; // An array of strings

  function __construct($name, $textString, $imagesString){

    // Sanitizes $name to be a legible file name
    $cleanName = preg_replace("/[^a-zA-Z]/", "", $name);

    $this->zipName = "./".$this->$cleanName.".zip";
    $this->zip = new ZipArchive();
    $this->inputText = $text;
    $this->images = explode(",", $imagesString);
  }

  function addTextToZip(){

  }


  function addImagesToZip(){

  }

  function downloadZip(){

  }

}




?>

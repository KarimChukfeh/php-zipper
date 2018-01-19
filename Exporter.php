<?php
/*
  Author: Karim Chukfeh
  01/19/2018
*/


class Exporter{

  protected $zip;
  protected $zipName;
  protected $text; // A string
  protected $images; // An array of strings

  function __construct($name, $text, $imagesString){

    // Sanitizes $name to be a good file name
    $this->zipName = "./".preg_replace("/[^a-zA-Z]/", "", $name).".zip";

    // Create a zip file
    $this->zip = new ZipArchive();

    // Prepare the data
    $this->text = $text;
    $this->images = explode(" ", $imagesString);

  }

  function openZip(){
    if ($this->zip->open($this->zipName, ZipArchive::CREATE)!==TRUE) {
      exit("cannot open <$this->zipName>\n");
    }
  }

  function addTextToZip(){
    $this->openZip();
    $file = "summary.txt";
    $this->zip->addFromString($file, $this->text);
    $this->zip->close;
  }


  function addImagesToZip(){
    $this->openZip();
    foreach($this->images as $imgUrl){
      if(copy($imgUrl, "tmp/".basename($imgUrl))){
        if(file_exists(basename($imgUrl))){
          $this->zip->addFile("tmp/".basename($imgUrl));
        }
      }else{
        print 'Failed to copy !!!';
      }
    }
  }

  function deleteTemps(){
    delete("tmp");
  }


}

$exporter = new Exporter("myzip", "Name: Shrek\nRole: Green Candidate", "https://images.moviepilot.com/images/c_limit,q_auto:good,w_600/m5xa5ajsxsflc2gbdy6k/shrek-credit-dreamworks-pictures.jpg http://shrekshrekshrek.weebly.com/uploads/3/1/0/9/31093949/2456051.jpg");
$exporter->addTextToZip();
$exporter->addImagesToZip();
$exporter->deleteTemps();

?>

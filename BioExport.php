<?php


class BioExport{

  protected $name;
  protected $text;
  protected $images;

  protected $zip;

  function __construct($name, $text, $images){

    //////////////////////
    // Constructor area //
    //////////////////////

    // The string to become .txt
    $this->text = $text;

    // The images are an array of URLs parsed from a string of URLs
    $this->images = explode(" ", $images);

    // The directory name is $name but sanatized
    $this->name = preg_replace('/[^a-zA-Z0-9\-\._]/','', $name);

    ///////////////////////
    // Main routine area //
    ///////////////////////

    // 1) Create a local temporary directory
    if (!file_exists("temp")) {
      mkdir("temp", 0777, true);
    }

    // 2) Create Bio.txt and add it to the temporary directory
    file_put_contents("temp/Bio.txt", $this->text, FILE_APPEND | LOCK_EX);

    // 3) Fetch the images one by one and add them to the temporary directoy
    foreach($this->images as $imgUrl){
      if(! copy($imgUrl, "temp/".basename($imgUrl))){
        print 'Failed to copy !!!';
      }
    }

    // 4) Make an empty $name.zip folder
    $this->zip = new ZipArchive();
    $createZip = $this->zip->open($this->name.".zip", ZipArchive::CREATE);

    // 5) populate $name.zip with all files in the temporary directory
    $rootPath = realpath('temp/');
    if ($createZip !== TRUE) {
      exit("cannot open <$this->name>\n");
    }
    $files = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($rootPath),
        RecursiveIteratorIterator::LEAVES_ONLY
    );
    foreach ($files as $name => $file){
      if (!$file->isDir()){
        // Get real and relative path for current file
        $filePath = $file->getRealPath();
        $relativePath = substr($filePath, strlen($rootPath) + 1);
        // Add current file to archive
        $this->zip->addFile($filePath, $relativePath);
      }
    }

    // Close the zip
    $this->zip->close();

    // Clear the temporary directoy
    foreach($files as $file) {
      unlink($file->getRealPath());
    }
    rmdir('temp');
  }

}

?>
<?php


class BioToZip{

  protected $fileName;
  protected $summary;
  protected $images;

  protected $zip;

  function __construct($name, $summary, $images){

    //////////////////////
    // Constructor area //
    //////////////////////

    // The string to become .txt
    $this->$summary = $summary;

    // The images are an array of URLs parsed from a string of URLs
    $this->images = explode(" ", $images);

    // The directory name is $name but sanatized
    $this->fileName = preg_replace('/[^a-zA-Z0-9\-\._]/','', $name);

    ///////////////////////
    // Main routine area //
    ///////////////////////

    // Create a local temporary directory
    if (!file_exists("temp")) {
      mkdir("temp", 0777, true);
    }

    // Iterator for whatever is in the the temporary directoy
    $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator('temp/'),RecursiveIteratorIterator::LEAVES_ONLY);

    // Create summary.txt and add it to the temporary directory
    file_put_contents("temp/summary.txt", $this->$summary, FILE_APPEND | LOCK_EX);

    // Get the images from the URLs one by one and add them to the temporary directoy
    foreach($this->images as $imgUrl){
      if(! copy($imgUrl, "temp/".basename($imgUrl))){
        print "Failed to copy $imgUrl";
      }
    }

    // Make an empty .zip folder
    $this->zip = new ZipArchive();

    // Open the .zip
    $createZip = $this->zip->open($this->fileName.".zip", ZipArchive::CREATE);
    if ($createZip !== TRUE) {
      exit("cannot open <$this->fileName>\n");
    }

    // Add every file in the temporary directoy to the .zip
    foreach ($files as $file){

      if (!$file->isDir()){ // skip directories (i.e only accept files)

        // get real and relative path for file
        $filePath = $file->getRealPath();
        $relativePath = substr($filePath, strrpos($filePath, '/') + 1);

        // add file to the .zip
        $this->zip->addFile($filePath, $relativePath);
      }
    }

    // Close the zip
    $this->zip->close();

    // Clear the temporary directoy
    foreach($files as $file) {
      @chmod($file, 0777);
      @unlink($file->getRealPath());
    }

    // Delete the temporary directoy
    @rmdir('temp');
  }

}

// Uncomment below for an example

$fileName = "Green Candidate #1";
$summary = "Name: Shrek\nRole: Green Candidate";
$images = "https://images.moviepilot.com/images/c_limit,q_auto:good,w_600/m5xa5ajsxsflc2gbdy6k/shrek-credit-dreamworks-pictures.jpg http://shrekshrekshrek.weebly.com/uploads/3/1/0/9/31093949/2456051.jpg";
$generateZip = new BioToZip($fileName, $summary, $images);

?>

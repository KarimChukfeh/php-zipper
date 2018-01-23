# php-zipper
Creates a `.zip` and populates it with given content

## How to use
Create an instance of BioToZip passing the following params in order:
1) Desired name of the `.zip` as a string
2) Content of the `.txt` as a string
3) The URLs of the images as a string (separate the URLs with a space).

## Example
```php

$fileName = "Green Candidate #1";
$summary = "Name: Shrek\nRole: Green Candidate";
$images = "https://images.moviepilot.com/images/c_limit,q_auto:good,w_600/m5xa5ajsxsflc2gbdy6k/shrek-credit-dreamworks-pictures.jpg http://shrekshrekshrek.weebly.com/uploads/3/1/0/9/31093949/2456051.jpg";

$generateZip = new BioToZip($fileName, $summary, $images);
```

now there exists `GreenCanidate1.zip` relative to the directoy whre `BioToZip.php` is  

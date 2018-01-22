# php-zipper
- Input: a name (string), a text (string), images (string of URLs separated by spaces).
- Outputs `name.zip` containing `text.txt` and a bunch of `.jpgs` from the URLs string


## How to use
Create an instance of BioExport passing the following params in order:
1) Desired name of the `.zip` as a string
2) Content of the `.txt` as a string
3) The URLs of the images as a string (separate the URLs with a space).

## Example
```php
$example = new BioExport("Green Candidate #1", "Name: Shrek\nRole: Green Candidate", "https://images.moviepilot.com/images/c_limit,q_auto:good,w_600/m5xa5ajsxsflc2gbdy6k/shrek-credit-dreamworks-pictures.jpg http://shrekshrekshrek.weebly.com/uploads/3/1/0/9/31093949/2456051.jpg");
```

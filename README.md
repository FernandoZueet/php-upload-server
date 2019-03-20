# PHP Upload and Image Manipulation

Package with functions created to facilitate the upload and manipulation of images to the server.

## Safety Notices

To ensure the security of uploads on the server it is highly recommended that the files be uploaded outside the site's public folder. 

**This library does not validate the submission of any files. Use a validation library of your choice.** 

---

## Documentation

- [Requirements](#requirements)
- [Installation](#installation)
- [Lib instance](#lib-instance)
- [Set file](#set-file)
- [Get file](#get-file)
- [Simple complete example](#simple-complete-example)
- [Image resize](#image-resize)
- [Image crop](#image-crop)
- [Image flip](#image-flip)
- [Image gamma correct](#image-gamma-correct)
- [Image rotate](#image-rotate)
- [Image text](#image-text)
- [Image watermarks](#image-watermarks)
- [Image filter negative](#image-filter-negative)
- [Image filter gray scale](#image-filter-gray-scale)
- [Image filter edgedetect](#image-filter-edgedetect)
- [Image filter emboss](#image-filter-emboss)
- [Image filter gaussian blur](#image-filter-gaussian-blur)
- [Image filter selective blur](#image-filter-selective-blur)
- [Image filter mean removal](#image-filter-mean-removal)
- [Image filter smooth](#image-filter-smooth)
- [Image filter brightness](#image-filter-brightness)
- [Image filter contrast](#image-filter-contrast)
- [Image filter pixelate](#image-filter-pixelate)
- [Image filter colorize](#image-filter-colorize)
- [Contributing](#contributing)
- [Security](#security)
- [Credits](#credits)
- [License](#license)

---

## Requirements

This will install PHP Upload and Image Manipulation and all required dependencies. PHP Upload and Image Manipulation requires PHP 7.0.0 or newer.
To create derived images [GD](https://secure.php.net/manual/pt_BR/ref.image.php) should be installed on your server. 


## Installation

It's recommended that you use [Composer](https://getcomposer.org/) to install Slim.

```bash
$ composer require fernandozueet/php-upload-server
```
## Lib instance

```php
$upload = new FzUpload\Core();
```

## Set file

```php
//url file
$upload->setFile([
    'http://especiais.g1.globo.com/educacao/guia-de-carreiras/2017/teste-vocacional/assets/teste_vocacional_logo.png',
    'https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png'
]);
```

```php
//php file
$upload->setFile($_FILES['file_x']);
```

```php
//slim framework file
$upload->setFile($request->getUploadedFiles());
```

```php
//symphony or laravel framework file
$upload->setFile($request->file_x);
```

## Get file

```php
//get file
$return = $upload->getFile();
```

```php
//value returned
array:2 [
  0 => array:9 [
    "temp" => "C:\xampp\tmp\php2FA2.tmp"
    "extension" => "jpg"
    "image" => array:2 [
      "width" => 500
      "height" => 500
    ]
    "mimeType" => "image/jpeg"
    "name" => "45373949_1GG"
    "completeName" => "45373949_1GG.jpg"
    "randomName" => "c42264551c22b94992a128b39ae84986"
    "completeRandomName" => "c42264551c22b94992a128b39ae84986.jpg"
    "size" => 32643
  ]
  1 => array:9 [
    "temp" => "C:\xampp\tmp\php2FA3.tmp"
    "extension" => "jpg"
    "image" => array:2 [
      "width" => 1200
      "height" => 1200
    ]
    "mimeType" => "image/jpeg"
    "name" => "guarda-roupa-casal-com-espelho-3-portas-de-correr-lara-ciwt-D_NQ_NP_685005-MLB25713052454_062017-F"
    "completeName" => "guarda-roupa-casal-com-espelho-3-portas-de-correr-lara-ciwt-D_NQ_NP_685005-MLB25713052454_062017-F.jpg"
    "randomName" => "c099d9ec06382af2ba3985aa67b4025e"
    "completeRandomName" => "c099d9ec06382af2ba3985aa67b4025e.jpg"
    "size" => 221866
  ]
]
```

## Simple complete example

```php
//lib instance
$upload = new FzUpload\Core();

//set file
$upload->setFile(['https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png']);

//get file 
$files = $upload->getFile();

//save file in C:\teste\p and C:\teste\m
$upload->setSaveDirectory(["C:\\teste\p","C:\\teste\m"]);

//save image as. Possible values: (jpg|quality - 0 to 100, png|quality - 0 to 100, gif, webp|quality - 0 to 100)
$upload->setSaveImageAs(['jpg|100','png|100','gif','webp|100']);

//original name files (optional)
//$upload->setOriginalName();

//upload files
$upload->uploadFile();

//save file to local server
if($upload->saveLocal()) {
    //success
}else{
    //error
}
```

## Image resize

```php
//lib instance
$upload = new FzUpload\Core();

//set file
$upload->setFile(['https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png']);

//save file in C:\teste\p and C:\teste\m
$upload->setSaveDirectory(["C:\\teste\p","C:\\teste\m"]);

//save image as. Possible values: (jpg|quality - 0 to 100, png|quality - 0 to 100, gif, webp|quality - 0 to 100)
$upload->setSaveImageAs(['jpg|100','png|100','gif','webp|100']);

//image resize 
//int $width, int $height, bool $proportion = true
$upload->imageResize(100, 200);

//save file to local server
if($upload->saveLocal()) {
    //success
}else{
    //error
}
```

## Image crop

```php
//lib instance
$upload = new FzUpload\Core();

//set file
$upload->setFile(['https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png']);

//save file in C:\teste\p and C:\teste\m
$upload->setSaveDirectory(["C:\\teste\p","C:\\teste\m"]);

//save image as. Possible values: (jpg|quality - 0 to 100, png|quality - 0 to 100, gif, webp|quality - 0 to 100)
$upload->setSaveImageAs(['jpg|100','png|100','gif','webp|100']);

//image crop
//int $x, int $y, int $width, int $height
$upload->imageCrop(2, 2, 300, 200);

//save file to local server
if($upload->saveLocal()) {
    //success
}else{
    //error
}
```

## Image flip

```php
//lib instance
$upload = new FzUpload\Core();

//set file
$upload->setFile(['https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png']);

//save file in C:\teste\p and C:\teste\m
$upload->setSaveDirectory(["C:\\teste\p","C:\\teste\m"]);

//save image as. Possible values: (jpg|quality - 0 to 100, png|quality - 0 to 100, gif, webp|quality - 0 to 100)
$upload->setSaveImageAs(['jpg|100','png|100','gif','webp|100']);

//image flip
//int mode - Possible values: (IMG_FLIP_HORIZONTAL, IMG_FLIP_VERTICAL, IMG_FLIP_BOTH)
$upload->imageFlip(IMG_FLIP_VERTICAL);

//save file to local server
if($upload->saveLocal()) {
    //success
}else{
    //error
}
```

## Image gamma correct

```php
//lib instance
$upload = new FzUpload\Core();

//set file
$upload->setFile(['https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png']);

//save file in C:\teste\p and C:\teste\m
$upload->setSaveDirectory(["C:\\teste\p","C:\\teste\m"]);

//save image as. Possible values: (jpg|quality - 0 to 100, png|quality - 0 to 100, gif, webp|quality - 0 to 100)
$upload->setSaveImageAs(['jpg|100','png|100','gif','webp|100']);

//image gamma correct
//float $inputgamma, float $outputgamma
$upload->imageGammaCorrect(1.0, 1.537);

//save file to local server
if($upload->saveLocal()) {
    //success
}else{
    //error
}
```

## Image rotate

```php
//lib instance
$upload = new FzUpload\Core();

//set file
$upload->setFile(['https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png']);

//save file in C:\teste\p and C:\teste\m
$upload->setSaveDirectory(["C:\\teste\p","C:\\teste\m"]);

//save image as. Possible values: (jpg|quality - 0 to 100, png|quality - 0 to 100, gif, webp|quality - 0 to 100)
$upload->setSaveImageAs(['jpg|100','png|100','gif','webp|100']);

//image rotate
//int $rotate - Possible values: (0 to 360)
$upload->imageRotate(80);

//save file to local server
if($upload->saveLocal()) {
    //success
}else{
    //error
}
```

## Image text

```php
//lib instance
$upload = new FzUpload\Core();

//set file
$upload->setFile(['https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png']);

//save file in C:\teste\p and C:\teste\m
$upload->setSaveDirectory(["C:\\teste\p","C:\\teste\m"]);

//save image as. Possible values: (jpg|quality - 0 to 100, png|quality - 0 to 100, gif, webp|quality - 0 to 100)
$upload->setSaveImageAs(['jpg|100','png|100','gif','webp|100']);

//image text
//string $text, string $fontFile, int $size, array $rgbColor, int $angle - (0 to 90), int $x, int $y
$upload->imageText('Test test', 'C:\Windows\Fonts\arial.ttf', 16, [255,0,0], 0, 30, 30);

//save file to local server
if($upload->saveLocal()) {
    //success
}else{
    //error
}
```

## Image watermarks

```php
//lib instance
$upload = new FzUpload\Core();

//set file
$upload->setFile(['https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png']);

//save file in C:\teste\p and C:\teste\m
$upload->setSaveDirectory(["C:\\teste\p","C:\\teste\m"]);

//save image as. Possible values: (jpg|quality - 0 to 100, png|quality - 0 to 100, gif, webp|quality - 0 to 100)
$upload->setSaveImageAs(['jpg|100','png|100','gif','webp|100']);

//image watermarks
//int $bottom, int $right, string $imageLogo
$upload->imageWatermarks(10, 10, 'C:\teste\logo.png');

//save file to local server
if($upload->saveLocal()) {
    //success
}else{
    //error
}
```

## Image filter negative

```php
//lib instance
$upload = new FzUpload\Core();

//set file
$upload->setFile(['https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png']);

//save file in C:\teste\p and C:\teste\m
$upload->setSaveDirectory(["C:\\teste\p","C:\\teste\m"]);

//save image as. Possible values: (jpg|quality - 0 to 100, png|quality - 0 to 100, gif, webp|quality - 0 to 100)
$upload->setSaveImageAs(['jpg|100','png|100','gif','webp|100']);

//image filter
$upload->imageFilter(IMG_FILTER_NEGATE);

//save file to local server
if($upload->saveLocal()) {
    //success
}else{
    //error
}
```

## Image filter gray scale

```php
//lib instance
$upload = new FzUpload\Core();

//set file
$upload->setFile(['https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png']);

//save file in C:\teste\p and C:\teste\m
$upload->setSaveDirectory(["C:\\teste\p","C:\\teste\m"]);

//save image as. Possible values: (jpg|quality - 0 to 100, png|quality - 0 to 100, gif, webp|quality - 0 to 100)
$upload->setSaveImageAs(['jpg|100','png|100','gif','webp|100']);

//image filter
$upload->imageFilter(IMG_FILTER_GRAYSCALE);

//save file to local server
if($upload->saveLocal()) {
    //success
}else{
    //error
}
```

## Image filter edgedetect 

```php
//lib instance
$upload = new FzUpload\Core();

//set file
$upload->setFile(['https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png']);

//save file in C:\teste\p and C:\teste\m
$upload->setSaveDirectory(["C:\\teste\p","C:\\teste\m"]);

//save image as. Possible values: (jpg|quality - 0 to 100, png|quality - 0 to 100, gif, webp|quality - 0 to 100)
$upload->setSaveImageAs(['jpg|100','png|100','gif','webp|100']);

//image filter
$upload->imageFilter(IMG_FILTER_EDGEDETECT);

//save file to local server
if($upload->saveLocal()) {
    //success
}else{
    //error
}
```

## Image filter emboss 

```php
//lib instance
$upload = new FzUpload\Core();

//set file
$upload->setFile(['https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png']);

//save file in C:\teste\p and C:\teste\m
$upload->setSaveDirectory(["C:\\teste\p","C:\\teste\m"]);

//save image as. Possible values: (jpg|quality - 0 to 100, png|quality - 0 to 100, gif, webp|quality - 0 to 100)
$upload->setSaveImageAs(['jpg|100','png|100','gif','webp|100']);

//image filter
$upload->imageFilter(IMG_FILTER_EMBOSS);

//save file to local server
if($upload->saveLocal()) {
    //success
}else{
    //error
}
```

## Image filter gaussian blur 

```php
//lib instance
$upload = new FzUpload\Core();

//set file
$upload->setFile(['https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png']);

//save file in C:\teste\p and C:\teste\m
$upload->setSaveDirectory(["C:\\teste\p","C:\\teste\m"]);

//save image as. Possible values: (jpg|quality - 0 to 100, png|quality - 0 to 100, gif, webp|quality - 0 to 100)
$upload->setSaveImageAs(['jpg|100','png|100','gif','webp|100']);

//image filter
$upload->imageFilter(IMG_FILTER_GAUSSIAN_BLUR);

//save file to local server
if($upload->saveLocal()) {
    //success
}else{
    //error
}
```

## Image filter selective blur

```php
//lib instance
$upload = new FzUpload\Core();

//set file
$upload->setFile(['https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png']);

//save file in C:\teste\p and C:\teste\m
$upload->setSaveDirectory(["C:\\teste\p","C:\\teste\m"]);

//save image as. Possible values: (jpg|quality - 0 to 100, png|quality - 0 to 100, gif, webp|quality - 0 to 100)
$upload->setSaveImageAs(['jpg|100','png|100','gif','webp|100']);

//image filter
$upload->imageFilter(IMG_FILTER_SELECTIVE_BLUR);

//save file to local server
if($upload->saveLocal()) {
    //success
}else{
    //error
}
```

## Image filter mean removal

```php
//lib instance
$upload = new FzUpload\Core();

//set file
$upload->setFile(['https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png']);

//save file in C:\teste\p and C:\teste\m
$upload->setSaveDirectory(["C:\\teste\p","C:\\teste\m"]);

//save image as. Possible values: (jpg|quality - 0 to 100, png|quality - 0 to 100, gif, webp|quality - 0 to 100)
$upload->setSaveImageAs(['jpg|100','png|100','gif','webp|100']);

//image filter
$upload->imageFilter(IMG_FILTER_MEAN_REMOVAL);

//save file to local server
if($upload->saveLocal()) {
    //success
}else{
    //error
}
```

## Image filter smooth

```php
//lib instance
$upload = new FzUpload\Core();

//set file
$upload->setFile(['https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png']);

//save file in C:\teste\p and C:\teste\m
$upload->setSaveDirectory(["C:\\teste\p","C:\\teste\m"]);

//save image as. Possible values: (jpg|quality - 0 to 100, png|quality - 0 to 100, gif, webp|quality - 0 to 100)
$upload->setSaveImageAs(['jpg|100','png|100','gif','webp|100']);

//image filter
$upload->imageFilter(IMG_FILTER_SMOOTH);

//save file to local server
if($upload->saveLocal()) {
    //success
}else{
    //error
}
```

## Image filter brightness

```php
//lib instance
$upload = new FzUpload\Core();

//set file
$upload->setFile(['https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png']);

//save file in C:\teste\p and C:\teste\m
$upload->setSaveDirectory(["C:\\teste\p","C:\\teste\m"]);

//save image as. Possible values: (jpg|quality - 0 to 100, png|quality - 0 to 100, gif, webp|quality - 0 to 100)
$upload->setSaveImageAs(['jpg|100','png|100','gif','webp|100']);

//image filter - (-255 to 255)
$upload->imageFilter(IMG_FILTER_BRIGHTNESS, 100);

//save file to local server
if($upload->saveLocal()) {
    //success
}else{
    //error
}
```

## Image filter contrast

```php
//lib instance
$upload = new FzUpload\Core();

//set file
$upload->setFile(['https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png']);

//save file in C:\teste\p and C:\teste\m
$upload->setSaveDirectory(["C:\\teste\p","C:\\teste\m"]);

//save image as. Possible values: (jpg|quality - 0 to 100, png|quality - 0 to 100, gif, webp|quality - 0 to 100)
$upload->setSaveImageAs(['jpg|100','png|100','gif','webp|100']);

//image filter - (-100 to 100)
$upload->imageFilter(IMG_FILTER_CONTRAST, -50);

//save file to local server
if($upload->saveLocal()) {
    //success
}else{
    //error
}
```

## Image filter pixelate

```php
//lib instance
$upload = new FzUpload\Core();

//set file
$upload->setFile(['https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png']);

//save file in C:\teste\p and C:\teste\m
$upload->setSaveDirectory(["C:\\teste\p","C:\\teste\m"]);

//save image as. Possible values: (jpg|quality - 0 to 100, png|quality - 0 to 100, gif, webp|quality - 0 to 100)
$upload->setSaveImageAs(['jpg|100','png|100','gif','webp|100']);

//image filter 
$upload->imageFilter(IMG_FILTER_PIXELATE, 3);

//save file to local server
if($upload->saveLocal()) {
    //success
}else{
    //error
}
```

## Image filter colorize

```php
//lib instance
$upload = new FzUpload\Core();

//set file
$upload->setFile(['https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png']);

//save file in C:\teste\p and C:\teste\m
$upload->setSaveDirectory(["C:\\teste\p","C:\\teste\m"]);

//save image as. Possible values: (jpg|quality - 0 to 100, png|quality - 0 to 100, gif, webp|quality - 0 to 100)
$upload->setSaveImageAs(['jpg|100','png|100','gif','webp|100']);

//image filter 
//arg1 (0 to 255), arg2 (0 to 255), arg3 (0 to 255), arg4 (0 to 127)
$upload->imageFilter(IMG_FILTER_COLORIZE, 64, 193, 198, 50);

//save file to local server
if($upload->saveLocal()) {
    //success
}else{
    //error
}
```

## Contributing

Please see [CONTRIBUTING](https://github.com/FernandoZueet/php-upload-server/graphs/contributors) for details.

## Security

If you discover security related issues, please email fernandozueet@hotmail.com instead of using the issue tracker.

## Credits

- [Fernando Zueet](https://github.com/FernandoZueet)

## License

The PHP Upload and Image Manipulation is licensed under the MIT license. See [License File](LICENSE.md) for more information.

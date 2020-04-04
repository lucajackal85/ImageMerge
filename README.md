# Image Merge
A simple PHP libraty to manipulate images, it support GIF, PNG and JPG

[![Latest Stable Version](https://poser.pugx.org/jackal/image-merge/v/stable)](https://packagist.org/packages/jackal/image-merge)
[![Total Downloads](https://poser.pugx.org/jackal/image-merge/downloads)](https://packagist.org/packages/jackal/image-merge)
[![Latest Unstable Version](https://poser.pugx.org/jackal/image-merge/v/unstable)](https://packagist.org/packages/jackal/image-merge)
[![License](https://poser.pugx.org/jackal/image-merge/license)](https://packagist.org/packages/jackal/image-merge)
[![Build Status](https://travis-ci.org/lucajackal85/BinLocator.svg?branch=master)](https://travis-ci.org/lucajackal85/BinLocator)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/lucajackal85/ImageMerge/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/lucajackal85/ImageMerge/?branch=master)

### Requirement
PHP >= **5.6** with GD support
*For some additional features (for example image distortion) ImageMagick binaries are required.

## Getting Started
Install library with composer
```
composer require jackal/image-merge
```
## Usage
### Minimal example
```

$imageMerge = new ImageMerge();
$imageBuilder = $imageMerge->getBuilder('/path/to/my/file.png'); #or URL, or resource, or binary content

$imageBuilder->resize(620,350)
$imageBuilder->rotate(90);
```
Get the image content directly to the output     
```
[...]
echo $imageBuilder->getImage()->toPNG()->getContent();  
```
Save image to path
```
[...]
$builder->getImage()->toPNG('/path/to/the/image.png');
```
Get image Response object (Compatible with Symgony projects)
```
[...]
return $imageBuilder->getImage()->toPNG()
```

#### `resize`
At least one parameter is required
In case just one parameter is passed, it will resize maintaining the aspect ratio of the image
```
$imageBuilder->resize(620,null);
#or
$imageBuilder->resize(null,200);
```
If both parameters are passed, it could stretch the image
```
$imageBuilder->resize(400,200);
```
#### `thumbnail`
Similar to `Resize` but in case the aspect ratio is not respected, it will crop the image (using `cropCenter`)
```
$imageBuilder->thumbnail(400,400);
```
#### `rotate`
Rotate the image (**counterclockwise**)
```
$imageBuilder->rotate(180);
```
*In case of particular angle (30, 45, etc..) it will create blank area to fill the empty spaces
#### `grayscale`
Add a graysclae filter to the image
```
$imageBuilder->grayScale();
```
#### `brightness`
Adjusts the brightness of the image
```
$imageBuilder->brightness(10);
```
#### `blur`
Adds blur effect on the image
```
$imageBuilder->blur(20);
```
#### `pixelate`
Adds "Pixel" effect on the image
```
$imageBuilder->pixelate(20);
```
#### `crop` and `cropCenter`
**Crop** 
Crop the image according to the *x* and *y* coords and the output dimention passed
```
$point_x = 10,
$point_y = 15;
$width = 50,
$height = 50;
$imageBuilder->crop($point_x,$point_y,$width,$height);
```
Crop at the center of the image according to the width and height of the output image
```
$width = 50,
$height = 50;
$imageBuilder->cropCenter($point_x,$point_y,$width,$height);
```
#### `border`
It adds border to the image (fill inside the rect)
```
$stroke = 20;
$colorHex = '3399ff';
$builder->border($stroke,$colorHex);
```
### Experimental features that will likely change in the future
#### `addText`
It adds text inside the image
```
$text = new Jackal\ImageMerge\Model\Text\Text('this is the text', Font::arial(), 12, new Color('ABCDEF'));
$builder->addText($text, 10, 20);
```
#### `addSquare`
It adds a square (color-filled) on the image
```
$builder->addSquare(10, 10, 20, 20, 'ABCDEF');
```
===========================================================================
## Author
* **Luca Giacalone** (AKA JackalOne)

## License
This project is licensed under the MIT License

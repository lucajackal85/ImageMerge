# Image Merge
A simple PHP libraty to manipulate images, it support GIF,PNG and JPG

### Requirement
PHP >= **5.5.9** with GD support 
For some additional features (for example image distortion) ImageMagick binaries are required.

## Getting Started
Install library with composer
```
composer require jackal/image-merge
```
## Usage
Minimal example
```
$imageMerge = new ImageMerge('/path/to/my/file.png'); #or URL, or resource, or binary content
$imageBuilder = $imageMerge->getBuilder();

$imageBuilder->resize(620,350)
$imageBuilder->rotate(90);
     
header('Content-type: image/png');           
echo $imageBuilder->getImage()->toPNG()->getContent();           
```


## Authors
* **Luca Giacalone** (AKA JackalOne)

## License
This project is licensed under the MIT License
ImageMerge

### Sample Usage

````

$imageMerge = new ImageMerge();
$imageBuilder = $imageMerge->getImageBuilder('/path/to/file/image.jpg'));

$imageBuilder->blur(20);
$imageBuilder->crop(10, 10, 90, 90)

$imageResponse = $imageBuilder->getImage()->toPNG();
````

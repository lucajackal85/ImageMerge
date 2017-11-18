ImageMerge

### Sample Usage

````

$filePath = '/var/www/image.png';

$builder = ImageBuilder::fromFile(new File($filePath));
$builder->crop(0,0,500,500);
$builder->grayScale();

echo $builder->getImage()->toPNG()
````

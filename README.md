ImageMerge

### Sample Usage

````
$configuration = ImageConfiguration::fromFile(new SplFileObject('/var/www/image1.jpg'));

$textConfiguration = TextAssetConfiguration::create(new Font(Font::FONT_ARIAL), 50, 'FFFFFF');

$configuration->addAsset(ImageAsset::fromFile(new SplFileObject('/var/www/asset1.png'), 100, 50));
$configuration->addAsset(new TextAsset('Questa è una prova', $textConfiguration));

$image = new Image($configuration);

echo $image->dump();
````

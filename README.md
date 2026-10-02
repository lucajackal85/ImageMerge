# Image Merge
A simple PHP library to manipulate images. It supports JPEG, PNG, GIF and WebP.

[![Latest Stable Version](https://poser.pugx.org/jackal/image-merge/v/stable)](https://packagist.org/packages/jackal/image-merge)
[![Total Downloads](https://poser.pugx.org/jackal/image-merge/downloads)](https://packagist.org/packages/jackal/image-merge)
[![License](https://poser.pugx.org/jackal/image-merge/license)](https://packagist.org/packages/jackal/image-merge)
[![CI](https://github.com/lucajackal85/ImageMerge/actions/workflows/ci.yml/badge.svg?branch=master)](https://github.com/lucajackal85/ImageMerge/actions/workflows/ci.yml)

> **Upgrading from 0.4.x?** Version 1.0 has a new, safer API. See [UPGRADE-1.0.md](UPGRADE-1.0.md).

### Requirements
- PHP >= **8.2** with the `gd` (JPEG/PNG/WebP/FreeType support) and `exif` extensions
- [ImageMagick](https://imagemagick.org/) (`magick` or `convert`) only for the `Distortion` effect

## Getting Started
Install the library with composer
```
composer require jackal/image-merge
```

## Usage
### Loading an image
Pick the factory that matches your source:
```php
use Jackal\ImageMerge\ImageMerge;

$builder = ImageMerge::fromPath('/path/to/my/file.png');   // local file
$builder = ImageMerge::fromContent($binaryString);         // raw image bytes, e.g. an upload
$builder = ImageMerge::fromUrl('https://example.com/a.jpg'); // remote http(s) file
$builder = ImageMerge::fromStream($resource);              // open stream
$builder = ImageMerge::fromSplFileObject($splFileObject);
$builder = ImageMerge::fromImage($image);                  // an existing Jackal\ImageMerge\Model\Image
```

### Minimal example
```php
$builder = ImageMerge::fromPath('/path/to/my/file.png')
    ->resize(620, 350)
    ->rotate(90);
```
Get the image content
```php
echo $builder->getImage()->toPNG()->getContent();
```
Save the image to a path
```php
$builder->getImage()->toPNG('/path/to/the/image.png');
```
Get a Response object (compatible with Symfony projects)
```php
return $builder->getImage()->toPNG();
```
`toJPG()`, `toGIF()` and `toWebP()` work the same way.

### Operations
#### `resize`
At least one parameter is required.
If only one is passed, the aspect ratio of the image is kept
```php
$builder->resize(620, null);
// or
$builder->resize(null, 200);
```
If both are passed, the image may be stretched
```php
$builder->resize(400, 200);
```
#### `thumbnail`
Like `resize`, but if the aspect ratio doesn't match it crops the image (using `cropCenter`)
```php
$builder->thumbnail(400, 400);
$builder->thumbnail(400, null); // keeps the aspect ratio
```
#### `rotate`
Rotate the image (**counterclockwise**)
```php
$builder->rotate(180);
```
*For angles that aren't multiples of 90, the empty areas are filled with transparent pixels.
#### `flipHorizontal` and `flipVertical`
```php
$builder->flipHorizontal();
$builder->flipVertical();
```
#### `grayScale`
Add a grayscale filter to the image
```php
$builder->grayScale();
```
#### `brightness` and `contrast`
```php
$builder->brightness(10);
$builder->contrast(-20);
```
#### `blur`
Add a blur effect to the image
```php
$builder->blur(20);
```
#### `pixelate`
Add a "pixel" effect to the image
```php
$builder->pixelate(20);
```
#### `crop` and `cropCenter`
Crop the image starting from the *x* and *y* coords, with the given output size.
The area must be inside the image, otherwise an `InvalidArgumentException` is thrown
```php
$x = 10;
$y = 15;
$width = 50;
$height = 50;
$builder->crop($x, $y, $width, $height);
```
Crop at the center of the image, with the given output size
```php
$builder->cropCenter(50, 50);
```
#### `cropPolygon`
Keep only the area inside the polygon (at least three x,y points), making the rest transparent
```php
$builder->cropPolygon(10, 10, 200, 20, 100, 200);
```
#### `border`
Add a border to the image (drawn inside the image)
```php
$builder->border(20, '3399ff');
```
#### `merge`
Draw another image on top, at the given position
```php
$builder->merge(ImageMerge::fromPath('/path/to/logo.png')->getImage(), 10, 10);
```
### Experimental features that will likely change in the future
#### `addText`
Add text to the image
```php
use Jackal\ImageMerge\Model\Color;
use Jackal\ImageMerge\Model\Font\Font;
use Jackal\ImageMerge\Model\Text\Text;

$text = new Text('this is the text', Font::liberationSans(), 12, new Color('ABCDEF'));
$builder->addText($text, 10, 20);
```
#### `addSquare`
Add a color-filled square to the image
```php
$builder->addSquare(10, 10, 20, 20, 'ABCDEF');
```

## Security
The library is designed to be safe with untrusted input, within these limits:

- **Remote files**: `fromUrl()` accepts only `http` and `https`, refuses private, loopback,
  link-local and reserved addresses, doesn't follow redirects, and enforces a timeout and a
  maximum size. Pass a configured `Jackal\ImageMerge\Loader\UrlLoader` to change these settings,
  e.g. `new UrlLoader(timeout: 5, maxBytes: 5_000_000)`. The host is checked before the
  request is made, so DNS rebinding is not prevented. If you load URLs supplied by users, also
  restrict outbound traffic at the network level.
- **Local files**: `fromPath()` refuses stream wrappers such as `phar://` or `php://`. Never
  pass a path built from user input without validating it.
- **Resource limits**: image dimensions and file size are checked from the header before
  decoding, to stop "decompression bombs". Defaults are 50 megapixels, 50 MB and a blur level
  of 100. You can change them globally:
  ```php
  use Jackal\ImageMerge\Limits;

  Limits::setDefault(new Limits(maxPixels: 20_000_000, maxFileSize: 10 * 1024 * 1024, maxBlurLevel: 50));
  ```
- **Metadata**: EXIF, IPTC and XMP values come from the file itself and are attacker-controlled.
  Escape them before displaying them, for example in HTML.

## Development
```
composer install
composer check        # everything CI checks: Rector, php-cs-fixer and PHPUnit
```
Or one tool at a time:

| Command | What it does |
|---|---|
| `composer test` | Run the PHPUnit suite |
| `composer cs` / `composer cs-fix` | Check / fix code style ([php-cs-fixer](https://github.com/PHP-CS-Fixer/PHP-CS-Fixer), config in `.php-cs-fixer.dist.php`) |
| `composer rector` / `composer rector-fix` | Check / apply automated refactorings ([Rector](https://getrector.com), config in `rector.php`) |

When you run the fixers, run Rector first and php-cs-fixer second, because Rector's output is then reformatted.

Tests that download a real image are in the `network` group. Skip them offline with `vendor/bin/phpunit --exclude-group network`.

The suite needs GD, EXIF and ImageMagick. If you don't have them locally, use the bundled Docker image (the `PHP_VERSION` build argument chooses the PHP version):
```
docker build --build-arg PHP_VERSION=8.3 -t imagemerge-test docker/
docker run --rm -v "$PWD":/app imagemerge-test composer install
docker run --rm -v "$PWD":/app imagemerge-test composer check
```

CI (GitHub Actions) runs the tests on PHP 8.2, 8.3, 8.4 and 8.5, plus PHP 8.2 with the lowest allowed dependencies. It also runs `composer validate --strict`, `composer audit`, and the Rector and php-cs-fixer checks.

## Author
* **Luca Giacalone** (AKA JackalOne)

## License
This project is licensed under the MIT License, see [LICENSE](LICENSE).

The bundled font [Liberation Sans](https://github.com/liberationfonts) (`src/Resources/Fonts/LiberationSans-Regular.ttf`)
is licensed under the SIL Open Font License 1.1, see [src/Resources/Fonts/LICENSE-LiberationSans.txt](src/Resources/Fonts/LICENSE-LiberationSans.txt).

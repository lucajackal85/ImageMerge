<?php

/**
 * Generates the synthetic test images (no third-party content), see generate.sh.
 *
 *   php generate-images.php inputs     source images, drawn with GD
 *   php generate-images.php expected   expected outputs, produced by the library itself
 *
 * Flip expectations and the animated WebP are made with ImageMagick in generate.sh,
 * so the flip tests don't compare the library against itself.
 */

require __DIR__ . '/../../vendor/autoload.php';

use Jackal\ImageMerge\Command\Effect\Distortion;
use Jackal\ImageMerge\Command\Effect\EffectBlurCentered;
use Jackal\ImageMerge\Command\Options\DimensionCommandOption;
use Jackal\ImageMerge\Command\Options\MultiCoordinateCommandOption;
use Jackal\ImageMerge\ImageMerge;
use Jackal\ImageMerge\Model\Color;
use Jackal\ImageMerge\Model\File\FileObject;
use Jackal\ImageMerge\Model\Font\Font;
use Jackal\ImageMerge\Model\Image;
use Jackal\ImageMerge\Model\Text\Text;
use Jackal\ImageMerge\ValueObject\Coordinate;
use Jackal\ImageMerge\ValueObject\Dimension;

$functional = __DIR__ . '/../FunctionalTest/Resources';
$unit = __DIR__ . '/../UnitTest/Resources';

/**
 * Asymmetric scene: vertical gradient, a circle, a rectangle and a triangle,
 * all off-centre so flips and rotations are detectable.
 */
function scene(int $width, int $height, int $variant = 0): GdImage
{
    $im = imagecreatetruecolor($width, $height);
    for ($y = 0; $y < $height; $y++) {
        $t = $y / max(1, $height - 1);
        imageline($im, 0, $y, $width, $y, imagecolorallocate(
            $im,
            (int) (30 + 160 * $t),
            80 + 40 * $variant,
            (int) (210 - 140 * $t)
        ));
    }

    $min = min($width, $height);
    imagefilledellipse($im, (int) ($width * 0.28), (int) ($height * 0.4), (int) ($min * 0.45), (int) ($min * 0.45), imagecolorallocate($im, 245, 200, 60));
    imagefilledrectangle($im, (int) ($width * 0.6), (int) ($height * 0.15), (int) ($width * 0.85), (int) ($height * 0.55), imagecolorallocate($im, 30, 160, 110));
    imagefilledpolygon($im, [
        (int) ($width * 0.55), (int) ($height * 0.9),
        (int) ($width * 0.75), (int) ($height * 0.62),
        (int) ($width * 0.95), (int) ($height * 0.9),
    ], imagecolorallocate($im, 220, 70, 90));
    imagefilledrectangle($im, 0, 0, (int) ($width * 0.08), (int) ($height * 0.08), imagecolorallocate($im, 255, 255, 255));

    return $im;
}

/**
 * Transparent canvas with an opaque square and a semi-transparent circle.
 */
function overlay(int $width, int $height): GdImage
{
    $im = imagecreatetruecolor($width, $height);
    imagealphablending($im, false);
    imagesavealpha($im, true);
    imagefill($im, 0, 0, imagecolorallocatealpha($im, 0, 0, 0, 127));
    imagealphablending($im, true);
    imagefilledrectangle($im, (int) ($width * 0.1), (int) ($height * 0.1), (int) ($width * 0.4), (int) ($height * 0.4), imagecolorallocate($im, 250, 250, 250));
    imagefilledellipse($im, (int) ($width * 0.55), (int) ($height * 0.55), (int) ($width * 0.6), (int) ($height * 0.6), imagecolorallocatealpha($im, 200, 30, 160, 64));

    return $im;
}

function writeImage(GdImage $im, string $path): void
{
    match (pathinfo($path, PATHINFO_EXTENSION)) {
        'jpg' => imagejpeg($im, $path, 90),
        'png' => imagepng($im, $path, 9),
        'gif' => imagegif($im, $path),
    };
    echo "  $path\n";
}

switch ($argv[1] ?? '') {
    case 'inputs':
        writeImage(scene(128, 128), "$functional/DistortionTest/01.jpg");
        writeImage(scene(800, 500), "$functional/FlipTest/01.png");
        writeImage(scene(800, 500, 1), "$functional/ImageTest/01.jpg");
        writeImage(scene(620, 350, 2), "$functional/ImageTest/03.jpg");
        writeImage(overlay(400, 400), "$functional/ImageTest/04.png");
        writeImage(overlay(146, 150), "$unit/ImageReaderTest/02.png");

        $gif = scene(256, 224, 1);
        imagetruecolortopalette($gif, false, 64);
        writeImage($gif, "$unit/ImageReaderTest/03.gif");

        // frames for the animated WebP, assembled by ImageMagick in generate.sh
        foreach ([0, 1, 2] as $i) {
            writeImage(scene(200, 113, $i), sys_get_temp_dir() . "/imagemerge-frame-$i.png");
        }

        break;

    case 'expected':
        $builder = ImageMerge::fromPath("$functional/ImageTest/01.jpg");
        $builder
            ->addSquare(10, 10, 20, 20, 'ABCDEF')
            ->addText(new Text('this is the text', Font::liberationSans(), 12, new Color('ABCDEF')), 10, 20)
            ->thumbnail(100, 100)
            ->grayScale()
            ->brightness(10)
            ->blur(20)
            ->pixelate(10)
            ->crop(10, 10, 90, 90)
            ->resize(50, 50)
            ->cropCenter(40, 40)
            ->rotate(90)
            ->border(1);
        $builder->addCommand(new EffectBlurCentered(new DimensionCommandOption(new Dimension(200, 200))));
        $builder->getImage()->toPNG("$functional/ImageTest/02.png");

        $builder = ImageMerge::fromPath("$functional/ImageTest/03.jpg");
        $builder->merge(Image::fromFile(new FileObject("$functional/ImageTest/04.png")));
        $builder->crop(0, 0, 200, 200);
        $builder->getImage()->toPNG("$functional/ImageTest/05.png");

        ImageMerge::fromPath("$functional/ImageTest/03.jpg")->getImage()->toWebP("$functional/ImageTest/03.webp");
        copy("$functional/ImageTest/03.webp", "$unit/ImageReaderTest/04.webp");

        $builder = ImageMerge::fromPath("$functional/DistortionTest/01.jpg");
        $builder->addCommand(new Distortion(new MultiCoordinateCommandOption([
            new Coordinate(26, 0),
            new Coordinate(114, 23),
            new Coordinate(128, 100),
            new Coordinate(0, 123),
        ])));
        $builder->getImage()->toJPG("$functional/DistortionTest/02.jpg");

        echo "  expected outputs written\n";

        break;

    default:
        fwrite(STDERR, "usage: php generate-images.php inputs|expected\n");
        exit(1);
}

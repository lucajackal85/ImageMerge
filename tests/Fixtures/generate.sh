#!/bin/sh
# Regenerates every test image (see README.md). All of them are synthetic (no third-party content)
# and all metadata is fictional.
# Needs PHP with GD, ImageMagick 7 and exiftool, plus `composer install`; e.g. in the docker/ image:
#   apt-get install -y libimage-exiftool-perl && sh tests/Fixtures/generate.sh
set -e
DIR=$(cd "$(dirname "$0")" && pwd)
OUT="$DIR/photo-with-metadata.jpg"
FUNCTIONAL="$DIR/../FunctionalTest/Resources"
UNIT="$DIR/../UnitTest/Resources"
TMP=$(php -r 'echo sys_get_temp_dir();')

echo "Input images (GD):"
php "$DIR/generate-images.php" inputs

echo "Flip expectations and animated WebP (ImageMagick):"
magick "$FUNCTIONAL/FlipTest/01.png" -flop -strip -define png:exclude-chunks=date,time "$FUNCTIONAL/FlipTest/02.png"
magick "$FUNCTIONAL/FlipTest/01.png" -flip -strip -define png:exclude-chunks=date,time "$FUNCTIONAL/FlipTest/03.png"
magick -delay 20 "$TMP/imagemerge-frame-0.png" "$TMP/imagemerge-frame-1.png" "$TMP/imagemerge-frame-2.png" \
    -loop 0 "$UNIT/ImageReaderTest/05-animated.webp"
rm "$TMP"/imagemerge-frame-*.png

echo "Expected outputs (library snapshots):"
php "$DIR/generate-images.php" expected

echo "Metadata fixture (GD + exiftool):"

php -r '
$w = 600; $h = 400;
$im = imagecreatetruecolor($w, $h);
for ($y = 0; $y < $h; $y++) {
    imageline($im, 0, $y, $w, $y, imagecolorallocate($im, (int) (40 + 150 * $y / $h), 90, (int) (200 - 120 * $y / $h)));
}
imagefilledellipse($im, 200, 200, 220, 220, imagecolorallocate($im, 240, 200, 60));
imagefilledrectangle($im, 360, 120, 520, 300, imagecolorallocate($im, 30, 160, 110));
imagejpeg($im, $argv[1], 90);
' "$OUT"

cat > "$DIR/metadata.xmp" <<'XMP'
<?xpacket begin="" id="W5M0MpCehiHzreSzNTczkc9d"?>
<x:xmpmeta xmlns:x="adobe:ns:meta/">
 <rdf:RDF xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#">
  <rdf:Description rdf:about=""
    xmlns:xmp="http://ns.adobe.com/xap/1.0/"
    xmlns:photoshop="http://ns.adobe.com/photoshop/1.0/"
    xmlns:photomechanic="http://ns.camerabits.com/photomechanic/1.0/"
    xmlns:dc="http://purl.org/dc/elements/1.1/"
    xmp:CreateDate="2017-11-12T18:37:12+01:00"
    photoshop:CaptionWriter="writer@example.com"
    photomechanic:Prefs="0:0:0:001234"
    photomechanic:PMVersion="PM5"
    photomechanic:Tagged="False"
    photomechanic:ColorClass="0">
   <dc:rights>
    <rdf:Alt>
     <rdf:li xml:lang="x-default">Example Studio&#xA;email: photos@example.com</rdf:li>
    </rdf:Alt>
   </dc:rights>
   <dc:subject>
    <rdf:Bag>
     <rdf:li>sample</rdf:li>
     <rdf:li>test image</rdf:li>
     <rdf:li>gradient</rdf:li>
     <rdf:li>shapes</rdf:li>
     <rdf:li>Portrait</rdf:li>
     <rdf:li>Circle</rdf:li>
     <rdf:li>Square</rdf:li>
    </rdf:Bag>
   </dc:subject>
   <dc:description>
    <rdf:Alt>
     <rdf:li xml:lang="x-default">Test City, Example Region.&#xA;Sunday 12 November 2017.&#xA;A yellow circle and a green square on a gradient background.&#xA;ref: Synthetic Image 001234</rdf:li>
    </rdf:Alt>
   </dc:description>
  </rdf:Description>
 </rdf:RDF>
</x:xmpmeta>
<?xpacket end="w"?>
XMP

exiftool -q -overwrite_original -charset iptc=UTF8 \
    -EXIF:Make='Canon' \
    -EXIF:Model='Canon EOS-1D X' \
    -EXIF:SerialNumber='000000000001' \
    -EXIF:ExposureTime='1/1000' \
    -EXIF:FNumber=8 \
    -EXIF:FocalLength=200 \
    -EXIF:ISO=250 \
    -EXIF:XResolution=72 -EXIF:YResolution=72 -EXIF:ResolutionUnit=inches \
    -EXIF:Software='Adobe Photoshop Lightroom 6.12 (Macintosh)' \
    -EXIF:LensModel='EF70-200mm f/2.8L IS II USM' \
    -EXIF:LensSerialNumber='0000abcdef' \
    -EXIF:LensInfo='70 200 undef undef' \
    -EXIF:ExposureCompensation='-1/3' \
    -EXIF:MeteringMode#=5 \
    -EXIF:Flash#=16 \
    -IPTC:CodedCharacterSet=UTF8 \
    -IPTC:Writer-Editor='writer@example.com' \
    -IPTC:DateCreated=2017:11:12 \
    -IPTC:TimeCreated='18:37:12+01:00' \
    -IPTC:Keywords=sample -IPTC:Keywords='test image' -IPTC:Keywords=gradient -IPTC:Keywords=shapes \
    -IPTC:Keywords=Portrait -IPTC:Keywords=Circle -IPTC:Keywords=Square \
    "-IPTC:CopyrightNotice=Example Studio
email: photos@example.com" \
    "-IPTC:Caption-Abstract=Test City, Example Region.
Sunday 12 November 2017.
A yellow circle and a green square on a gradient background.
ref: Synthetic Image 001234" \
    "-XMP<=$DIR/metadata.xmp" \
    "$OUT"

rm "$DIR/metadata.xmp"

# Upgrading from 0.4.x to 1.0

Version 1.0 fixes several security problems and bugs. Fixing them meant changing the
public API, so 1.0 is a new major version. If you stay on `^0.4`, Composer will never
install 1.0 for you.

## Requirements
- PHP **8.2** or newer (0.4 supported PHP 5.6+)
- ImageMagick is still needed only for `Distortion`; both `magick` (IM7) and `convert` (IM6) work

## Loading images: `getBuilder()` is removed
`getBuilder($source)` guessed whether a string was a path, a URL or image bytes. With untrusted
input, that let an attacker read local files, trigger `phar://` deserialization or make the
server send requests to internal addresses (SSRF). Use the factory that matches your source:

| 0.4.x | 1.0 |
|---|---|
| `(new ImageMerge())->getBuilder('/path/file.png')` | `ImageMerge::fromPath('/path/file.png')` |
| `(new ImageMerge())->getBuilder($bytes)` | `ImageMerge::fromContent($bytes)` |
| `(new ImageMerge())->getBuilder('https://…')` | `ImageMerge::fromUrl('https://…')` |
| `(new ImageMerge())->getBuilder($stream)` | `ImageMerge::fromStream($stream)` |
| `(new ImageMerge())->getBuilder(new FileObject($p))` | `ImageMerge::fromPath($p)` |
| `(new ImageMerge())->getBuilder($splFileObject)` | `ImageMerge::fromSplFileObject($splFileObject)` |
| `(new ImageMerge())->getBuilder($image)` | `ImageMerge::fromImage($image)` |

`ImageMerge` can no longer be instantiated. `registerImageBuilderStrategy()` and the
`Jackal\ImageMerge\Strategy\*` classes are removed.

### `fromUrl()` is stricter
- Only `http` and `https` are accepted.
- Private, loopback, link-local and reserved addresses are refused.
- Redirects are not followed.
- There is a 10 second timeout and a 20 MB size limit.

To load from a trusted internal host, or to change the limits, pass a loader:
```php
use Jackal\ImageMerge\Loader\UrlLoader;

ImageMerge::fromUrl($url, new UrlLoader(timeout: 5, maxBytes: 5_000_000, allowPrivateNetworks: true));
```

## Resource limits
Images larger than 50 megapixels or 50 MB, and blur levels above 100, now throw
`Jackal\ImageMerge\Exception\ImageLimitExceededException`. To raise the limits:
```php
Jackal\ImageMerge\Limits::setDefault(new Jackal\ImageMerge\Limits(maxPixels: 100_000_000));
```

## Renamed: `Dimention` → `Dimension`
- `Jackal\ImageMerge\ValueObject\Dimention` → `Jackal\ImageMerge\ValueObject\Dimension`
- `DimensionCommandOption::getDimention()` / `CropCommandOption::getDimention()` → `getDimension()`
- The option key `'dimention'` → `'dimension'`

## Font: Arial is replaced by Liberation Sans
The bundled `arial.ttf` was Microsoft/Monotype's Arial, which may not be redistributed, so it
has been removed. Use `Font::liberationSans()` instead. Liberation Sans is free (SIL Open Font
License 1.1) and has the same metrics as Arial, so text keeps its size and position.
`Font::arial()` and `Font::FONT_ARIAL` still work but are deprecated: they return Liberation Sans.

## Stricter types
- Public methods now declare parameter and return types. For example,
  `ImageBuilder::crop(int, int, int, int): ImageBuilder` and `Image::getResource(): GdImage`.
- Custom commands must declare `execute(Image $image): Image`.
- `Image::getResource()` and `getResourceClone()` return `GdImage` objects, which is what GD has
  returned since PHP 8.0.

## Behaviour changes
- Images GD cannot decode, such as animated WebP, now throw instead of producing an empty image.
- `crop()` throws `InvalidArgumentException` when the area is outside the image or has negative
  coordinates.
- `rotate()` fills uncovered areas with transparent pixels instead of black, and handles angles
  below 1 degree.
- Cloning an `Image` copies the pixels, so changing the clone no longer changes the original.
- `ExifParser::getFlash()` reads the EXIF bit field properly. "Flash did not fire" is now `false`.
- EXIF rational values such as `300/2` or `28/10` are divided; `0/0` returns `null`.
- `XMPParser::getCreationDateTime()` returns `null` when the date is missing, instead of the current time.
- `toJPG()` responses use the `image/jpeg` content type instead of `image/jpg`.
- Temp files are created with `tempnam()` (permissions 0600). Output directories are created
  with 0755 instead of 0777.

# Changelog

## 1.0.0

A modernised and hardened release. **It contains breaking changes**: see [UPGRADE-1.0.md](UPGRADE-1.0.md).

### Security
- Removed `ImageMerge::getBuilder()` input guessing (local file read, `phar://`
  deserialization, SSRF) in favour of explicit `from*()` factories
- `fromUrl()`: http/https only, public addresses only, no redirects, timeout and size limit
- Decompression-bomb protection: dimensions and size are checked before decoding, with configurable `Limits`
- Unbounded blur and negative pixelate levels (infinite loop) are rejected
- Temp files use `tempnam()` instead of predictable `uniqid()` names
- Output directories are created 0755 instead of 0777
- Dropped the `curl | bash` deploy step from CI

### Licensing
- Removed the bundled Arial font (Microsoft/Monotype, not redistributable) and replaced it with
  Liberation Sans (SIL OFL 1.1, same metrics). `Font::arial()` is deprecated in favour of `Font::liberationSans()`
- Added the MIT `LICENSE` file

### Fixed
- `thumbnail()` / `EffectBlurCentered` with a single dimension (division by zero)
- `cropPolygon()` always crashed
- `isDark()` region check, clones sharing pixels, `getResourceClone()` size after resize
- `ScannedDocument` with a custom contrast, crop bounds validation, sub-degree rotation
- Reusing a `ResizeCommand`, empty files, undecodable images silently ignored
- EXIF Flash and rational values, missing XMP date, JPEG content type
- Images are decoded once instead of up to five times

### Changed
- Requires PHP 8.2+, Symfony 6.4/7.x components
- Typed public API; `Dimention` renamed to `Dimension`
- ImageMagick is called through `Symfony\Process` (no shell), supports `magick` and `convert`
- Replaced `jackal/bin-locator` with `symfony/process`
- PHPUnit 11, php-cs-fixer 3, Rector 2, GitHub Actions CI (PHP 8.2–8.5, plus lowest dependencies)
- Composer dist package no longer ships tests and fixtures

## 0.4.5 and earlier
See the [git history](https://github.com/lucajackal85/ImageMerge/commits/v0.4.5).

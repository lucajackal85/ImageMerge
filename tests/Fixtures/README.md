# Test fixtures

`photo-with-metadata.jpg` is a synthetic image (a gradient with simple shapes) made by
`generate.sh`. All its EXIF, IPTC and XMP metadata is fictional, so it contains no
third-party content or personal data. To change the metadata, edit `generate.sh`, run it,
then update the expected values in the parser tests (`tests/FunctionalTest/Metadata/Parser/`).

<?php

namespace Jackal\ImageMerge\Http\Response;

use Symfony\Component\HttpFoundation\Response;

class ImageResponse extends Response
{
    public function __construct($content = '', $status = 200, array $headers = [])
    {
        parent::__construct($content, $status, $headers);
    }
}

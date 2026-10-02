<?php

namespace Jackal\ImageMerge\Exception;

use InvalidArgumentException;

/**
 * Thrown when a URL is malformed, uses a forbidden scheme or points to a non-public address.
 */
class InvalidUrlException extends InvalidArgumentException
{
}

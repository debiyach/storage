<?php
/**
 * Filename: PathRejectException.php
 * Author: Ömer Faruk GÖL <omerfarukgol@hotmail.com>
 * Date: 25.03.2022 09:37
 */

namespace Debiyach\Storage\Exceptions;

use JetBrains\PhpStorm\Pure;

class PathRejectException extends \RuntimeException
{
    #[Pure] public static function withPath(string $path)
    {
        return new static("Corrupted path detected: " . $path);
    }

}
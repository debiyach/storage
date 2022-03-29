<?php
/**
 * Filename: HasPath.php
 * Author: Ömer Faruk GÖL <omerfarukgol@hotmail.com>
 * Date: 25.03.2022 14:01
 */

namespace Debiyach\Storage\Traits;

use Debiyach\Storage\Exceptions\PathRejectException;

trait HasPath
{
    protected function pathClean(string $path): string
    {
        $newPath = [];
        foreach (explode("/", $path) as $patum) {
            switch ($patum) {
                case '..':
                    throw new PathRejectException('Path resolve reject!');
                default:
                    $newPath[] = $patum;
                    break;
            }
        }
        return implode('/', $newPath);
    }
}
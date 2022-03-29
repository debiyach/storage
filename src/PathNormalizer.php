<?php
/**
 * Filename: PathNormalizer.php
 * Author: Ömer Faruk GÖL <omerfarukgol@hotmail.com>
 * Date: 21.03.2022 17:45
 */

namespace Debiyach\Storage;

use Debiyach\Storage\Exceptions\PathRejectException;
use Debiyach\Storage\Interfaces\PathNormalizeInterface;
use Debiyach\Storage\Traits\HasPath;

class PathNormalizer implements PathNormalizeInterface
{
    use HasPath;

    public function pathNormalizer(string $path): string
    {
        $path = str_replace('\\', '/', $path);
        $this->rejectOtherRegex($path);

        return $this->pathClean($path);
    }

    private function rejectOtherRegex(string $path): void
    {
        if (preg_match('#\p{C}+#u', $path)) {
            throw PathRejectException::withPath($path);
        }
    }




}
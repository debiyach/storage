<?php
/**
 * Filename: PathNormalizeInterface.php
 * Author: Ömer Faruk GÖL <omerfarukgol@hotmail.com>
 * Date: 25.03.2022 09:36
 */

namespace Debiyach\Storage\Interfaces;

use Debiyach\Storage\Exceptions\PathRejectException;

interface PathNormalizeInterface
{
    /**
     * @throws PathRejectException
     */
    public function pathNormalizer(string $path);
}
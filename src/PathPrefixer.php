<?php
/**
 * Filename: PathPrefixer.php
 * Author: Ömer Faruk GÖL <omerfarukgol@hotmail.com>
 * Date: 25.03.2022 10:18
 */

namespace Debiyach\Storage;

use JetBrains\PhpStorm\Pure;
use Debiyach\Storage\Traits\HasPath;

class PathPrefixer
{
    use HasPath;
    
   public function __construct(private string $prefix,private string $seperator = "/") { }

    public function prefixPath(string $path): string
    {
        if (substr($this->prefix,-1) !== $this->seperator){
            $this->prefix .= $this->seperator;
        }
        $path = $this->pathClean($path);
        return $this->prefix . ltrim($path,'\\/');
    }

    public function stripPrefix(string $path): string
    {
        return substr($path, strlen($this->prefix));
    }

    #[Pure] public function stripDirectoryPrefix(string $path): string
    {
        return rtrim($this->stripPrefix($path), '\\/');
    }

    #[Pure] public function prefixDirectoryPath(string $path): string
    {
        $prefixedPath = $this->prefixPath(rtrim($path, '\\/'));

        if ($prefixedPath === '' || substr($prefixedPath, -1) === $this->seperator) {
            return $prefixedPath;
        }

        return $prefixedPath . $this->seperator;
    }

}
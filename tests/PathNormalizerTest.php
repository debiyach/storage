<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Debiyach\Storage\PathNormalizer;

/**
 * Filename: MyTest.php
 * Author: Ömer Faruk GÖL <omerfarukgol@hotmail.com>
 * Date: 21.03.2022 17:42
 */
class PathNormalizerTest extends TestCase
{

    public function testPathNormalizer()
    {
        $path = '/home/ubuntu';
        $class = new PathNormalizer($path);
        $this->assertEquals('/home/ubuntu/', $class->pathNormalizer());
    }
    
}
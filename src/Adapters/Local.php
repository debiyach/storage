<?php

namespace Debiyach\Storage\Adapters;

use Debiyach\Storage\Interfaces\FileUploadInterface;
use Debiyach\Storage\Exceptions\OverwriteExistingException;
use Debiyach\Storage\Exceptions\NonExistentFileException;
use Debiyach\Storage\Exceptions\NonExistentDirectoryException;
use Debiyach\Storage\Exceptions\FileDeleteException;
use Debiyach\Storage\Exceptions\DirectoryDeleteException;
use Debiyach\Storage\Exceptions\NonEmptyDirectoryException;
use Debiyach\Storage\PathPrefixer;

class Local implements FileUploadInterface
{
    public function __construct(private PathPrefixer $path, private array $config = []) {}

    public function save(string $from, string $filename): bool
    {
        $path = $this->path->prefixPath($filename);

        if (@$this->config['overrideFile'] === true && file_exists($path)) {
            throw new OverwriteExistingException(
                sprintf(
                    '%s exists but you are trying to overwrite it. Your system does not support overwriting',
                    $filename
                )
            );
        }
        return move_uploaded_file($from, $path);
    }

    public function fileExists(string $path): bool
    {
        $path = $this->path->prefixPath($path);
        if (!is_file($path)) {
            throw new NonExistentFileException(sprintf('%s file not exists', $path));
        }
        return true;
    }

    public function directoryExists(string $path): bool
    {
        $path = $this->path->prefixPath($path);
        if (!is_dir($path)) {
            throw new NonExistentDirectoryException(sprintf('%s directory not exists', $path));
        }
        return true;
    }

    public function read(string $path): string
    {
        $this->fileExists($path);
        $path = $this->path->prefixPath($path);
        return file_get_contents($path);
    }

    public function delete(string $path): bool
    {
        $this->fileExists($path);
        $path = $this->path->prefixPath($path);
        if (!unlink($path)) {
            throw new FileDeleteException(sprintf('%s file not delete', $path));
        }
        return true;
    }

    public function deleteDirectory(string $path): bool
    {
        $this->directoryExists($path);
        $this->isEmptyInDirectory($path);
        $path = $this->path->prefixPath($path);
        if (!rmdir($path)) {
            throw new DirectoryDeleteException(sprintf('%s directory not delete', $path));
        }
        return true;
    }

    public function isEmptyInDirectory(string $path): bool
    {
        $path = $this->path->prefixPath($path);
        $content = glob($path . '/*');
        $count   = count($content);
        if ($count !== 0) {
            throw new NonEmptyDirectoryException(sprintf('It contains %s entities.', $count));
        }
        return true;
    }
}
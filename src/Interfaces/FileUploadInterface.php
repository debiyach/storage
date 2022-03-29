<?php
/**
 * Filename: FileUploadInterface.php
 * Author: Ömer Faruk GÖL <omerfarukgol@hotmail.com>
 * Date: 16.03.2022 21:17
 */

namespace Debiyach\Storage\Interfaces;

use Debiyach\Storage\Exceptions\NonExistentFileException;
use Debiyach\Storage\Exceptions\OverwriteExistingException;
use Debiyach\Storage\Exceptions\NonExistentDirectoryException;
use Debiyach\Storage\Exceptions\DirectoryDeleteException;
use Debiyach\Storage\Exceptions\FileDeleteException;
use Debiyach\Storage\Exceptions\NonEmptyDirectoryException;

interface FileUploadInterface
{
    /**
     * @throws OverwriteExistingException
     */
    public function save(string $from, string $filename);

    /**
     * @throws NonExistentFileException
     */
    public function fileExists(string $path): bool;

    /**
     * @throws NonExistentDirectoryException
     */
    public function directoryExists(string $path): bool;

    /**
     * @throws NonExistentFileException
     */
    public function read(string $path): string;

    /**
     * @throws NonExistentFileException
     * @throws FileDeleteException
     */
    public function delete(string $path);

    /**
     * @throws NonExistentDirectoryException
     * @throws DirectoryDeleteException
     */
    public function deleteDirectory(string $path);

    /**
     * @throws NonEmptyDirectoryException
     */
    public function isEmptyInDirectory(string $path): bool;
    //
    //    /**
    //     * @throws UnableToCreateDirectory
    //     * @throws FilesystemException
    //     */
    //    public function createDirectory(string $path, Config $config): void;
    //
    //    /**
    //     * @throws InvalidVisibilityProvided
    //     * @throws FilesystemException
    //     */
    //    public function setVisibility(string $path, string $visibility): void;
    //
    //    /**
    //     * @throws UnableToRetrieveMetadata
    //     * @throws FilesystemException
    //     */
    //    public function visibility(string $path): FileAttributes;
    //
    //    /**
    //     * @throws UnableToRetrieveMetadata
    //     * @throws FilesystemException
    //     */
    //    public function mimeType(string $path): FileAttributes;
    //
    //    /**
    //     * @throws UnableToRetrieveMetadata
    //     * @throws FilesystemException
    //     */
    //    public function lastModified(string $path): FileAttributes;
    //
    //    /**
    //     * @throws UnableToRetrieveMetadata
    //     * @throws FilesystemException
    //     */
    //    public function fileSize(string $path): FileAttributes;
    //
    //    /**
    //     * @return iterable<StorageAttributes>
    //     *
    //     * @throws FilesystemException
    //     */
    //    public function listContents(string $path, bool $deep): iterable;
    //
    //    /**
    //     * @throws UnableToMoveFile
    //     * @throws FilesystemException
    //     */
    //    public function move(string $source, string $destination, Config $config): void;
    //
    //    /**
    //     * @throws UnableToCopyFile
    //     * @throws FilesystemException
    //     */
    //    public function copy(string $source, string $destination, Config $config): void;
}
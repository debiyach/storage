<?php

namespace Debiyach\Storage;

use Debiyach\Storage\Exceptions\FileUploadException;
use Debiyach\Storage\Interfaces\FileUploadInterface;
use Debiyach\Storage\Exceptions\NotAllowableTypeException;
use Debiyach\Storage\Exceptions\LargerThanAllowedSizeException;
use Debiyach\Storage\Exceptions\MimeTypeNotMatchedException;



/**
 * Class File
 * @author  Ömer Faruk GÖL <omerfarukgol@hotmail.com>
 * @property $name
 * @package Debiyach\Storage
 */
class File
{

    protected array $allowedTypes;

    protected int $size = 1024 * 5;

    private string $fileMimeType;


    /**
     * @throws FileUploadException
     * @throws MimeTypeNotMatchedException
     */
    public function __construct(protected FileUploadInterface $adapter, protected object $file)
    {
        if ($file->error !== 0) {
            throw new FileUploadException($file);
        }
        $this->fileMimeType = $this->file->type;

        return $this;
    }

    public function isEmptyInDirectory(string $path): bool
    {
        return $this->adapter->isEmptyInDirectory($path);
    }

    public function deleteDirectory(string $path)
    {
        return $this->adapter->deleteDirectory($path);
    }

    public function delete(string $path)
    {
        return $this->adapter->delete($path);
    }

    public function read(string $path): string
    {
        return $this->adapter->read($path);
    }

    public function directoryExists(string $path): bool
    {
        return $this->adapter->directoryExists($path);
    }

    public function fileExists(string $filename = null): bool
    {
        $filename ??= $this->file->name;
        return $this->adapter->fileExists($filename);
    }

    public function save(string $filename = null)
    {
        $filename ??= $this->file->name;
        return $this->adapter->save($this->file->tmp_name, $filename);
    }

    /**
     * @return $this
     */
    public function checkSize(): static
    {
        if ($this->file->size > $this->size) {
            throw new LargerThanAllowedSizeException(
                sprintf("file size allowed %s but requested size to be uploaded %s", $this->size, $this->file->size)
            );
        }
        return $this;
    }

    /**
     * @param float|int $size
     *
     * @return $this
     */
    public function setSize(float|int $size): static
    {
        $this->size = $size;
        return $this;
    }

    /**
     * @return float|int
     */
    public function getSize(): float|int
    {
        return $this->size;
    }

    public function checkAllowedTypes()
    {
        if (count($this->allowedTypes) > 0) {
            // TODO : Type manipüle edilebilir. Doğrusunu bulmak lazım. @see https://www.php.net/manual/tr/function.mime-content-type.php
            if (in_array($this->fileMimeType, $this->allowedTypes)) {
                return $this;
            }
            throw new NotAllowableTypeException(
                sprintf(
                    '%s is a disallowed mime type. Allowed types: %s',
                    $this->fileMimeType,
                    implode(',', $this->allowedTypes)
                )
            );
        }
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setAllowedType(string $value): static
    {
        $this->allowedTypes[] = $value;
        return $this;
    }

    /**
     * @param array $allowedTypes
     *
     * @return $this
     */
    public function setAllowedTypes(array $allowedTypes): static
    {
        array_push($this->allowedTypes, ...$allowedTypes);
        return $this;
    }

    /**
     * @param string $key
     *
     * @return array
     */
    public function getAllowedType(string $key): array
    {
        return $this->allowedTypes[$key];
    }

    /**
     * @return array
     */
    public function getAllowedTypes(): array
    {
        return $this->allowedTypes;
    }

    /**
     * HTTP POST ile gönderilen $_FILES global değişkenindeki mim türü ile,
     * TMP dizinine aktarılan geçici dosyanın mim türünü finfo sınıfı ile kontrol ediyoruz.
     * Bu iki değer eşleşmediği durumda
     * @throws MimeTypeNotMatchedException istisnası fırlatılır.
     * Aksi durumunda sınıfın fileMimeType özelliğine mim türü aktarılır.
     */
    public function setFileMimeType()
    {
        $ff        = new \finfo(FILEINFO_MIME_TYPE);
        $finfoMime = $ff->buffer(file_get_contents($this->file->tmp_name));
        if ($this->file->type !== $finfoMime) {
            throw new MimeTypeNotMatchedException(sprintf('The mime type sent is %s, but the system detected this mime type as %s.',$this->file->type,$finfoMime));
        }
        $this->fileMimeType = $finfoMime;
        return $this;
    }
}
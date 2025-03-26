<?php

declare(strict_types=1);

namespace src\Models;

use src\Exceptions\DatabaseDeleteException;
use src\Exceptions\FileNotFound;
use src\Repository\FileRepository;

readonly class File
{
    protected array $file;
    protected string $filePath;

    public function __construct
    (
        private FileRepository $fileRepository,
        array $file = []
    )
    {
        $this->file = $file;
    }

    public function exists(): bool
    {
        return file_exists(STORAGE_PATH . '/' . $this->file['name']);
    }

    public function read(string $filePath): string
    {
        if (!$this->exists()) {
            throw new FileNotFound();
        }
        return file_get_contents($filePath);
    }

    public function save(): void
    {
        $this->fileRepository->save($this->file['name']);
        move_uploaded_file($this->file["tmp_name"], STORAGE_PATH . '/' . $this->file['name']);
    }

    /**
     * @throws DatabaseDeleteException
     */
    public function delete(int $id, string $filename): void
    {
        $this->fileRepository->delete($id);
        unlink(STORAGE_PATH . '/' . $filename);
    }

    public function getAll()
    {
        return $this->fileRepository->getAll();
    }


}
<?php

declare(strict_types=1);

namespace src\Controllers;

use Core\View;
use Doctrine\ORM\EntityManager;
use Entities\File;
use Infrastructure\Http\Request;
use Infrastructure\Http\Response;
use src\Attributes\Route;
use src\Infrastructure\Database\DB;
use src\Repository\FileRepository;

class FileController extends AbstractController
{

    public function __construct(
        private DB            $db,
        private EntityManager $entityManager,
        private Request       $request,
        private Response      $response,
        private FileRepository $fileRepository,
    )
    {
        parent::__construct();
    }

    #[Route('/')]
    public function index(): View
    {
        return View::make('index', [
            'files' => $this->fileRepository->findAll()
        ]);
    }

    #[Route('/upload')]
    public function upload(): View
    {
        try {
            $uploadedFile = $this->getUploadedFile();
            $file = $this->createFileEntity($uploadedFile);
            $this->moveUploadedFile($uploadedFile, $file->getPath());
            $this->saveFileToDatabase($file);

            return $this->response->redirect('/');
        } catch (\Exception $e) {
            return $this->handleError($e);
        }
    }

    public function delete(): View
    {
        try {
            $this->file->delete((int)$_GET['id'], $_GET['name']);
            return $this->index();
        } catch (\Exception $e) {
            return $this->handleError($e);
        }
    }

    #[Route('/form-upload')]
    public function formUpload(): View
    {
        return View::make('form-upload');
    }

    private function getUploadedFile():array
    {
        $uploadedFile = $this->request->file('uploadedFile');

        if (!$uploadedFile || isset($uploadedFile['error']) && $uploadedFile['error'] !== UPLOAD_ERR_OK) {
            throw new \Exception('Ошибка загрузки файла');
        }

        return $uploadedFile;
    }

    private function createFileEntity(array $uploadedFile): File{
        $file = new File();

        $file->setName($uploadedFile['name'])
            ->setSize((string)$uploadedFile['size'])
            ->setType($uploadedFile['type']);

        $uploadPath = $this->generateUploadPath($uploadedFile['name']);

        $file->setPath($uploadPath);
        return $file;
    }

    private function generateUploadPath(string $fileName): string{
        return STORAGE_PATH . '/' . $fileName;
    }

    private function saveFileToDatabase(File $file){
        $this->entityManager->persist($file);
        $this->entityManager->flush();
    }

    private function moveUploadedFile(array $uploadedFile, string $path)
    {
        if(!move_uploaded_file($uploadedFile['tmp_name'], $path)){
            throw new \Exception('Не удалось сохранить файл');
        }
    }

}
<?php

declare(strict_types=1);

namespace src\Controllers;

use Core\App;
use Core\View;
use Doctrine\ORM\EntityManager;
use Entities\File;
use Infrastructure\Http\Request;
use Infrastructure\Http\Response;
use src\Infrastructure\Database\DB;

class FileController extends AbstractController
{

    public function __construct(
        private DB            $db,
        private EntityManager $entityManager,
        private Request       $request,
        private Response      $response,
    )
    {
        parent::__construct();
    }

    public function index(): View
    {


        return View::make('index', [
            'files' => $this->file->getAll()
        ]);
    }

    public function upload(): View
    {
        try {
            $uploadedFile = $this->getUploadedFile();
            $file = $this->createFileEntity($uploadedFile);
            $this->moveUploadedFile($uploadedFile,$file->getPath());
            $this->saveFileToDatabase($file);

            return $this->response->redirect('/');
        } catch (\Exception $e) {
            return $this->handleError($e);
        }


        $uploadedFile = $this->request->file('uploadedFile');



        move_uploaded_file($uploadedFile['tmp_name'], $uploadPath);

        $this->entityManager->persist($file);
        $this->entityManager->flush();

        return $this->response->redirect('/');
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

        $uploadedFile = $this->generateUploadPath($uploadedFile['name']);

        $file->setName($uploadedFile['name'])
            ->setSize((string)$uploadedFile['size'])
            ->setType($uploadedFile['type']);
        $uploadPath = STORAGE_PATH . '/' . $file->getName();

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
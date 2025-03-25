<?php

declare(strict_types=1);

namespace App\Controllers;

use App\App;
use App\Controller;
use App\Database\DB;
use App\Entities\File;
use App\View;
use Doctrine\ORM\EntityManager;

class FileController extends Controller
{

    public function __construct(
        private DB $db,
        private File $file,
        private EntityManager $entityManager,
    ) {}

    public function index(): View
    {
        $file = new File();
        $file->setName('file2');
        $this->entityManager->persist($file);
        $this->entityManager->flush();

        $fileRepository = $this->entityManager->getRepository(File::class);
        $file = $fileRepository->find(42);

        var_dump($file);

        return View::make('index', [
            'files' => $this->file->getAll()
        ]);
    }

    public function upload(): View
    {
        $file = new File(App::db(),$_FILES['uploadedFile'] );
        try {
            $file->save();
        } catch (\Exception $e) {
            return $this->handleError($e);
        }
        return $this->redirect('/');
    }

    public function delete(): View
    {
        try{
            $this->file->delete((int)$_GET['id'],$_GET['name']);
            return $this->index();
        } catch (\Exception $e) {
            return $this->handleError($e);
        }
    }


    public function formUpload(): View
    {
        return View::make('form-upload');
    }

}
<?php

declare(strict_types=1);

namespace App\Controllers;

use App\App;
use App\Controller;
use App\Database\DB;
use App\Helpers\Utils;
use App\Models\File;
use App\View;
use Doctrine\DBAL\DriverManager;

class FileController extends Controller
{
    private DB $db;

    public function __construct(DB $db) {
        $this->db = $db;
    }

    public function index(): View
    {
        $connection = $this->db->getConnection();
        $result = $connection->fetchAllAssociative('SELECT * FROM `transactions`');
        var_dump($connection);die;
        $file = new File(App::db());
        return View::make('index', ['files' => $file->getAll()]);
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
            (new File(App::db()))->delete((int)$_GET['id'],$_GET['name']);
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
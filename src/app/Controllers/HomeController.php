<?php

declare(strict_types = 1);

namespace App\Controllers;

use App\View;

class HomeController
{
    public function index(): View
    {
        return View::make('index');
    }

    public function upload()
    {
        $filePath = STORAGE_PATH . '/' . $_FILES['uploadedFile']['name'];

        move_uploaded_file($_FILES["uploadedFile"]["tmp_name"], $filePath);

        header("Location: /transactions");
        exit();
    }


}
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Форма загрузки файлов</title>
    <link rel="stylesheet" href="/assets/ccs/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/ccs/main.css"
</head>
<body>
<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4 shadow-lg" style="max-width: 500px; width: 100%;">
        <h1 class="mb-4 text-center">Загрузка файла</h1>
        <form action="/upload" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="formFile" class="form-label">Выберите файл для загрузки:</label>
                <input class="form-control" type="file" id="formFile" name="uploadedFile" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Загрузить</button>
        </form>
    </div>
</div>

<script src="/assets/ccs/bootstrap/bootstrap.bundle.min.js"></script>
</body>
</html>
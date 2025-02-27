<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Файлы</title>
    <link rel="stylesheet" href="/assets/ccs/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/ccs/main.css">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center mb-4">Список файлов</h1>

    <!-- Кнопка "Загрузить новый файл" -->
    <div class="text-center mb-4">
        <a href="/form-upload" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#uploadModal">
            Загрузить новый файл
        </a>
    </div>

    <!-- Карточки файлов -->
    <div class="row">
        <?php foreach ($this->params['files'] as $file): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Файл</h5>
                        <p class="card-text">Имя файла: <strong><?= $file['name'] ?></strong></p>
                        <div class="d-grid gap-2">
                            <a href="/transactions?id=<?= $file['id'] ?>" class="btn btn-primary">Перейти к файлу</a>
                            <a href="/delete?id=<?= $file['id'] ?>&name=<?= $file['name'] ?>" class="btn btn-danger">
                                Удалить
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Подключаем Bootstrap JS -->
<script src="/assets/ccs/bootstrap/bootstrap.bundle.min.js"></script>

<script>
    function deleteFile(filename) {
        if (confirm(`Вы уверены, что хотите удалить файл ${filename}?`)) {
            console.log(`Файл ${filename} удален.`);
            // Здесь можно добавить AJAX-запрос для удаления файла
        }
    }
</script>
</body>
</html>
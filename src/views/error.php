<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ошибка - Что-то пошло не так</title>
    <!-- Подключение Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f8d7da, #f5c2c7);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .error-container {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
            max-width: 600px;
            text-align: center;
        }

        .error-container h1 {
            font-size: 3rem;
            color: #dc3545;
            font-weight: bold;
        }

        .error-container p {
            font-size: 1.2rem;
            color: #6c757d;
        }

        .btn-primary {
            background-color: #0069d9;
            border-color: #005cbf;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }

        .btn-secondary {
            background-color: #6c757d;
            border-color: #5a6268;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #4e555b;
        }
    </style>
</head>
<body>
<div class="error-container">
    <!-- Ошибка -->
    <div class="alert alert-danger">
        <h1>Упс! Что-то пошло не так</h1>
        <p>Ошибка: <?= htmlspecialchars($this->params["error"]); ?></p>
    </div>

    <!-- Кнопки действий -->
    <div class="mt-4">

        <a href="/" class="btn btn-primary">Вернуться на главную</a>
        <a href="javascript:location.reload()" class="btn btn-secondary btn-lg">Обновить страницу</a>
    </div>
</div>

<!-- Подключение JS Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ошибка</title>
    <!-- Подключаем Bootstrap CSS -->
    <link rel="stylesheet" href="/assets/ccs/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/ccs/main.css"
    <style>

    </style>
</head>
<body>
<div class="error-container w-50 mx-auto ">
    <div>
        <!-- Иконка ошибки (опционально) -->
        <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" fill="currentColor" class="bi bi-exclamation-triangle text-danger" viewBox="0 0 16 16">
            <path d="M7.938 2.016A.13.13 0 0 1 8.002 2a.13.13 0 0 1 .063.016.15.15 0 0 1 .054.057l6.857 11.667c.036.06.035.124.002.183a.2.2 0 0 1-.054.06.1.1 0 0 1-.066.017H1.146a.1.1 0 0 1-.066-.017.2.2 0 0 1-.054-.06.18.18 0 0 1 .002-.183L7.884 2.073a.15.15 0 0 1 .054-.057zm1.044-.45a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566z"/>
            <path d="M7.002 12a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 5.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995z"/>
        </svg>

        <!-- Сообщение об ошибке -->
        <div class="error-message mt-3">
            <?= htmlspecialchars($this->params['flash']->get('error')); ?>
        </div>

        <!-- Кнопки -->
        <div>
            <a href="/" class="btn btn-primary btn-custom">Вернуться на главную</a>
            <button onclick="window.location.reload()" class="btn btn-secondary btn-custom">Обновить страницу</button>
        </div>
    </div>
</div>

<!-- Подключаем Bootstrap JS (необязательно, если не используете компоненты JS) -->
<script src="/assets/ccs/bootstrap/bootstrap.bundle.min.js"></script>
</body>
</html>

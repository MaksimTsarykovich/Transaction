# Transaction File Application

### Описание

Это простое веб-приложение, которое предоставляет возможность загружать файлы cvs, c определенной заранее определенной структурой, через главную страницу. После загрузки файла пользователь перенаправляется на страницу просмотра файла транзакции. 

Приложение построено с использованием PHP, Nginx, MySQL и Docker. Также используется 1 библиотека для загрузки переменных окружения phpdotenv.

---

## Основные возможности
1. **Главная страница**:
    - Форма для загрузки файла.
2. **Страница просмотра файла**:
    - После загрузки файла пользователь перенаправляется на эту страницу, где отображается информация о транзакции.
3. **Настройки подключения к базе данных**:
    - Параметры подключения хранятся в `.env` файле.

---

## Требования
- Docker и Docker Compose установлены на вашем устройстве.

---


## Структура проекта

```plaintext
|   .gitignore
|   README.md
|   
+---.idea
|
+---docker
|   |   .gitignore
|   |   docker-compose.yml
|   |
|   +---mysql
|   |       Dockerfile
|   |       init.sql
|   |
|   +---nginx
|   |       nginx.conf
|   |
|   \---php
|           Dockerfile
|
\---src
    |   .env
    |   composer.json
    |   composer.lock
    |
    +---app
    |   |   App.php
    |   |   Config.php
    |   |   Router.php
    |   |   View.php
    |   |
    |   +---Controllers
    |   |       Controller.php
    |   |       FileController.php
    |   |       TransactionController.php
    |   |
    |   +---Entities
    |   |       File.php
    |   |
    |   +---Exceptions
    |   |       CalculationException.php
    |   |       DatabaseCompareRowException.php
    |   |       DatabaseDeleteException.php
    |   |       DatabaseInsertException.php
    |   |       DateIsIncorrectFormat.php
    |   |       FileNotCorrect.php
    |   |       FileNotFound.php
    |   |       RouterNotFoundException.php
    |   |       TransactionsNotFound.php
    |   |       ViewNotFoundException.php
    |   |
    |   +---Helpers
    |   |       Currency.php
    |   |       FinanceCalculator.php
    |   |       FlashMessage.php
    |   |       QueryBuilder.php
    |   |       Utils.php
    |   |
    |   +---Models
    |   |       CsvFile.php
    |   |       File.php
    |   |       Model.php
    |   |       Transaction.php
    |   |       TransactionProcessor.php
    |   |
    |   \---Repository
    |           CurrencyRepository.php
    |           DB.php
    |           FileRepository.php
    |           TransactionRepository.php
    |
    +---public
    |   |   index.php
    |   \---assets
    |       +---ccs
    |       |   |   main.css
    |       |   \---bootstrap
    |       |
    |       \---js
    |           \---bootstrap
    |
    +---storage
    |       .gitignore
    |
    +---vendor
    |   |   autoload.php
    |   |
    |   +---composer
    |   |
    |   +---doctrine
    |   |
    |   +---graham-campbell
    |   |
    |   +---laravel
    |   |
    |   +---php-di
    |   |
    |   +---phpoption
    |   |
    |   +---psr
    |   |   +---cache
    |   |   +---container
    |   |
    |   +---symfony
    |   |   +---cache
    |   |               
    |   \---vlucas
    |       \---phpdotenv
    |          
    |
        |   error.php
        |   form-upload.php
        |   index.php
        |   transactions.php
        |
        \---error
                404.php



```

## Установка и запуск

### 1. Клонирование репозитория
Склонируйте репозиторий на ваш локальный компьютер:

```bash
git clone https://github.com/your-repo/transaction-file-viewer.git
cd transaction-file-viewer
```
### 2. Настройка .env файла
Для удобства в корне проекта уже создан файл с параметрами подключения к бд 

### 3. Настройка Docker

В проекте уже имеется файл docker-compose.yml, который описывает инфраструктуру приложения.
Структура сервисов:

    PHP: исполняет серверную логику.
    Nginx: обрабатывает HTTP-запросы.
    MySQL: база данных для хранения данных.
    phpMyAdmin: интерфейс для администрирования базы данных.

### 4. Запуск приложения

Запустите Docker Compose для поднятия всех сервисов:

```bash
docker-compose up --build -d
```

Проверка: 

Главная страница будет доступна по адресу: http://localhost:8000.

phpMyAdmin будет доступен по адресу: http://localhost:8001.





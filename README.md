# TestTaskTMK

Установка
1) Клонировать репозиторий в папку своего Docker `git clone git@github.com:ToRpeDaBanana/TestTaskTMK.git` или скачать по ссылке настроенные Docker файлы от проекта `https://disk.yandex.ru/d/PVM-WYr4A-Ylrg`.
2) В терминале папки проекта прописываем `composer install`.
2.1) Если используете свои Docker файлы - нужно поменять строку подключения к базе данных в файле `.env` `DATABASE_URL="mysql://USERNAME:PASSWORD@(название контейнера с бд):3306/БД?serverVersion=11.5.2-MariaDB-ubu2404"`
3) В терминале переходим в папку с Docker и прописываем `make build`, псоле чего `make up`.
3.1) При использование своих Docker файлов используйте свои команды.
4) В терминале переходим в папку проекта и прописываем `npm install`, дожидаемся окончания процесса - затем пишем `npm build`.
5) В терминале папки проекта делаем миграцию `php bin/console doctrine:migrations:migrate`

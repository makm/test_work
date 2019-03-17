<h4>Общее</h4>
<h5>установка запуск</h5>
git clone https://github.com/makm/test_work.git
cd test_work
docker-compose up -d
docker-compose exec --user 1000 test_php-fpm composer install -d /var/www/test/





@todo:

1) переписать тесты на vfs 
2) оптимизировать перемещение файла
3) оптимизировать скачивание файла
    - можно использовать guzzle и класе-загрузчике 
    - в этой связи и нет теста move класса MoveRemoteFileImageProcessor
    - для теста использовать так же vfsStream

4) при валидации base64 можно кешировать результат, что бы заного его не декодировать (увеличив производительность)
5) тест для DetectFileExtension
6) Можно переименовать imageProcessor в fileProcessor т.к в процессе разработки стало ясно, что он универсальный будет
7) action можно порефакторить и добавить тест
8) выделить генератор названия файлов в отдельный сервис
.... добавить логи, токен
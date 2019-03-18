##Общее
#####установка запуск
git clone https://github.com/makm/test_work.git
cd test_work
docker-compose up -d
docker-compose exec --user 1000 test_php-fpm composer install -d /var/www/test/

#####добавить в hosts 
127.0.0.1	test-work

#####документация доступна 
http://test-work/api/doc

#####прогнать фнкциональные тесты
docker-compose exec --user 1000 test_php-fpm php /var/www/test/vendor/phpunit/phpunit/phpunit --configuration /var/www/test/phpunit.xml /var/www/test/tests/Functional
#####прогнать юнит тесты
docker-compose exec --user 1000 test_php-fpm php /var/www/test/vendor/phpunit/phpunit/phpunit --configuration /var/www/test/phpunit.xml /var/www/test/tests/Unit

##### коллекция потестировать Postman'ом
test.postman_collection.json

##### @todo (что можно доделать):
1) переписать тесты с использованием vfsStream 
2) оптимизировать перемещение файла
3) оптимизировать скачивание файла
    - можно использовать guzzle и класе-загрузчике 
    - в этой связи и нет теста move класса MoveRemoteFileProcessor
    - для теста использовать так же vfsStream

4) при валидации base64 можно кешировать результат, что бы заного его не декодировать
5) тест для DetectFileExtension
6) Расширить тесты (доработать текущие)
7) выделить генератор названия файлов в отдельный сервис
8) пережимать превью на лету
.... добавить логи, токен
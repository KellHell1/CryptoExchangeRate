 Делаем енв по подобию .env.example

    cp .env.example .env

Run:

    1.Docker, docker-compose and git are required

    2.Clone this repository to separate folder

    3.Execute ./run.sh in your terminal


1. Каждая валюта в приложении хранится как отдельная запись https://imgur.com/Xo8S08w.png

2. Каждая пара валют хранится как запись https://imgur.com/fz2uN8t.png

3. Команда по пути src/Command/GetCurrentRatesCommand.php парсит все созданные в БД пары валют и пишет в таблицу rate_history. Пример записей - https://imgur.com/lkNFBIW.png

4. При гипотетическом деплое необходимо устанавливает крону на каждый час.
Или проверить ее работу после запуска приложения, через команду 'php bin/console app:get-current-rates-command' введя в php контейнере(учитывая что мы создали хоть одну пару)


5. Имеется эндпоинт который собирает историю цены по паре и датам:

#[Route('/rate/history/{currencyPairId}', name: 'app_rate_history', methods: ['GET'])] . Вот пример получения: https://imgur.com/zIKWFIw.png

6. Коллекцию постмана с запросом положу в корень проекта
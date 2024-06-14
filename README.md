# Запуск проекта

1. Поднимите контейнеры в docker:

```
docker-compose up -d
```

2. Войдите в контейнер calculator-app

```
docker-compose exec calculator-app bash 
```

3. Установить зависимости

```
composer install
```

4. Запуск тестов
```
./bin/phpunit
```

### Проект будет доступен по адресу:

http://localhost:8080/

Для расчетов метод 

POST http://localhost:8080/сalculate

Пример запроса

```
{
    "cost": 10000,
    "birthDate": "01.02.2022",
    "tripDate": "01.05.2027",
    "paymentDate": "26.11.2026"
}
```

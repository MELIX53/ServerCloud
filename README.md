# Серверное Облако

> Демонстрация знаний (*Временно публичный проект*)

**Для игрокового сервера Minecraft Bedrock *[Dygers](https://dygers.fun/telegram)***

## Описание
В поисках дешевого решения подключить Облаков к Архиву наказаний, я пришел к выводу что лучшим вариантом будет орендовать в **OVH** ВДС 2ТБ всего за 8$

После был реализован не сложный скрипт для загрузки файлов на это импровизированное облако

## Безопастность
Небыло лучшего варианта защитить Сервер от сторонних загрузок кроме как установить белый список IP Адресов, которым разрешено делать это.

## Настройка
Список IP Адресов и домменное имя ответа Сервера устанавливается в константах **config.php**

## Примеры запросов к Облаку

```php
    //Пример передачи файлов на Сервер
    $uploadUrl = 'http://cloud.dygers.fun/upload.php';

    $files = [
        __DIR__ . '/img1.jpg',
        __DIR__ . '/img2.jpg'
    ];

    $CURLFiles = [];
    foreach ($files as $file){
        $CURLFiles[] = new CURLFile($file);
    }

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $uploadUrl);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: multipart/form-data"]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $CURLFiles);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_exec($ch);
    curl_close($ch);
```

```php
    //Пример удаления файлов с Сервера
    $removeUrl = 'http://cloud.dygers.fun/remove.php';

    $data = [
        'img1.jpg'
    ];

    $ch = curl_init($removeUrl);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_exec($ch);
    curl_close($ch);
```
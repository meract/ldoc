# Ldoc - Modern PHP Documentation Generator
## Доступные опции:

-i, --input	Исходная директория	./

-o, --output	Выходная директория	./docs

-t, --title	Заголовок документации	Project Documentation

-e, --exclude	Исключаемые директории (через запятую)	vendor,tests,node_modules

-h, --help	Показать справку	

-v, --version	Показать версию


## Пример
```
./ldoc --input=src --output=docs --title="My Project"
```
## Сборка
```
git clone https://github.com/meract/ldoc.git
cd ldoc
composer install
php build.php
```
У вас должны быть включены и настроены расширения для phar

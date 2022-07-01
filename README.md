## Installation
git clone

composer install

permission sur les répertoires
``chmod -R 775 storage``

``chmod -R 775 bootstrap/cache``

compléter le .env

poser le fichier creds.json
poser le fichier storage/app/indicateurs-qualiopi-seeder.csv

php artisan project:fresh_db

le cas échéant pour créer l'arborescence dans le fileSystem

## Ajout de permissions
ajouter la nouvelle permission dans PermissionServiceProvider
puis pour se les ajouter à soi
php artisan orchid:admin --id=monIdInt

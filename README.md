# Qleiade

![author](https://img.shields.io/badge/Author-Claude%20Agier-blue)
![filesystem](https://img.shields.io/badge/Filesystem-google%20drive-blueviolet)
![orchid](public/vendor/orchid/favicon.svg)

## liens utiles

Documentation Orchid admin panel : https://orchid.software/en/docs/   
Documentation de google drive adapter : https://github.com/nao-pon/flysystem-google-drive  

## Installation

```Shell
    git clone
```

```Shell
    composer install  
```
permission sur les répertoires

```Shell
    chmod -R 775 storage
    chmod -R 775 bootstrap/cache
``` 

Les assets
```Shell
    npm install
    npm run [environnement]
```
compléter le .env  

poser le fichier creds.json  
poser le fichier storage/app/indicateurs-qualiopi-seeder.csv  

Le projet contient IDE Helper pour faciliter la vie du correcteur syntaxique

```Shell
    php artisan ide-helper:generate
```

Création de la db
```Shell
    php artisan project:fresh_db
```
le cas échéant pour créer l'arborescence dans le fileSystem
```Shell
    php artisan project:init_storage
```
## Quelques tips

### Pour visualiser la doc ainsi que l'avancement du développement

j'utilise le paquage VScode :  
``TODO TREE``: https://marketplace.visualstudio.com/items?itemName=Gruntfuggly.todo-tree

Voici la config à coller dans settings.json (ctrl+shift+p Preferences open settings (JSON))

```json
    "todo-tree.general.statusBar": "tags",
    "todo-tree.general.tags": [
        "BUG",
        "HACK",
        "FIXME",
        "FIXIT",
        "TODO",
        "NEW_FORM",
        "[ ]",
        "[x]",
        "DOC"
    ],
    "todo-tree.highlights.useColourScheme": true,
    "todo-tree.general.tagGroups": {
        "FIXME": [
            "FIXME",
            "FIXIT",
            "FIX",
        ],
        "DOC":[
            "DOC"
        ]
    },
    "todo-tree.highlights.customHighlight": {
        "TODO": {
            "type":"tag",
            "icon": "check",
            "iconColour": "yellow",
            "foreground": "grey",
            "background": "yellow"
        },
        "FIXME": {
            "type":"tag",
            "iconColour": "orange",
            "gutterIcon": true,
            "foreground": "grey",
            "background": "orange",
            "opacity": 0
        },
        "DOC": {
            "type": "text-and-comment",
            "icon": "book",
            "iconColour": "green",
            "gutterIcon": true,
            "foreground": "green",
            "background": "none",
            "opacity": 150
        },

        "NEW_FORM": {
            "type": "text-and-comment",
            "icon": "book",
            "iconColour": "green",
            "gutterIcon": true,
            "foreground": "green",
            "background": "none",
            "opacity": 150
        }
    }
```

### Ajout de permissions

Ajouter la nouvelle permission dans PermissionServiceProvider  
  
puis pour se les ajouter à soi
```php
php artisan orchid:admin --id=monIdInt

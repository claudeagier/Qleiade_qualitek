# Qleiade

## Installation

git clone

composer install

permission sur les répertoires
```Shell
chmod -R 775 storage
chmod -R 775 bootstrap/cache
npm install
npm run [environnement]
``` 


compléter le .env

poser le fichier creds.json
poser le fichier storage/app/indicateurs-qualiopi-seeder.csv

```Shell
php artisan project:fresh_db
```
le cas échéant pour créer l'arborescence dans le fileSystem


## Ajout de permissions

ajouter la nouvelle permission dans PermissionServiceProvider
puis pour se les ajouter à soi
php artisan orchid:admin --id=monIdInt

## Pour visualiser la doc ainsi que l'avancement du développement
j'utilise le paquage VS CODE TODO TREE

Voici la config à mettre dans config.json (ctrl+shift+p open settings)

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


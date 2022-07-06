# Qleiade

  ![author](https://img.shields.io/badge/Author-Claude%20Agier-blue)
  ![filesystem](https://img.shields.io/badge/Filesystem-google%20drive-blueviolet)
  ![orchid](https://img.shields.io/badge/Orchid--Platform-V.11.0.1-green)

## liens utiles

- Documentation Orchid admin panel : https://orchid.software/en/docs

- Documentation de google drive adapter : https://github.com/nao-pon/flysystem-google-drive  

## Installation

```Shell
    git clone
```

```Shell
    composer install  
```
  
- permission sur les répertoires

```Shell
    chmod -R 775 storage
    chmod -R 775 bootstrap/cache
```

- compléter le .env  

- Google drive Api

  - créer un compte de service google drive api  

      Suivre la doc : https://support.google.com/a/answer/7378726?hl=fr

  - générer un fichier json avec les informations de connection

    - renommer le fichier en creds.json
    - déposer le fichier à la racine du projet
  
- Installer et compiler les assets
  
```Shell
    npm install
    npm run [environnement]
```

- IDE Helper pour faciliter la vie du correcteur syntaxique

    lancer la commande suivante pour générer le fichier de mapping _ide_helper.php

```Shell
    php artisan ide-helper:generate
```

- Création de la db  

```Shell
    php artisan project:fresh_db
```

> **Warning**  
> Attention, la commande va supprimer tous les enregistrements de la db !  
    Faire un dump de la db avant

- Le cas échéant pour créer l'arborescence dans le FileSystem
  
```Shell
    php artisan project:init_storage
```

> **Note**  
> Cette commande va générer des répertoires dans google drive à partir des noms de processus de la base de donnée.  
> On peut choisir de supprimer les répertoires existants ou non , ainsi que générer le répertoire d'archivage.

>**Warning**
> Lorsque le répertoire existe, un nouveau répertoire est créé avec le même nom.

## Quelques tips

### Todo tree  
  
Pour visualiser la doc ainsi que l'avancement du développement, j'utilise le paquage VScode :  
  
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

### Permissions

Ajouter la nouvelle permission dans PermissionServiceProvider  
  
puis pour se les ajouter à soi
  
```php
php artisan orchid:admin --id=monIdInt

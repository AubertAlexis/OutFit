# Outfit

Projet ecommerce afin d'apprendre Symfony

#### Technologie
PHP 8
Symfony 5
Composer 2
MySql

____
## Installation

Cloner le repository:

`git clone https://github.com/AubertAlexis/outfit && cd outfit`

Installer les dépendances:

`composer install`


Créer un fichier `.env.dev.local`:

`touch .env.dev.local`

_Dans ce fichier, mettre vos accès SQL_

---

Créer la database et setup les tables/fixtures:

`composer prepare`

____

## Démarrage

Lancer le serveur symfony:
`symfony serve`

### Inititalisation du projet 

Pour le gestionnaire de dépendance (composer) :
```
brew install composer
```
Pour installer CLI :
```
brew install brew install symfony-cli/tap/symfony-cli
```
Pour créer un projet :
```
symfony new --webapp your_name_project
```
Regarder les caractéristiques (version, ..) du projet :
```
symfony console about
```
Creer un base de donnée avec doctrine :
``` 
symfony console doctrine:database:create  
```

Install all depencies 
```
composer require --dev doctrine/doctrine-fixtures-bundle
composer require vich/uploader-bundle
composer require knplabs/knp-paginator-bundle
```

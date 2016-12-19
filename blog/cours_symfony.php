symfony
//	Symfony Installer (1.5.0)
composer
//	Composer version 1.0-dev

// Créer un répertoire, par exemple : sites/dev/symfony
// Puis
cd sites/dev/symfony

symfony new blog

// http://localhost/dev/symfony/blog/web/app_dev.php

cd blog

php bin/console
php bin/console generate:bundle

BlogBundle

// http://192.168.1.95/dev/symfony/liens.html

// Créer dans votre bundle les répertoires :
// Resources/public/css
// Resources/public/js
// Resources/public/images
// etc...

// Puis
php bin/console assets:install --symlink

// Ensuite dans votre base.html.twig :
<link rel="stylesheet" type="text/css" href="{{ asset('bundles/blog/css/style.css') }}">

// Pour les liens entre vos pages :
<a href="{{ path('blog_homepage') }}">Accueil</a>
// a la place de blog_homepage => le nom de la route dans routing.yml

<a href="{{ path('display_article_id', {id:article.id}) }}">Article</a>

// Les entitées => Entity
http://symfony.com/doc/current/book/doctrine.html

php bin/console doctrine:database:create

php bin/console doctrine:generate:entity

php bin/console doctrine:schema:update --force

// http://192.168.1.95/dev/symfony/BlogBundle.tar
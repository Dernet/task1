<?php

return array(
    // Пользователь:
    'user/login' => 'user/login', // actionLogin в UserController
    'user/logout' => 'user/logout', // actionLogout в UserController

    // Управление задачами:  
    'admin/items/update/([0-9]+)' => 'items/update/$1', // actionUpdate в ItemsController

    // Item
    'items/create' => 'items/create', // actionCreate в ItemsController
    
    // Главная страница
    'index.php/([a-z]+)/([a-z]+)/page-([0-9]+)' => 'site/index/$1/$2/$3', // actionIndex в SiteController
    '([a-z]+)/([a-z]+)/page-([0-9]+)' => 'site/index/$1/$2/$3', // actionIndex в SiteController
    
    'index.php/([a-z]+)/([a-z]+)' => 'site/index/$1/$2', // actionIndex в SiteController
    '([a-z]+)/([a-z]+)' => 'site/index/$1/$2', // actionIndex в SiteController

    'index.php' => 'site/index', // actionIndex в SiteController
    '' => 'site/index', // actionIndex в SiteController
);
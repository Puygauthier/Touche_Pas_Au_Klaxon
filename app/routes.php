<?php
// On utilise l'instance $router créée dans public/index.php

// Accueil
$router->get('/', 'HomeController@index');

// Auth (GET pour afficher le form, POST pour soumettre)
$router->get('/auth/login',  'AuthController@login');
$router->post('/auth/login', 'AuthController@login');
$router->get('/auth/logout', 'AuthController@logout');

// Utilisateurs
$router->get('/users', 'UserController@index');
$router->get('/users/show/{id}', 'UserController@show');

// Agences
$router->get('/agences', 'AgenceController@index');
$router->get('/agences/show/{id}', 'AgenceController@show');

// Trajets
$router->get('/trajets', 'TrajetController@index');
$router->get('/trajets/show/{id}', 'TrajetController@show');
$router->get('/trajets/create', 'TrajetController@createForm'); // formulaire de création
$router->get('/trajets/edit/{id}', 'TrajetController@edit');
$router->post('/trajets/create', 'TrajetController@create');
$router->post('/trajets/update/{id}', 'TrajetController@update');
$router->post('/trajets/delete/{id}', 'TrajetController@delete');

// Admin
$router->get('/admin/dashboard', 'AdminController@dashboard');

// Agences (admin-only pour ces actions)
$router->get('/agences/create', 'AgenceController@createForm');
$router->post('/agences/create', 'AgenceController@create');
$router->get('/agences/edit/{id}', 'AgenceController@edit');
$router->post('/agences/update/{id}', 'AgenceController@update');
$router->post('/agences/delete/{id}', 'AgenceController@delete');

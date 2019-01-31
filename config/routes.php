<?php

return [
    'index.index' => [
        'uri' => null,
        'method' => 'GET',
        'action' => 'IndexController@index'
    ],
    'index.tests' => [
        'uri' => '/api/tests',
        'method' => 'GET',
        'action' => 'IndexController@tests'
    ]
];

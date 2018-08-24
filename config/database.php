<?php
/*
	Author:  Drew D. Lenhart
	Page: database.php *Default database
	Desc: Database connection info.
*/

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;

$capsule->addConnection(
    array(
		'driver'    => 'mysql',
		'host'      => 'DB_HOST',
		'database'  => 'DB_NAME',
		'username'  => 'DB_USER',
		'password'  => 'DB_PASSWORD',
		'prefix'    => '',
    ),
	"default"
);

$capsule->addConnection(
    array(
		'driver'   => 'sqlite',
		'database' => __DIR__ . '/../data/sample.sqlite',
		'prefix'   => ''
    ),
	"sqlite"
);

$capsule->bootEloquent();
$capsule->setAsGlobal();

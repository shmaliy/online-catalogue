<?php
require_once 'Zend/Db.php';
/* Конфигурационный файл */
$config = array();

/* Пространство имен приложения */
$config['appnamespace'] = 'Application';

/* Настройки ядра PHP */
$config['phpSettings'] = array(
    'display_startup_errors' => 1,
    'display_errors' => 1,
    'date.timezone' => "Europe/Kiev"
);

/* Настройки загрузочного класса */
$config['bootstrap'] = array(
    'path' => ROOT_PATH . '/application/Bootstrap.php',
    'class' => 'Bootstrap'
);

/* Настройки ресайзера */
$config['IMAGE_CACHE_LIFETIME'] = 24 * 60 * 60;

/* Настройки ресурсов */
$config['resources'] = array();

$config['resources']['frontController'] = array(
	'controllerDirectory' => ROOT_PATH . '/application/controllers',
	'params' => array(
		//'displayExceptions' => 1
	),
	'moduleDirectory' => ROOT_PATH . '/application/modules',
);

/* Необходимо для включения модульности (устанавливает пути) */
$config['resources']['modules'] = array();

/* Настройки корневого шаблона (устанавливает пути, имени файла, типа файла) */
$config['resources']['layout'] = array(
	'layoutPath' => ROOT_PATH . '/application/layouts/scripts/',
	'layout' => 'layout',
	'viewSuffix' => 'php3'
);

/* Настройки шаблонизатора */
$config['resources']['view'] = array(
	'encoding' => 'windows-1251',
	'doctype'  => 'XHTML1_TRANSITIONAL',
	'charset' => 'windows-1251',
	'contentType' => 'text/html; charset=windows-1251',
);

/* Настройки баз данных */
$config['resources']['db'] = array();

include_once '../public/cms/db.php';
$config['resources']['db']['sound'] = array(
	'adapter' => 'PDO_MYSQL',
	'params' => array(
		'dbname'   => $cms_config_db,
		'host'     => $cms_config_host,
		'username' => $cms_config_user, 
		'password' => $cms_config_password,
		'profiler' => true,
   		'driver_options' => array(
   			PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES cp1251'
   		)
    )
);

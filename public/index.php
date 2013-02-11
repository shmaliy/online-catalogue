<?php

/* �������� ������� */
if (!defined('ROOT_PATH')) {
	define('ROOT_PATH', realpath(dirname(dirname(__FILE__))));
}

/* ������� ���������� */
if (!defined('APPLICATION_PATH')) {
	define('APPLICATION_PATH', ROOT_PATH . '/application');
}

/* Define ZEND library(s) */
if (!defined('LIBRARY_PATH')) {
	if (file_exists(realpath(ROOT_PATH . '/../..') . '/phpLibs')) {
		$libraryPath[] = realpath(ROOT_PATH . '/../..') . '/phpLibs';
	}
	
	if (file_exists(realpath(ROOT_PATH . '/../..') . '/Zend_Framework')) {
		$libraryPath[] = realpath(ROOT_PATH . '/../..') . '/Zend_Framework';
	}
	if (file_exists(realpath(ROOT_PATH . '/..') . '/ZEND')) {
		$libraryPath[] = realpath(ROOT_PATH . '/..') . '/ZEND';
	}
	
	$libraryPath[] = ROOT_PATH . '/library';
	define('LIBRARY_PATH', implode(PATH_SEPARATOR, $libraryPath));
	unset($libraryPath);
}

/* ������� �������� ��������� ������ */
if (!defined('PUBLIC_PATH')) {
	define('PUBLIC_PATH', ROOT_PATH . '/public');
}

/* ��������� ����� */
if (!defined('APPLICATION_ENV')) {
    define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));
}

/* ��������� � include_path ����� ��������� */
set_include_path(
	implode(PATH_SEPARATOR, 
		array(
    		LIBRARY_PATH,
    		get_include_path(),
    	)
    )
);

/* ����������� ����� �������� */
require_once APPLICATION_PATH . '/configs/config.php';

/* ����������� Zend_Application */
require_once 'Zend/Application.php';

// �������� ������� ���������� � ������
$application = new Zend_Application(
    APPLICATION_ENV,
    $config
);
$application->bootstrap()->run();

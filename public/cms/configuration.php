<?php
session_start();

if (!defined(BASEDIR)){
	define(BASEDIR, str_replace($_SERVER['DOCUMENT_ROOT'], '', str_replace("\\", '/', getcwd())));
}
if (!defined(TPLDIR)){
	define(TPLDIR, 'tpl/');
}

date_default_timezone_set('Europe/Helsinki');

if (!$_SESSION['cms']['menudisable']){ $_SESSION['cms']['menudisable'] = 0; }
if (!$_SESSION['cms']['message']){ $_SESSION['cms']['message'] = ''; }
if (!$_SESSION['cms']['fp']){ $_SESSION['cms']['fp'] = 'true'; }
if (!$_SESSION['cms']['fb']['path']){ $_SESSION['cms']['fb']['path'] = '../contents'; }
if (!$_SESSION['cms']['fb']['mode']){ $_SESSION['cms']['fb']['mode'] = 'filebrowser_l'; }
if (!$_SESSION['cms']['fb']['return']){ $_SESSION['cms']['fb']['return'] = ''; }
$usertypes = array(
	0  => '���',
	10 => '�����-����� �������������',
	11 => '�������������',
	12 => '��������',
	20 => '����������',
	21 => '��������',
	22 => '�����',
	23 => '�����������������'
);

$rownums = explode(',', '5,10,15,20,25,30,50,all');
$demo = false;
// XAJAX
require_once ("xajax/xajax_core/xajax.inc.php");
$xajax = new xajax("/cms/bridge.php");
//$xajax->configure('debug', true);
//$xajax->configure('responseQueueSize', 200000);
$xajax->configure('javascript URI','/cms/xajax');
$xajax->setCharEncoding('windows-1251'); 
$xajax->configure("decodeUTF8Input", true);

//  ����������� � ��
if (file_exists('db.php')){
	require ('db.php');
	@mysql_connect($cms_config_host, $cms_config_user, $cms_config_password);
	mysql_select_db($cms_config_db);
	mysql_query('SET NAMES cp1251');
	//setlocale (LC_TIME, $cms_config_locale);
}
//	������ ���������� ���
Error_Reporting(E_ALL & ~E_NOTICE);
//Error_Reporting(E_ALL);

//	������� URL
$url = $_SERVER['REQUEST_URI'];
// ������� ����� �� ������ � ����� ������
if(stripos($url, '/') == 0){$url = substr($url, 1, strlen($url));}
if(stripos($url, '/') == strlen($url)-1){$url = substr($url, 0, strlen($url)-1);}
$url_query = explode("/", $url);

include ('modules/core/core_tpl.php');
include ('modules/core/core_xml.php');
include ('modules/core/core.php');
?>
<?php
defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);
define('SITE_ROOT', $_SERVER['DOCUMENT_ROOT'] . DS . 'gallery');
defined('INCLUDES_PATH') ? null : define('INCLUDES_PATH', SITE_ROOT . DS . 'admin' . DS . 'includes');

require_once(dirname(__FILE__) . "/functions.php");
require_once(dirname(__FILE__) . "/config.php");
require_once(dirname(__FILE__) . "/database.php");
require_once(dirname(__FILE__) . "/db_object.php");
require_once(dirname(__FILE__) . "/user.php");
require_once(dirname(__FILE__) . "/photo.php");
require_once(dirname(__FILE__) . "/comment.php");
require_once(dirname(__FILE__) . "/session.php");
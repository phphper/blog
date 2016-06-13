<?php
namespace core;
session_start();
class Application
{
   public static $config;

   public static function run()
   {
      self::_setPhpErrorDisplayAndErrorReport();

      self::_initialCharset();

      self::_defineDirConst();

      self::_loadConfigFile();

      self::_parseUrlParams();

      self::_registerAutoload();

      self::_dispatchRoute();
   }

   protected static function _setPhpErrorDisplayAndErrorReport()
   {
      ini_set('display_error', 'On');
      error_reporting(E_ALL);
   }

   protected static function _initialCharset()
   {
      header('Content-Type:text/html;Charset=utf-8');
   }

   protected static function _defineDirConst()
   {
      define('DS', DIRECTORY_SEPARATOR);
      define('ROOT_PATH', dirname(__DIR__));
      define('APP_PATH', ROOT_PATH . DS . 'app');
      define('VIEW_PATH', APP_PATH . DS . 'view');
      define('CONFIG_PATH', APP_PATH . DS . 'config');
   }

   protected static function _loadConfigFile()
   {
      require CONFIG_PATH . DS . 'config.php';
      self::$config = $config;
   }

   protected static function _parseUrlParams()
   {
      $a = isset($_GET['a']) ? $_GET['a'] : 'getList';
      $p = isset($_GET['p']) ? $_GET['p'] : 'frontend';
      $c = isset($_GET['c']) ? $_GET['c'] : 'article';

      define('ACTION', $a);
      define('CONTROLLER', $c);
      define('PLATFROM', $p);
   }

   protected static function _registerAutoload()
   {
      spl_autoload_register(function ($className) {
         $fileName =  str_replace('\\', DS ,ROOT_PATH . DS . $className . '.php');
         if (is_file($fileName)) {
            require $fileName;
         }
      });
   }
   protected static function _dispatchRoute()
   {
      $a = ACTION;
      $c = '\\app\\controller\\' . PLATFROM . '\\' . CONTROLLER . 'Controller';
      $ctrl = new $c();
      $ctrl->$a();
   }

}

<?php
 if (!defined('IN_CKFINDER')) exit; class CKFinder_Connector_Core_Factory { static $instances = array(); static function initFactory() { } public static function &getInstance($className) { $namespace = "CKFinder_Connector_"; $baseName = str_replace($namespace,"",$className); $className = $namespace.$baseName; if (!isset(CKFinder_Connector_Core_Factory::$instances[$className])) { require_once CKFINDER_CONNECTOR_LIB_DIR . "/" . str_replace("_","/",$baseName).".php"; CKFinder_Connector_Core_Factory::$instances[$className] = new $className; } return CKFinder_Connector_Core_Factory::$instances[$className]; } } 
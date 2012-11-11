<?php
namespace TYPO3\ParserApi;
/*                                                                        *
 * This script belongs to the Flow package "TYPO3.PackageBuilder".        *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License, either version 3   *
 * of the License, or (at your option) any later version.                 *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

/**
 * @package  PhpParserApi
 * @author Nico de Haen
 */



class AutoLoader {

	static public $autoloadRegistry;

	/**
    * Registers \PHPParser_Autoloader as an SPL autoloader.
    */
    static public function register(){
        ini_set('unserialize_callback_func', 'spl_autoload_call');
        spl_autoload_register(array(__CLASS__, 'autoload'), TRUE, TRUE);
    }

    /**
    * Handles autoloading of classes.
    *
    * @param string $class A class name.
    */
    static public function autoload($class){
		if(0 === strpos($class, '\\TYPO3\\ParserApi')) {
			$file = dirname(__FILE__) . '/'  . strtr(str_replace('TYPO3\\ParserApi', '', $class), '\\', '/') . '.php';
			if (is_file($file)) {
				require $file;
			}
		} elseif(0 === strpos($class, 'PHPParser_')) {
			$file =  str_replace('Classes/TYPO3/ParserApi', '', dirname(__FILE__)) . 'Resources/Private/PHP/PHP-Parser/lib/'  . strtr($class, '_', '/') . '.php';
			if (is_file($file)) {
				require $file;
			}
		}
    }
}


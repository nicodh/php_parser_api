<?php
namespace TYPO3\ParserApi;
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012 Nico de Haen <mail@ndh-websolutions.de>
 *  All rights reserved
 *
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

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
        spl_autoload_register(array(__CLASS__, 'autoload'));
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
			$file =  str_replace('Classes', '', dirname(__FILE__)) . 'Resources/Private/PHP/PHP-Parser/lib/'  . strtr($class, '_', '/') . '.php';
			if (is_file($file)) {
				require $file;
			}
		}
    }
}


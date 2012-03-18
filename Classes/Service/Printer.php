<?php
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
* @package
* @author Nico de Haen
*/


/**
* provides methods to import a class object
*
* @package Classparser
* @version $ID:$
*/
class Tx_Classparser_Service_Printer implements t3lib_singleton {

	/**
	 * @var Tx_Extbase_Configuration_ConfigurationManager
	 */
	protected $configurationManager;

	/**
	 * @param Tx_Extbase_Configuration_ConfigurationManager $configurationManager
	 * @return void
	 */
	public function injectConfigurationManager(Tx_Extbase_Configuration_ConfigurationManager $configurationManager) {
		$this->configurationManager = $configurationManager;
	}

	/**
	 * @param Tx_Classparser_Domain_Model_Class $classObject
	 */
	public function toString(Tx_Classparser_Domain_Model_Class $classObject) {
		$view = new Tx_Fluid_View_StandaloneView;
		$view->setFormat('text');
		//$extbaseFrameworkConfiguration = $this->configurationManager->getConfiguration(Tx_Extbase_Configuration_ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
		//return $extbaseFrameworkConfiguration;
		$templateRootPath = t3lib_div::getFileAbsFileName('EXT:classparser/Resources/Private/Templates/');
		$templatePathAndFilename = $templateRootPath . 'Class.phpt';
		$view->setTemplatePathAndFilename($templatePathAndFilename);
		//$view->setLayoutRootPath(t3lib_div::getFileAbsFileName($extbaseFrameworkConfiguration['view']['layoutRootPath']));
		$view->setPartialRootPath(t3lib_div::getFileAbsFileName('EXT:classparser/Resources/Private/Partials/'));
		$view->assign('classObject',$classObject);
		$sourceCode = $view->render();
		return $sourceCode;
	}
}

?>
<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

require_once(t3lib_extMgm::extPath('php_parser') . 'Classes/TYPO3AutoLoader.php');
Tx_PhpParser_Utility_TYPO3AutoLoader::register();
?>
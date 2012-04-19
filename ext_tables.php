<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

require_once(t3lib_extMgm::extPath('php_parser') . 'Classes/Utility/AutoLoader.php');
Tx_PhpParser_Utility_AutoLoader::register();
?>
<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

require_once(t3lib_extMgm::extPath('php_parser_api') . 'Classes/AutoLoader.php');
Tx_PhpParser_AutoLoader::register();
?>
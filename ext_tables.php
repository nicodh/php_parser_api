<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

require_once(t3lib_extMgm::extPath('classparser') . 'Classes/Utility/AutoLoader.php');
Tx_Classparser_Utility_AutoLoader::register();
?>
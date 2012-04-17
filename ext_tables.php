<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Class Parser');

require_once(t3lib_extMgm::extPath('classparser') . 'Classes/Utility/AutoLoader.php');
Tx_Classparser_Utility_AutoLoader::register();
?>
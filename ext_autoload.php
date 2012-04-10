<?php
$extensionClassesPath = t3lib_extMgm::extPath('classparser') . 'Classes/';

$default = array(
	'Tx_Classparser_Service_Printer' => $extensionClassesPath . 'Service/Printer.php',
	'Tx_Classparser_Service_Parser' => $extensionClassesPath . 'Service/Parser.php',
);
return $default;

?>
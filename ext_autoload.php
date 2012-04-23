<?php
$extensionClassesPath = t3lib_extMgm::extPath('php_parser_api') . 'Classes/';

$default = array(
	'Tx_PhpParser_Service_Printer' => $extensionClassesPath . 'Service/Printer.php',
	'Tx_PhpParser_Service_Parser' => $extensionClassesPath . 'Service/Parser.php',
);
return $default;

?>
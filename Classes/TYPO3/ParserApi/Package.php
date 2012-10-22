<?php
namespace TYPO3\ParserApi;

use TYPO3\Flow\Package\Package as BasePackage;
use TYPO3\Flow\Annotations as Flow;


/**
 * Package base class of the ParserApi package.
 *
 * @Flow\Scope("singleton")
 */
class Package extends BasePackage {
	/**
	 * Invokes custom PHP code directly after the package manager has been initialized.
	 *
	 * @param \TYPO3\Flow\Core\Bootstrap $bootstrap The current bootstrap
	 * @return void
	 */
	public function boot(\TYPO3\Flow\Core\Bootstrap $bootstrap) {
		if(!class_exists('PHPParser_Parser')) {
			AutoLoader::register();
			//include_once($this->getResourcesPath() . '/Private/PHP/PHP-Parser/lib/bootstrap.php');
		}
	}
}
?>
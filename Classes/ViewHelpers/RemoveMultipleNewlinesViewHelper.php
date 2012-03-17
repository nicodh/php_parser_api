<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012 Nico de Haen
 *  All rights reserved
 *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License as published by the *
 * Free Software Foundation, either version 3 of the License, or (at your *
 * option) any later version.                                             *
 *                                                                        *
 * This script is distributed in the hope that it will be useful, but     *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser       *
 * General Public License for more details.                               *
 *                                                                        *
 * You should have received a copy of the GNU Lesser General Public       *
 * License along with the script.                                         *
 * If not, see http://www.gnu.org/licenses/lgpl.html                      *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

/**
 * Removes all linebreaks
 *
 * @version $Id: $
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 * @scope prototype
 */
class Tx_Classparser_ViewHelpers_Format_RemoveMultipleNewlinesViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

	/**
	 * Uppercase first character
	 *
	 * @return string The altered string.
	 */
	public function render() {
		$content = trim($this->renderChildren());

		// Collapse whitespace lines
		$content = preg_replace('/^\s+$/m', '', $content);
		$content = preg_replace("/\n\n+/", "\n", $content);

		return $content;
	}
}

?>
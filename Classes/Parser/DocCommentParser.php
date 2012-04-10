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

class Tx_Classparser_Parser_DocCommentParser extends Tx_Extbase_Reflection_DocCommentParser{

	public function parse($docComment) {
		parent::parseDocComment($docComment);
		return $this->tags;
	}

	public function getTags() {
		return $this->tags;
	}

	public function renderDocComment($tags, $description) {
		$docComment = '/**' . LF;
		$docComment .= ' * ' . implode(LF . ' * ', t3lib_div::trimExplode(LF,$description, TRUE));
		$docComment .= LF . ' *' . LF;
		$annotations = array();
		$tagNames = array_keys($tags);
		foreach ($tagNames as $tagName) {
			if (empty($tags[$tagName])) {
				$annotations[] = $tagName;
			}
			if (is_array($tags[$tagName])) {
				foreach ($tags[$tagName] as $tagValue) {
					$annotations[] = $tagName . ' ' . $tagValue;
				}
			}
			else {
				$annotations[] = $tagName . ' ' . $tags[$tagName];
			}
		}
		foreach($annotations as $annotation) {
			$docComment .= ' * @'.$annotation . LF;
		}
		$docComment .= '*/' . LF;
		return $docComment;
	}
}

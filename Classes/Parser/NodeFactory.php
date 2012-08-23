<?php
namespace TYPO3\ParserApi\Parser;
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
 * @package  PhpParserApi
 * @author Nico de Haen
 */

class NodeFactory {

	/**
	 * @static
	 * @param $name
	 * @return \PHPParser_Node_Stmt_Class
	 */
	static public function buildClassNode($name) {
		return new \PHPParser_Node_Stmt_Class($name);
	}


	/**
	 * @static
	 * @param $name
	 * @return \PHPParser_Node_Stmt_Namespace
	 */
	static public function buildNamespaceNode($name) {
		return new \PHPParser_Node_Stmt_Namespace(new \PHPParser_Node_Name($name));
	}


	/**
	 * @static
	 * @param $name
	 * @return \PHPParser_Node_Stmt_Property
	 */
	static public function buildPropertyNode($name) {
		return new \PHPParser_Node_Stmt_Property(2, array(new \PHPParser_Node_Stmt_PropertyProperty($name)));
	}


	/**
	 * @static
	 * @param string $name
	 * @param mixed $value
	 * @return \PHPParser_Node_Const
	 */
	public static function buildConstantNode($name, $value) {
		$constantNode = new \PHPParser_Node_Const($name, self::buildNodeFromValue($value));
		return $constantNode;
	}

	/**
	 * @static
	 * @param string $name
	 * @param mixed $value
	 * @return \PHPParser_Node_Const
	 */
	public static function buildClassConstantNode($name, $value) {
		$constantNode = new \PHPParser_Node_Stmt_ClassConst(array(new \PHPParser_Node_Const($name, self::buildNodeFromValue($value))));
		return $constantNode;
	}


	/**
	 * Normalizes a value: Converts nulls, booleans, integers,
	 * floats and strings into their respective nodes
	 *
	 * @param mixed $value The value to normalize
	 *
	 * @return \PHPParser_Node_Expr The normalized value
	 */
	static public  function buildNodeFromValue($value) {
		if ($value instanceof \PHPParser_Node) {
			return $value;
		} elseif (is_null($value)) {
			return new \PHPParser_Node_Expr_ConstFetch(
				new \PHPParser_Node_Name('null')
			);
		} elseif (is_bool($value)) {
			return new \PHPParser_Node_Expr_ConstFetch(
				new \PHPParser_Node_Name($value ? 'true' : 'false')
			);
		} elseif (is_int($value)) {
			return new \PHPParser_Node_Scalar_LNumber($value);
		} elseif (is_float($value)) {
			return new \PHPParser_Node_Scalar_DNumber($value);
		} elseif (is_string($value)) {
			return new \PHPParser_Node_Scalar_String($value);
		} elseif (is_array($value)) {
			$items = array();
			$lastKey = -1;
			foreach ($value as $itemKey => $itemValue) {
				// for consecutive, numeric keys don't generate keys
				if (null !== $lastKey && ++$lastKey === $itemKey) {
					$items[] = new \PHPParser_Node_Expr_ArrayItem(
						self::buildNodeFromvalue($itemValue)
					);
				} else {
					$lastKey = null;
					$items[] = new \PHPParser_Node_Expr_ArrayItem(
						self::buildNodeFromvalue($itemValue),
						self::buildNodeFromvalue($itemKey)
					);
				}
			}
			return new \PHPParser_Node_Expr_Array($items);
		} else {
			throw new \TYPO3\ParserApi\Exception\SyntaxErrorException('Invalid value');
		}
	}

	/**
	 * Normalizes a name: Converts plain string names to \PHPParser_Node_Name.
	 *
	 * @param \PHPParser_Node_Name|string $name The name to normalize
	 *
	 * @return \PHPParser_Node_Name The normalized name
	 */
	static public function buildNodeFromName($name) {
		if ($name instanceof \PHPParser_Node_Name) {
			return $name;
		} else {
			return new \PHPParser_Node_Name($name);
		}
	}
}

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
 * @package  PhpParserApi
 * @author Nico de Haen
 */

class Tx_PhpParser_Parser_Utility_NodeConverter {


	public static $accessorModifiers = array(
		PHPParser_Node_Stmt_Class::MODIFIER_PUBLIC,
		PHPParser_Node_Stmt_Class::MODIFIER_PROTECTED,
		PHPParser_Node_Stmt_Class::MODIFIER_PRIVATE

	);

	public static function getTypeHintFromVarType ($varType) {
		if(in_array(strtolower($varType), array('integer', 'int', 'double', 'float', 'boolean', 'bool', 'string'))) {
			return '';
		} else {
			if(preg_match_all('/^[^a-zA-Z]|[^\w_]/',$varType,$matches) === 0) {
				// has to be an allowed classname or 'array'
				return $varType;
			}
			return '';
		}
	}


	/**
	 * @static
	 * @param int $modifiers
	 * @return array with names as strings
	 */
	public static function modifierToNames($modifiers) {
        $modifierString = ($modifiers & PHPParser_Node_Stmt_Class::MODIFIER_PUBLIC    ? 'public '    : '')
             . ($modifiers & PHPParser_Node_Stmt_Class::MODIFIER_PROTECTED ? 'protected ' : '')
             . ($modifiers & PHPParser_Node_Stmt_Class::MODIFIER_PRIVATE   ? 'private '   : '')
             . ($modifiers & PHPParser_Node_Stmt_Class::MODIFIER_STATIC    ? 'static '    : '')
             . ($modifiers & PHPParser_Node_Stmt_Class::MODIFIER_ABSTRACT  ? 'abstract '  : '')
             . ($modifiers & PHPParser_Node_Stmt_Class::MODIFIER_FINAL     ? 'final '     : '');
		return explode(' ',trim($modifierString));
    }


	/**
	 * Convert various PHPParser_Nodes to the value they represent
	 * //TODO: support more node types?
	 *
	 * @static
	 * @param $node
	 * @return array|null|string
	 */
	public static function getValueFromNode($node) {
		if($node instanceof PHPParser_Node_Stmt_Namespace) {
			return implode('\\',$node->getName()->getParts());
		} elseif($node instanceof PHPParser_Node_Name) {
			return implode(' ',$node->getParts());
		} elseif($node instanceof PHPParser_Node_Expr_ConstFetch) {
			return self::getValueFromNode($node->getName());
		} elseif($node instanceof PHPParser_Node_Expr_Array) {
			$value = array();
			$arrayItems = $node->getItems();
			foreach($arrayItems as $arrayItemNode) {
				$itemKey = $arrayItemNode->getKey();
				$itemValue = $arrayItemNode->getValue();
				if(is_null($itemKey)) {
					$value[] = self::getValueFromNode($itemValue);
				} else {
					$value[self::getValueFromNode($itemKey)] = self::getValueFromNode($itemValue);
				}
			}
			return $value;
		} elseif($node instanceof PHPParser_Node) {
			return $node->getValue();
		} else {
			return NULL;
		}
	}


	/**
	 * Constants consist of a simple key => value array in the API
	 * This methods converts  PHPParser_Node_Stmt_ClassConst or PHPParser_Node_Stmt_Const
	 *
	 * @static
	 * @param PHPParser_Node
	 * @return array
	 */
	public static function convertClassConstantNodeToArray(PHPParser_Node $node) {
		$constantsArray = array();
		$consts = $node->getConsts();
		foreach($consts as $const) {
			$constantsArray[] = array('name' => $const->getName(),'value' => self::getValueFromNode($const->getValue()));
		}
		return $constantsArray;
	}

	public static function getVarTypeFromValue($value) {
		if (is_null($value)) {
			return '';
		} elseif($value == 'FALSE' || $value == 'TRUE') {
			return 'boolean';
		} else {
			return gettype($value);
		}
	}


}

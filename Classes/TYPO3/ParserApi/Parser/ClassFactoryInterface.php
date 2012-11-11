<?php
namespace TYPO3\ParserApi\Parser;
/*                                                                        *
 * This script belongs to the Flow package "TYPO3.PackageBuilder".        *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License, either version 3   *
 * of the License, or (at your option) any later version.                 *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

/**
 * @package  PhpParserApi
 * @author Nico de Haen
 */

interface ClassFactoryInterface {

	public function buildClassObjectFromNode(\PHPParser_Node_Stmt_Class $node);

	public function buildClassMethodObjectFromNode(\PHPParser_Node_Stmt_ClassMethod $node);

	public function buildPropertyObjectFromNode(\PHPParser_Node_Stmt_Property $node);

	public function buildFunctionObjectFromNode(\PHPParser_Node_Stmt_Function $node);

	public function buildNamespaceObjectFromNode(\PHPParser_Node_Stmt_Namespace $node);
}

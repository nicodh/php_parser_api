<?php

class PHPParser_Tests_NodeAbstractTest extends PHPUnit_Framework_TestCase {

	public function testConstruct() {
		/** @var $node PHPParser_NodeAbstract */
		$node = $this->getMockForAbstractClass(
			'PHPParser_NodeAbstract',
			array(
				10,
				array(
					new PHPParser_Node_Ignorable_DocComment('/** doc comment */')
				)
			),
			'PHPParser_Node_Dummy'
		);

		$this->assertEquals('Dummy', $node->getNodeType());
		$this->assertEquals(10, $node->getLine());
		foreach ($node->getIgnorables() as $ignorable) {
			if ($ignorable instanceof PHPParser_Node_Ignorable_DocComment) {
				$this->assertEquals('/** doc comment */', $ignorable->getValue());
			}
		}
		return $node;
	}

	/**
	 * @depends testConstruct
	 */
	public function testChange(PHPParser_Node $node) {
		// change of line
		$node->setLine(15);
		$this->assertEquals(15, $node->getLine());

		// change of doc comment
		$node->setIgnorables(array(new PHPParser_Node_Ignorable_DocComment('/** other doc comment */')));
		$this->assertEquals('/** other doc comment */', current($node->getIgnorables())->toString(TRUE));

		// TODO rebuild this test
		// direct modification
//        $node->subNode = 'newValue';
//        $this->assertEquals('newValue', $node->subNode);

		// indirect modification
//        $subNode =& $node->subNode;
//        $subNode = 'newNewValue';
//        $this->assertEquals('newNewValue', $node->subNode);

		// removal
//        unset($node->subNode);
//        $this->assertFalse(isset($node->subNode));
	}
}
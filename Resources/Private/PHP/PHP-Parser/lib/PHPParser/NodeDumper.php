<?php

class PHPParser_NodeDumper {

	/**
	 * Dumps a node or array.
	 *
	 * @param array|PHPParser_Node $node Node or array to dump
	 *
	 * @return string Dumped value
	 */
	public function dump($node) {
		if ($node instanceof PHPParser_Node) {
			$r = $node->getNodeType() . '(';
		} elseif (is_array($node)) {
			$r = 'array(';
		} else {
			throw new InvalidArgumentException('Can only dump nodes and arrays.');
		}

		if ($node instanceof PHPParser_Node) {
			$array = array();
			foreach ($node->getSubNodeNames() as $name) {
				$array[$name] = $node->{'get' . ucfirst($name)}();
			}
		} else {
			$array = $node;
		}

		foreach ($array as $key => $value) {
			$r .= "\n" . '    ' . $key . ': ';

			if (NULL === $value) {
				$r .= 'null';
			} elseif (FALSE === $value) {
				$r .= 'false';
			} elseif (TRUE === $value) {
				$r .= 'true';
			} elseif (is_scalar($value)) {
				$r .= $value;
			} else {
				$r .= str_replace("\n", "\n" . '    ', $this->dump($value));
			}
		}

		return $r . "\n" . ')';
	}
}
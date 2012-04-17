<?php


/**
 * @package
 * @author Nico de Haen
 */

class Tx_Classparser_Tests_SimplePropertyTest {

    
    /**
     * @var string
     */
    protected $property;
    
    
    /**
     * @param string $property
     */
    function setProperty($property) {
        $this->property = $property;
    } 
    
    
    /**
     * @return string
     */
    function getProperty() {
        return $this->property;
    } 

}
?>
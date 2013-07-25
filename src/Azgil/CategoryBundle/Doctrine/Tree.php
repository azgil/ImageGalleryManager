<?php

namespace Azgil\CategoryBundle\Doctrine;

use Doctrine\ORM\EntityManager;

class Tree {
	
	function __construct(EntityManager $em) {
		$this->em = $em;
	}
	
	public function generateXML(){
		$cat_table = $this->em->getRepository('AzgilCategoryBundle:CategoryTree')->findBy(
			array('type'=> 1),array('path' => 'ASC'));
	}
	
	public function treeMaker(array $table, $seek){
		$result = '<ul>';
		$prev = '-';
		foreach ($table as $tag) {
			
		}
		$result .= '</ul>';
	}
}

?>

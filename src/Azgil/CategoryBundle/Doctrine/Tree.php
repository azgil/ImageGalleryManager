<?php

namespace Azgil\CategoryBundle\Doctrine;

use Doctrine\ORM\EntityManager;

class Tree {
	private $em;
	function __construct(EntityManager $em) {
		$this->em = $em;
	}
	
	public function generateTree($type){		
		$cat_table = $this->em->getRepository('AzgilCategoryBundle:CategoryTree')->findAllJoinedToCategoryNode($type);
		$result = '<ul><br>'."\n";
		$prev = '-';
		foreach ($cat_table as $tag) {
			$prev_len = strlen($prev);
			$current_len = strlen($tag->getPath());
			$current_level = $current_len/4;
			$prev_level = $prev_len/4;
			 
			//$result .= $prev.'_'.$tag->getPath();
		
			if ( $current_len > $prev_len) {
				$result .= str_repeat("\t", $current_level).
				'<li id = "' . $tag->getNode()->getId() . '"><a>'.$tag->getNode()->getName().'</a>' ."\n".
				str_repeat("\t", $current_level+1).
				'<ul><br>'."\n";
			}
			 
			if ($current_len == $prev_len) {
				$result .= str_repeat("\t", $current_level+1).
				'</ul>'."\n".
				str_repeat("\t", $current_level).
				'</li>'."\n".
				str_repeat("\t", $current_level).
				'<li id = "' . $tag->getNode()->getId() . '"><a>'.$tag->getNode()->getName().'</a>' ."\n".
				str_repeat("\t", $current_level+1).
				'<ul><br>'."\n";
			}		
			if ( $current_len < $prev_len) {
				for ($j = $prev_level; $j > $current_level; $j--){
					$result .= str_repeat("\t",$j+1 ).
					'</ul>'."\n".
					str_repeat("\t",$j ).
					'</li>'."\n";
					$prev_level = $j;
				}
				$result .=  str_repeat("\t", $prev_level).
				'</ul>'."\n".
				str_repeat("\t", $current_level).
				'</li>'."\n".
				str_repeat("\t", $current_level).
				'<li id = "' . $tag->getNode()->getId() . '"><a>'.$tag->getNode()->getName().'</a>'."\n".
				str_repeat("\t", $current_level+1).
				'<ul><br>'."\n";		
			}
			$prev = $tag->getPath();
		}		 
		for ($j = $current_level; $j > 0; $j--){
			$result .= str_repeat("\t",$j+1 ).
			'</ul>'."\n".
			str_repeat("\t",$j ).
			'</li>'."\n";			 
		}		 
		$result .= '</ul>'."\n";
		return $result;
		
	}
	
	public function getLastNodes($type){
		return $this->em->getRepository("AzgilCategoryBundle:CategoryNode")->createQueryBuilder('node')->
		where('node.type = :type')->setParameter('type', $type)->
		orderBy('node.id','DESC')->getQuery()->setMaxResults(5)->getResult();
	}
	
	public function fetcNodes($key,$type){
		$nodes = $this->em->getRepository("AzgilCategoryBundle:CategoryNode")->createQueryBuilder('node')->
		where('node.type = 1')->
		andWhere('node.name LIKE :key ')->setParameter('key', '%'.$key.'%')->
		orderBy('node.id','DESC')->getQuery()->setMaxResults(3)->getResult();
		
		$result = '<ul>';
		foreach ($nodes as $node) {
			$result .= '<li id="'.$node->getId().'">'.$node->getName().
			'<ul><br></ul></li>';
		}
		return $result.'</ul>';
	}
}

?>

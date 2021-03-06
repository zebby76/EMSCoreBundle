<?php

namespace EMS\CoreBundle\Service;


use EMS\CoreBundle\Entity\Form\Search;

class SearchService
{
	
	public function __construct() {
	}
	
	public function generateSearchBody(Search $search){
		$body = [];
		

		/** @var SearchFilter $filter */
		foreach ($search->getFilters() as $filter){
				
			$esFilter = $filter->generateEsFilter();
		
			if($esFilter){
				$body["query"]["bool"][$filter->getBooleanClause()][] = $esFilter;
			}
				
		}
		if ( null != $search->getSortBy() && strlen($search->getSortBy()) > 0  ) {
			$body["sort"] = [
					$search->getSortBy() => [
					    'order' => (empty($search->getSortOrder())?'asc': $search->getSortOrder()),
							'missing' => '_last',
							'unmapped_type' => 'long',
					]
			];
		}
		return $body;
	} 
	
	
}
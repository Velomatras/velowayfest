<?php

class ZayavkaQuoteList {
    private $zayavkaType;
    public $quotes = Array();
	public $quoteText = Array();
	public $photosName = Array();
	public $photosAuthor = Array();
	public $photosCity = Array();
	public $photosRegions = Array();
	
        public function __construct($zayavkaType) {
        $this->zayavkaType = $zayavkaType;
    }

    public function load($filterCondition, $sortByField = 'id', $sortOrder = '') {
		$test = "test";
        $this->zayavkaList = new ZayavkaList($this->zayavkaType);
        $this->zayavkaList->load($filterCondition, $sortByField);
        
		
        foreach ($this->zayavkaList->list as $zayavka){
            $quoteLinks = DBDataWork::unpackArray($zayavka['quote']);
			
				$numInList = $zayavka['id'] * 10 + 1;
			            $quotesNum = 1;
			
            foreach ($quoteLinks as $quote){
				
				$this->quoteText[$numInList] = $quote;
				$this->photosAuthor[$numInList] = $zayavka['name'];
				$this->photosRegions[$numInList] = getRegionsNames($zayavka['region']);
				$this->photosCity[$numInList] = $zayavka['city'];
                $this->quotes[]=Array('quote' => Array('quoteText' => $this->quoteText[$numInList], 'num' => $quotesNum, 'numInList' => $numInList,
				'photosName' => $this->photosName[$numInList][$quotesNum], 'name' => $this->photosAuthor[$numInList],
				'city' => $this->photosCity[$numInList], 'regions' => $this->photosRegions[$numInList]), 'zayavka' => $zayavka);
                $quotesNum++;
                $numInList++;
            }
			
			
        }
    }

    public function getCount() {
        return count($this->quotes);
    }
}


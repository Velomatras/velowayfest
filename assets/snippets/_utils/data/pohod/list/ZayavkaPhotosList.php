<?php

class ZayavkaPhotosList {
    private $zayavkaType;
    public $photos = Array();
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
        $numInList = 1;
		
        foreach ($this->zayavkaList->list as $zayavka){
            $photosLinks = (DBDataWork::unpackArray($zayavka['photos_link']));
			
			$numInList = $zayavka['id'] * 10 + 1;
			            $photoNum = 1;
			
            foreach ($photosLinks as $photo){
				
				if ($photoNum == 1){$this->photosName[$numInList][$photoNum] = $zayavka['photo01'];
				}
				if ($photoNum == 2){$this->photosName[$numInList][$photoNum] = $zayavka['photo02'];
				}
				if ($photoNum == 3){$this->photosName[$numInList][$photoNum] = $zayavka['photo03'];
				} 
				$this->photosAuthor[$numInList] = $zayavka['name'];
				$this->photosRegions[$numInList] = getRegionsNames($zayavka['region']);
				$this->photosCity[$numInList] = $zayavka['city'];
                $this->photos[]=Array('photo' => Array('link' => $photo, 'num' => $photoNum, 'numInList' => $numInList, 'photosName' => $this->photosName[$numInList][$photoNum], 'name' => $this->photosAuthor[$numInList], 'city' => $this->photosCity[$numInList], 'regions' => $this->photosRegions[$numInList]), 'zayavka' => $zayavka);
                $photoNum++;
                $numInList++;
            }
			
        }
    }

    public function getCount() {
        return count($this->photos);
    }
}


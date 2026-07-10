<?php

class ImageWork {

    static private function calcNewDimensions($width_orig, $height_orig, $longestDimension) {
    // calculate new image size when maximal dimension is fixed
        $ratio = ($width_orig == 0) ? 1.0 : ($height_orig / $width_orig);
        if ($width_orig >= $height_orig) {
            $width = $longestDimension;
            $height = ceil($longestDimension * $ratio);
        } else {
            $width = ceil($longestDimension / $ratio);
            $height = $longestDimension;
        }
        return Array($width, $height);
    }

    static public function uploadJPG($uploadFieldInputName, $savePath, $filename, $resizeLongestDimension = NULL) {
    // settings
        $max_file_size = 15 * 1024 * 1024; // 15 mb
        $valid_exts = array('jpeg', 'jpg');
    // do the business
        if (isset($_FILES[$uploadFieldInputName])) {
            if ($_FILES[$uploadFieldInputName]['size'] < $max_file_size) { // check file size
                $ext = strtolower(pathinfo($_FILES[$uploadFieldInputName]['name'], PATHINFO_EXTENSION)); // get file extension
                if (in_array($ext, $valid_exts)) {  // check file extension
				// $path = $savePath . $filename . "." . $ext;
                    $path = $savePath . $filename;
                    $path = FileWork::appendServerRootFolder($path);
                    if (!$resizeLongestDimension){
                        move_uploaded_file($_FILES[$uploadFieldInputName]['tmp_name'], $path);
                    }
                    else {
                        self::resizeAndSave($_FILES[$uploadFieldInputName]['tmp_name'], $path, $resizeLongestDimension);
                    }
                    return true;
                } else
                    GUIHelpers::printError('Изображения должны быть в формате JPEG!');
            } else
                GUIHelpers::printError('Изображения не загружены, они слишком большого размера!');
        }
        return false;
    }

    static public function resizeAndSave($srcImgPath, $resizedImgPath, $longestDimension) {
// Get original image size
        list($width_orig, $height_orig) = getimagesize($srcImgPath);
        list($width, $height) = self::calcNewDimensions($width_orig, $height_orig, $longestDimension);
// get image content
        $imgString = file_get_contents($srcImgPath);
// create image copy
        $image = imagecreatefromstring($imgString);
        $tmp = imagecreatetruecolor($width, $height);
        imagecopyresampled($tmp, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
// Save image
        $resizedImgPath = FileWork::appendServerRootFolder($resizedImgPath);
        imagejpeg($tmp, $resizedImgPath);
// cleanup everything
        imagedestroy($image);
        imagedestroy($tmp);
        return true;
    }

    static public function ShowImage($imgPath, $imgAlt = '', $imgComment = '') {
        //echo "<img src=\"$imgPath\" width=\"150px\" alt=\"$imgAlt\">";	// simple show
        // show with lightbox
        ?> <a data-lightbox="<?= $imgComment ?>" data-title="<?= $imgComment ?>" href="<?= $imgPath ?>">
            <img class="pohodImage" src="<?= $imgPath ?>" width="150px" /></a>
        <?php
    }

    static public function getShowImageJsScript() { ?>
        <script type="text/javascript">	// maintain the same size for horizontal and vertical images
            $( ".pohodImage" ).load(function() {
                if ( $( this ).height() > $( this ).width()) {
                    $( this ).width("100px");
            } });
        </script>
    <?php }

    static public function ShowImageBigSize($imgPath, $imgAlt = '', $imgComment = '') {
        //echo "<img src=\"$imgPath\" width=\"750px\" alt=\"$imgAlt\">";	// simple show
        // show with lightbox
        ?> <a data-lightbox="<?= $imgComment ?>" data-title="<?= $imgComment ?>" href="<?= $imgPath ?>">
        <img class="pohodImage" src="<?= $imgPath ?>" width="750px" /></a>&nbsp;&nbsp;&nbsp;&nbsp;
        <script type="text/javascript">	// maintain the same size for horizontal and vertical images
            $( ".pohodImage" ).load(function() {
                if ( $( this ).height() > $( this ).width()) {
                    $( this ).width("500px");
            } });
        </script> <?php
    }
}

function uploadCoverPic($uploadFieldInputName, $filename, $savePath) {
// settings
    $MAX_FILE_SIZE = 30 * 1024 * 1024; // 15Mb
    $valid_exts = array('jpeg', 'jpg');
    $thumbnailLongestDimension = 150;
    $coverPicLongestDimension = 1000;
// do the business
    if (isset($_FILES[$uploadFieldInputName]) && ($_FILES[$uploadFieldInputName]['error'] === UPLOAD_ERR_OK)) {
        if ($_FILES[$uploadFieldInputName]['size'] < $MAX_FILE_SIZE) {
// check file extension
            $ext = strtolower(pathinfo($_FILES[$uploadFieldInputName]['name'], PATHINFO_EXTENSION));
            if (in_array($ext, $valid_exts)) {
                $pathThumb = $_SERVER["DOCUMENT_ROOT"] . $savePath . '/thumb/' . $filename . '.' . $ext;
                $pathImg = $_SERVER["DOCUMENT_ROOT"] . $savePath . '/orig/' . $filename . '.' . $ext;
// resize and save images
                ImageWork::resizeAndSave($_FILES[$uploadFieldInputName]['tmp_name'], $pathThumb, $thumbnailLongestDimension);
                ImageWork::resizeAndSave($_FILES[$uploadFieldInputName]['tmp_name'], $pathImg, $coverPicLongestDimension);
                return true;
            } // only JPG
        }// else //$msg = 'Unsupported file type';
    } //else //$msg = 'Please upload image smaller than $max_file_size';
    return false;
}

class Photos {

    private $zayavkaNum;
    private $savePath;

    public function __construct($zayavkaNum, $savePath) {
        printDebugLog($savePath, __FUNCTION__);
        $this->zayavkaNum = $zayavkaNum;
        $this->savePath = $savePath;
    }

    private function uploadPhoto($uploadFieldInputName) {
        if (!isset($_FILES[$uploadFieldInputName]))
            return false;
        if ($_FILES[$uploadFieldInputName]['error'] === UPLOAD_ERR_OK) {
			$ext = strtolower(pathinfo($_FILES[$uploadFieldInputName]['name'], PATHINFO_EXTENSION));
            if ($ext == 'jpg' || $ext == 'png' || $ext == 'jpeg') $filename = $this->zayavkaNum . '_' . $uploadFieldInputName . "." . $ext;
			else $filename = $this->zayavkaNum . '_' . $uploadFieldInputName . '.jpg';
            if (ImageWork::uploadJPG($uploadFieldInputName, $this->savePath, $filename, 1500))
                return Filework::appendServerWWWRootFolder($this->savePath . $filename);
            else
                return false;
        }
    }

    public function uploadPhotos($uploadFieldInputBaseName) {
        if (substr($this->savePath, -1) !== '/') {
            $this->savePath = $this->savePath . '/';    // костыль - почему-то в редакторе заявок в конце нет слеша
        }
        $pathArray = Array();
        for ($i = 1; $i < 4; $i++) {
            $savePath = $this->uploadPhoto("$uploadFieldInputBaseName$i");
            if ($savePath)
                $pathArray[] = $savePath;
        }
        return $pathArray;
    }

    public function showPhotos($photosLinks) {
        if (empty($photosLinks))
            return;
        echo 'Фотоконкурс:<br>';
        $i = 1;
        foreach ($photosLinks as $link) {
            ImageWork::ShowImage($link, $i, $i++);
        }
    }
	
	public function showPhotosPik99($photosLinks, $num1_pik99, $num2_pik99, $num3_pik99) {
       if (empty($photosLinks))
            return;
        echo 'Фотоконкурс:<br>';
        $i = 1;
        foreach ($photosLinks as $link) {
			if ($num1_pik99 == 1 && $i == 1) {
				ImageWork::ShowImage($link, $i, $i++);
				continue;
			}
			if ($num2_pik99 == 1 && $i == 2) {
				ImageWork::ShowImage($link, $i, $i++);
				continue;
			}
			if ($num3_pik99 == 1 && $i == 3)  {
				ImageWork::ShowImage($link, $i, $i++);
			    continue;
			}
			$i++;
        }
	}
    

    public function showPhotosBigSize($photosLinks) {
        if (empty($photosLinks))
            return;
        echo 'Фотоконкурс:<br>';
        $i = 1;
        foreach ($photosLinks as $link) {
            ImageWork::ShowImageBigSize($link, $i, $i++);
            echo '<br>';
        }
    }

}

?>
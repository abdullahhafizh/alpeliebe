<?php

include("cropping/image_resizing.php");
$imgr = new imageResizing();

if($_POST['cp_img_path']){    

    $image = "/path/to/your/root/".$_POST['cp_img_path'];// $_POST['cp_img_path'] = /assets/uploads/img_name.ext
    $imgr->load($image);
    
    $imgX = intval($_POST['ic_x']);
    $imgY = intval($_POST['ic_y']);
    $imgW = intval($_POST['ic_w']);
    $imgH = intval($_POST['ic_h']);
    
    $imgr->resize($imgW,$imgH,$imgX,$imgY);    
    
    $imgr->save($image);

    echo '<img src="'.$_POST['cp_img_path'].'?t='.time().'" class="img-thumbnail"/>';
}
?>     

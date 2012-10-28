<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

function thumbImage($module_name,$sub_dir='tmp',$filename, $width=150, $height=100, $type='crop'){ 

    if(!is_file($filename)){ 
        return '' ; 
    }
    !is_dir('files') ? mkdir('files',0777) : null ; 
    !is_dir('files/thumbs') ? mkdir('files/thumbs',0777) : null ; 
    !is_dir('files/thumbs/'.$module_name) ? mkdir('files/thumbs/'.$module_name,0777) : null ; 
    !is_dir('files/thumbs/'.$module_name.'/'.$sub_dir) ? mkdir('files/thumbs/'.$module_name.'/'.$sub_dir,0777) : null ; 

    $file_info = pathinfo($filename) ; 
    $ext = $file_info['extension'] ; 
    $thumbImage = $file_info['filename'] ; 

    $thumbImage = './files/thumbs/'.$module_name.'/'.$sub_dir.'/'.$thumbImage.'_'.$width.'x'.$height.'.'.$ext ; 

    if(is_file($thumbImage)){ 
        return $thumbImage ; 
    }

	$ci =& get_instance();
    $ci->load->library('image_moo') ; 

    $ci->image_moo->load($filename)->resize($width,$height)->save($thumbImage) ; 

    if($ci->image_moo->errors){
        return ''; 
    }

    return $thumbImage ; 
} 
?>

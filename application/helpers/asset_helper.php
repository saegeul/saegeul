<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
* Saegeul Asset Helpers
*
* @package		CodeIgniter
* @subpackage	Helpers
* @category		Helpers
* @author       jaehee@saegeul.com 
*/

// ------------------------------------------------------------------------

function asset_url($asset_type,$module_name,$file_name)
{
 	$obj =& get_instance();
	$base_url = $obj->config->item('base_url');
    $module_locations = array_pop($obj->config->item('modules_locations')) ; 

	$asset_location = $base_url.'modules/'.$module_name.'/views/assets/';

    if(strpos($file_name,'/') === false){
        $asset_location .= $asset_type.'/'.$file_name; 
    } else {
	    $asset_location .= $file_name;
    }

	return $asset_location;   
}

function css_asset($module_name,$file_name){ 
	return '<link href="'.asset_url('css',$module_name, $file_name).'" rel="stylesheet" type="text/css" />';
}

function js_asset($module_name,$file_name){ 
	return '<script type="text/javascript" src="'.asset_url('js',$module_name, $file_name).'"></script>';
}

function img_asset($module_name,$file_name){
	return '<img src="'.asset_url('img', $module_name,$file_name).'" />'; 
} 

function common_asset_url($asset_type,$file_name)
{
 	$obj =& get_instance();
	$base_url = $obj->config->item('base_url');

	$asset_location = $base_url.'common/assets/'; 

    if(strpos($file_name,'/') === false){
        $asset_location .= $asset_type.'/'.$file_name; 
    } else {
	    $asset_location .= $file_name;
    }

	return $asset_location;   
}

function common_css_asset($file_name)
{ 
	return '<link href="'.common_asset_url('css', $file_name).'" rel="stylesheet" type="text/css" />';
}

function common_js_asset($file_name)
{ 
	return '<script type="text/javascript" src="'.common_asset_url('js', $file_name).'"></script>';
}

function common_img_asset($file_name)
{
	return '<img src="'.common_asset_url('img', $file_name).'" />'; 
}

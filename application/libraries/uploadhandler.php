<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

class UploadHandler {
	protected $ci;
	
	public function __construct(){
		$this->ci = &get_instance();
	}

	public function upload(){
		// upload configuration
		$config['upload_path'] = 'files/temp'; // temporary upload path
		$config['allowed_types'] = '*'; // allow all types
		$config['max_size']	= '50000'; // 5Mb
		$this->ci->load->library('upload', $config); 
		
		// upload file		
		if(!$this->ci->upload->do_upload('files')){
			return null;
		}
		
		// get file information
		$data = $this->ci->upload->data();
		
		// encrypte file name
		$this->ci->load->helper('date');
		$this->ci->load->helper('security');
		$encrypted_file_name = do_hash($data['file_name'] . time(), 'md5') . $data['file_ext'];

		// create today directory
		$today = date("Ymd");
		$save_dir = $data['is_image'] == 1 ? 'files/filebox/img/'.$today : 'files/filebox/binary/'.$today;
		!is_dir($save_dir) ? mkdir($save_dir,0777) : null;
		
		// move file
		$dest = $save_dir.'/'.$encrypted_file_name;
		rename($data['full_path'], $dest );
		
		// change file information
		$data['file_name'] = $encrypted_file_name;
		$data['full_path'] = $dest;
		$data['file_path'] = $save_dir;

		// make thumbnail
		$thumb_path = $this->makeThumbnail($data);	
		if($data['is_image'] == 1)
			$data['image_thumb_path'] = $thumb_path;
		else
			$data['image_thumb_path'] = "modules/clouddrive/views/assets/img/no_image.png";

		return $data ;
	}
	
	public function makeThumbnail($param) {
		// check file
		if($param['is_image'] != 1){
			return null;
		}
		
		// create thumb directory
		!is_dir($param['file_path']."/thumb") ? mkdir($param['file_path']."/thumb",0777) : null;
		
		// thumbnail url
		$thumb_path = $param['file_path'] ."/thumb/" . $param['file_name'] . "_110*90" .$param['file_ext'];
		
		// create 110 * 90 thumbnail
		$config['new_image'] =  $thumb_path;		
		$config['image_library'] = 'gd2';
		$config['source_image'] = $param['full_path'];
		$config['create_thumb'] = FALSE;
		$config['maintain_ratio'] = TRUE;
		$config['width'] = 110;
		$config['height'] = 90;
		
		$this->ci->load->library('image_lib');
		$image_lib = $this->ci->image_lib;
		$image_lib->initialize($config);
		$image_lib->resize();
		$image_lib->clear();
		
		return $thumb_path;
	}

}
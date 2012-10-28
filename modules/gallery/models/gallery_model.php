<?

class Gallery_model extends CI_Model {
	var $table = 'filebox';

	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}

        public function getImageList($page=1,$list_count=10){
            $this->db->where('is_image',1);
            $this->db->order_by("file_srl", "desc");
            $this->db->limit($list_count , ($page-1)*$list_count );

            $query = $this->db->get($this->table);
            $this->db->where('is_image',1);
            $total_rows = $this->db->count_all_results($this->table);

            $pagination['page'] = $page ;
            $pagination['list_count'] = $list_count ; 
            $pagination['total_rows'] = $total_rows ; 
            $pagination['page_count'] = ceil($total_rows / $list_count) ; 

            $result['list'] = $query->result() ; 
            $result['pagination'] = $pagination ; 

            return $result ;

        }
}

?>

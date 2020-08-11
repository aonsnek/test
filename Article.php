<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Article extends MX_Controller {

	public $PAGE;
	public function __construct() {
        parent::__construct();
        $this->utils->checkLogin();
        $this->load->model('article/model_article');
		$this->PAGE['title'] = 'บทความ | '.$this->load->get_var("default_title");
		
	}
	public function index()
	{	
		$this->load->view('article_view',$this->PAGE);
	}
	public function addArticle()
	{	
// 		aon
		$this->load->view('add_article_view',$this->PAGE);
	}
	public function editArticle($article_id)
	{	
		$this->PAGE["article_result"] = $this->model_article->getArticleByID($article_id); 
		$this->load->view('edit_article_view',$this->PAGE);
	}
	public function insertArticle()
	{
		//รับค่าจากฟอร์ม
		$article_name  = $this->input->post("article_name");
		$article_detail  = $this->input->post("article_detail");
		$article_img = $this->utils->upload_multiple_file("./uploads/article","article_img",$_FILES['article_img'],4000,4000,TRUE);

		$data = array(
			'article_name'	=>$article_name,
			'article_detail'	=>$article_detail,
	    );

		$this->db->insert('co_article', $data);
		$article_id   = $this->db->insert_id();

		if(!empty($article_img))
		{
			for($i=0;$i<count($article_img);$i++)
			{
				$image_list = $article_img[$i];
				$image_str = str_replace("./","",$image_list);
				$this->db->set("article_img",$image_str);
				$this->db->where("article_id ",$article_id );
				$this->db->update("co_article");
			}
		}
		redirect("article");
		
	}
	public function updateArticle()
	{
		//รับค่าจากฟอร์ม
		$article_id   = $this->input->post("article_id");
		$article_name  = $this->input->post("article_name");
		$article_detail  = $this->input->post("article_detail");
		$article_img = $this->utils->upload_multiple_file("./uploads/article","article_img",$_FILES['article_img'],4000,4000,TRUE);

		$data = array(
			'article_name'	=>$article_name,
			'article_detail'	=>$article_detail,
	    );

		$this->db->where('article_id', $article_id);
		$this->db->update('co_article', $data);

		if(!empty($article_img))
		{
			for($i=0;$i<count($article_img);$i++)
			{
				$image_list = $article_img[$i];
				$image_str = str_replace("./","",$image_list);
				$this->db->set("article_img",$image_str);
				$this->db->where("article_id ",$article_id );
				$this->db->update("co_article");
			}
		}
		redirect("article");
		
	}












}

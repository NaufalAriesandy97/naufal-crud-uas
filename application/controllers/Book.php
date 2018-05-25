<?php 
	class Book extends CI_Controller{

		public function __construct()
		{
			parent::__construct();
			$this->load->model('book_model');
		}

		public function index()
		{
			$data['books'] = $this->book_model->get_all_books();
			$this->load->view('book_view', $data);
		}

		public function book_add()
		{
			$data = array(
				'isbn_buku' => $this->input->post('isbn_buku'),
				'judul_buku' => $this->input->post('judul_buku'),
				'penulis_buku' => $this->input->post('penulis_buku'),
				'kategori_buku' => $this->input->post('kategori_buku')
			);

			$insert = $this->book_model->book_add($data);
			echo json_decode(array("status" => true));
		}

		public function ajax_edit($id)
		{
			$data = $this->book_model->get_by_id($id);
			echo json_encode($data);
		}

		public function book_update()
		{
			$data = array(
				'isbn_buku' => $this->input->post('isbn_buku'),
				'judul_buku' => $this->input->post('judul_buku'),
				'penulis_buku' => $this->input->post('penulis_buku'),
				'kategori_buku' => $this->input->post('kategori_buku')
			);

			$this->book_model->book_update(array('id_buku' => $this->input->post('id_buku')), $data);

			echo json_encode(array("status" => true));
		}

		public function book_delete($id)
		{
			$this->book_model->delete_by_id($id);
			echo json_encode(array("status" => true));
		}			
	}
 ?>
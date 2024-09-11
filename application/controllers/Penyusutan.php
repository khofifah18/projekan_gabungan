<?php

class Penyusutan extends CI_Controller {
    public function __construct (){
        parent::__construct();
        $this->load->model('m_inventori');

        // Cek apakah pengguna sudah login
        if (!$this->session->userdata('login')) {
            redirect('login');
        }

        // Cek hak akses pengguna
        $user_level = $this->session->userdata('level');
        if ($user_level !== 'Koordinator' && $user_level !== 'Operator') {
            redirect('login');
        }
    }

	public function index(){
        $data1['title'] = 'Penyusutan';
        $data['penyusutan'] = $this->m_inventori->tampil_penyusutan();
        $this->load->view('templates/header', $data1);
        $this->load->view('templates/sidebar');
        $this->load->view('penyusutan', $data);
        $this->load->view('templates/footer');
	}
}
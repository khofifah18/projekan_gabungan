<?php

class Dashboard extends CI_Controller{

    public function __construct()
    {
        parent::__construct();
        // $this->load->library('form_validation');
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

    public function index()
    {
        
        $data1['title'] = 'Dashboard'; 

        $total_masuk = $this->m_inventori->total_barang_masuk();
        $data['total_masuk'] =$total_masuk;
        
        $total_pemakaian = $this->m_inventori->total_barang_dipakai();
        $data['total_pemakaian'] =$total_pemakaian;

        $total_penyusutan = $this->m_inventori->total_penyusutan();
        $data['total_penyusutan'] =$total_penyusutan;

        $data['barang_data'] = $this->m_inventori->grafik_barang_masuk();
        $data['pemakaian_data'] = $this->m_inventori->grafik_barang_dipakai();
        $data['nonaktif_data'] = $this->m_inventori->grafik_barang_nonaktif();
       
        
        $this->load->view('templates/header', $data1);
        $this->load->view('templates/sidebar');
        $this->load->view('dashboard', $data);
        $this->load->view('templates/footer');
    }
}
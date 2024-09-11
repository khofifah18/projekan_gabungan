<?php

class Laporan_penyusutan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('m_inventori');

        // Cek apakah pengguna sudah login
        if (!$this->session->userdata('login')) {
            redirect('login');
        }

        // Cek hak akses pengguna
        $user_level = $this->session->userdata('level');
        if ($user_level !== 'Koordinator') {
            redirect('dashboard'); // Arahkan pengguna ke dashboard jika bukan koordinator
        }
    }

    public function index()
    {
        $data1['title'] = 'Laporan Penyusutan';
        $this->load->model('m_inventori');
        $data['penyusutan'] = $this->m_inventori->mengambil_data_penyusutan();
        // $data['barang'] = $this->m_inventori->get_data()->result();
        $this->load->view('templates/header', $data1);
        $this->load->view('templates/sidebar');
        $this->load->view('laporan_penyusutan', $data);
        $this->load->view('templates/footer');
    }

    public function filter()
    {
        $data1['title'] = 'Laporan Penyusutan';
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');

        // Validasi dan format tanggal jika diperlukan

        $this->load->model('m_inventori');
        $data['penyusutan'] = $this->m_inventori->fiter_tanggal_penyusutan($start_date, $end_date);

        // Load view dengan data yang telah difilter
        $this->load->view('templates/header', $data1);
        $this->load->view('templates/sidebar');
        $this->load->view('laporan_penyusutan', $data);
        $this->load->view('templates/footer');
    }

    public function cetak()
    {
        // Ambil tanggal dari tanggal tertentu, jika ada
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');

        // Gunakan model dengan filter tanggal jika ada
        $this->load->model('m_inventori');
        if ($start_date && $end_date) {
            $data['penyusutan'] = $this->m_inventori->fiter_tanggal_penyusutan($start_date, $end_date);
        } else {
            $data['penyusutan'] = $this->m_inventori->mengambil_data_penyusutan();
        }

        // Load view untuk cetak
        $this->load->view('cetak_penyusutan', $data);
    }
}

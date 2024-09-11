<?php

class Lokasi_barang extends CI_Controller
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
        $data1['title'] = 'Master Lokasi Barang';
        $this->load->model('m_inventori');
        $data['lokasi'] = $this->m_inventori->tampil_lokasi()->result();
        $this->load->view('templates/header', $data1);
        $this->load->view('templates/sidebar');
        $this->load->view('lokasi_barang', $data);
        $this->load->view('templates/footer');
    }

    //Untuk tampilan tambah Lokasi
    public function tambah_lokasi()
    {
        $data['title'] = 'Tambah Lokasi Barang';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('tambah_lokasi');
        $this->load->view('templates/footer');
    }

    // //Untuk melakukan tambah lokasi
    public function aksi_lokasi()
    {
        $this->_rules();
        if ($this->form_validation->run() == FALSE) {
            $this->tambah_lokasi();
        } else {
            $data = array(
                'lokasi_barang' => $this->input->post('lokasi_barang'),
            );

            $this->m_inventori->input_lokasi($data, 'lokasi_barang');
            $this->session->set_flashdata('pesan_tambah', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            lokasi Barang Berhasil Di Tambah!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>');
            redirect('lokasi_barang');
        }
    }

    // //Untuk validasi tambahh data harus diisi
    public function _rules()
    {
        $this->form_validation->set_rules('lokasi_barang', 'Lokasi barang', 'required|is_unique[lokasi_barang.lokasi_barang]', array(
            'required' => '%s harus diisi !!!',
            'is_unique' => 'Lokasi barang sudah terdaftar'
        ));
    }

    // //Edit lokasi barang
    public function edit_lokasi($lokasi_barang)
    {
        $lokasi_barang = urldecode($lokasi_barang);
        $data1['title'] = 'Edit lokasi Barang';
        $data['lokasi'] = $this->m_inventori->get_lokasi_by_name($lokasi_barang);

        if (!$data['lokasi']) {
            show_404();
        }

        $this->load->view('templates/header', $data1);
        $this->load->view('templates/sidebar');
        $this->load->view('edit_lokasi', $data);
        $this->load->view('templates/footer');
    }

    // // Proses update lokasi barang
    public function update_lokasi()
    {
        $lokasi_barang_lama = $this->input->post('lokasi_barang_lama');
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->edit_lokasi($lokasi_barang_lama);
        } else {
            $data = array(
                'lokasi_barang' => $this->input->post('lokasi_barang'),
            );
            $this->m_inventori->update_lokasi($lokasi_barang_lama, $data);
            $this->session->set_flashdata('pesan_edit', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Lokasi Barang Berhasil Di Edit!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>');
            redirect('lokasi_barang');
        }
    }


    // //Hapus lokasi barang
    public function hapus_lokasi($js)
    {
        // $where = array('lokasi_barang' => $js);
        $where = array('lokasi_barang' => urldecode($js));

        $result = $this->m_inventori->hapus_lokasi($where, 'lokasi_barang');
            
        if ($result) {
            $this->session->set_flashdata('pesan_hapus', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            Lokasi Barang Berhasil Di Hapus!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>');
        } else {
            $this->session->set_flashdata('pesan_gagal_hapus', '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            Gagal menghapus jenis barang. Jenis barang ini sudah digunakan di tabel barang masuk, pemakaian atau penyusutan.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>');
        }
            redirect('lokasi_barang');
    }

}

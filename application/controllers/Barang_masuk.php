<?php

class Barang_masuk extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
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
        $data['title'] = 'Barang Masuk';
        $this->load->model('m_inventori');
        $data['barang_masuk'] = $this->m_inventori->tampil_barang_masuk();
        $data['master_nama'] = $this->m_inventori->get_master_nama_barang();
        $data['master_jenis'] = $this->m_inventori->get_master_jenis_barang();

        $tgl = date("Y-m-d");

        // Debugging: Cek query notifikasi
        $query = "SELECT id_barang_masuk, DATEDIFF(masa_pakai, '$tgl') AS interval_tanggal FROM barang_masuk WHERE status='Aktif' AND qty > 0";
        $data['notifikasi'] = $this->db->query($query)->result_array();
        // Hitung jumlah notifikasi
        $data['jumlah_notifikasi'] = count(array_filter($data['notifikasi'], function ($cek) {
            return $cek['interval_tanggal'] <= 0; // Menghitung notifikasi yang masa pakainya habis hari ini atau lewat batas
        }));

        //Id otomatis
        $table = "barang_masuk";
        $field = "id_barang_masuk";
        $lastKode = $this->m_inventori->getMaxMasuk($table, $field);
        if ($lastKode) {
            $noUrut = (int) substr($lastKode, 2, 5);
            $noUrut++;
        } else {
            $noUrut = 1;
        }
        $str = "GD";
        $data['newKode'] = $str . sprintf('%05s', $noUrut);

        //No Inventori Otomatis
        $table = "barang_masuk";
        $field = "no_inventori";
        $lastKode = $this->m_inventori->getMaxInv($table, $field);
        if ($lastKode) {
            $noUrut = (int) substr($lastKode, 3, 5);
            $noUrut++;
        } else {
            $noUrut = 1;
        }
        $str = "INV";
        $data['newInv'] = $str . sprintf('%05s', $noUrut);


        // Memeriksa masa pakai
        foreach ($data['barang_masuk'] as &$item) {
            $masa_pakai = $this->m_inventori->get_masa_pakai_barang_masuk($item->no_inventori);
            $item->tombol_disabled = ($masa_pakai > date('Y-m-d')) ? 'disabled' : '';
        }


        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('barang_masuk', $data);
        $this->load->view('templates/footer');
    }

    public function aksi_tambah_barang()
    {
        $this->_rules();
        if ($this->form_validation->run() == FALSE) {
            $this->index();
        } else {
                // Data barang masuk
                $data = array(
                    'id_barang_masuk' => $this->input->post('id_barang_masuk'),
                    'no_inventori' => $this->input->post('no_inventori'),
                    'nama_barang' => $this->input->post('nama_barang'),
                    'jenis_barang' => $this->input->post('jenis_barang'),
                    'qty' => $this->input->post('qty'),
                    'masa_pakai' => $this->input->post('masa_pakai'),
                    'status' => 'Aktif',
                    'tanggal' => $this->input->post('tanggal'),
                    'lokasi_barang' => 'Gudang',
                    // 'status' => $status_barang
                );
                
                $this->m_inventori->input_barang_masuk($data, 'barang_masuk');
                $this->session->set_flashdata('pesan_tambah', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                Barang Berhasil Ditambahkan!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>');
                redirect('barang_masuk');
        }
    }


    public function _rules()
    {
        $this->form_validation->set_rules('qty', 'Qty', 'required', array(
            'required' => '%s tidak boleh kosong, harus diisi !!!',           
        ));
        $this->form_validation->set_rules('masa_pakai', 'Masa Pakai', 'required', array(
            'required' => '%s tidak boleh kosong, harus diisi !!!',
        ));
    }

    public function aksi_penyusutan($id_barang_masuk)
    {
        // Ambil data pemakaian
        $barang_masuk = $this->m_inventori->get_barang_masuk_by_id($id_barang_masuk);

        // Ambil masa pakai dari barang_masuk berdasarkan no_inventori
        $masa_pakai = $this->m_inventori->get_masa_pakai_barang_masuk($barang_masuk->no_inventori);

        // Cek apakah masa pakai sudah habis
        $masa_pakai_berakhir = $masa_pakai <= date('Y-m-d');

        if ($masa_pakai_berakhir) {
            // Update status menjadi Nonaktif
            $this->db->where('id_barang_masuk', $id_barang_masuk);
            $this->db->update('barang_masuk', array('status' => 'Nonaktif'));

            // Set pesan sukses
            $this->session->set_flashdata('pesan_berhasil_nonaktif', '<div class="alert alert-success alert-dismissible fade show" role="alert">
        Status barang telah diubah menjadi Nonaktif!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>');
        } else {
            // Set pesan gagal
            $this->session->set_flashdata('pesan_gagal_nonaktif', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        Masa pakai belum berakhir!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>');
        }

        // Redirect
        redirect('barang_masuk');
    }
}

<?php

class Pemakaian extends CI_Controller
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
        if ($user_level !== 'Koordinator' && $user_level !== 'Operator') {
            redirect('login');
        }
    }

    public function index()
    {
        $data1['title'] = 'Pemakaian';
        $this->load->model('m_inventori');
        $data['pemakaian'] = $this->m_inventori->tampil_pemakaian();
        $data['datanama'] = $this->m_inventori->get_nama_barang();
        $data['datalokasi'] = $this->m_inventori->get_lokasi_barang();
        $tgl = date("Y-m-d");

        // Debugging: Cek query notifikasi
        $query = "SELECT id_pemakaian, DATEDIFF(masa_pakai, '$tgl') AS interval_tanggal FROM pemakaian WHERE status='Aktif'";
        $data['notifikasi'] = $this->db->query($query)->result_array();
        // Hitung jumlah notifikasi
        $data['jumlah_notifikasi'] = count(array_filter($data['notifikasi'], function ($cek) {
            return $cek['interval_tanggal'] <= 0; // Menghitung notifikasi yang masa pakainya habis hari ini atau lewat batas
        }));

        // Id otomatis
        $table = "pemakaian";
        $field = "id_pemakaian";
        $lastKode = $this->m_inventori->getMax($table, $field);
        if ($lastKode) {
            $noUrut = (int) substr($lastKode, 2, 5);
            $noUrut++;
        } else {
            $noUrut = 1;
        }
        $str = "PK";
        $data['newKode'] = $str . sprintf('%05s', $noUrut);

        // Memeriksa masa pakai
        foreach ($data['pemakaian'] as &$item) {
            $masa_pakai = $this->m_inventori->get_masa_pakai_pemakaian($item->no_inventori);
            $item->tombol_disabled = ($masa_pakai > date('Y-m-d')) ? 'disabled' : '';
        }

        $this->load->view('templates/header', $data1);
        $this->load->view('templates/sidebar');
        $this->load->view('pemakaian', $data);
        $this->load->view('templates/footer');
    }
    public function aksi_tambah_pakai()
    {
        $this->_rules();
        if ($this->form_validation->run() == FALSE) {
            $this->index();
        } else {
            $no_inventori = $this->input->post('no_inventori');
            $jumlah = $this->input->post('jumlah');
            $status_barang = $this->m_inventori->get_status_barang($no_inventori); //mengambil status dari barang masuk
            $jenis_barang = $this->m_inventori->get_jenis_barang($no_inventori); //mengambil jenis dari barang masuk
            $nama_barang = $this->m_inventori->get_nama_barang_untuk_pemakaian($no_inventori); //mengambil nama dari barang masuk
            $masa_pakai = $this->m_inventori->get_masa_pakai_barang($no_inventori); //mengambil masa pakai dari barang masuk

            // Periksa ketersediaan stok
            if (!$this->m_inventori->cek_stok_barang($no_inventori, $jumlah)) {
                $this->session->set_flashdata('pesan_gagal', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            Stok barang tidak mencukupi!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>');
                redirect('pemakaian');
            } else {

                // Data pemakaian
                $data = array(
                    'id_pemakaian' => $this->input->post('id_pemakaian'),
                    'no_inventori' => $this->input->post('no_inventori'),
                    'nama_barang' => $nama_barang,
                    'jenis_barang' => $jenis_barang,
                    'jumlah' => $this->input->post('jumlah'),
                    'masa_pakai' => $masa_pakai,
                    'tanggal' => $this->input->post('tanggal'),
                    'status' => $status_barang,
                    'lokasi_barang' => $this->input->post('lokasi_barang'),
                );
                // Mulai transaksi
                $this->db->trans_start();

                // Simpan data pemakaian
                $this->m_inventori->input_tambah_pakai($data, 'pemakaian');

                // Kurangi jumlah barang
                $this->m_inventori->update_qty_barang($no_inventori, $jumlah);

                // Selesaikan transaksi
                $this->db->trans_complete();

                if ($this->db->trans_status() === FALSE) {
                    // Jika terjadi kesalahan, rollback transaksi
                    $this->session->set_flashdata('pesan_gagal', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                Barang gagal di pakai!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>');
                } else {
                    // Jika berhasil, commit transaksi
                    $this->session->set_flashdata('pesan_tambah', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                Barang berhasil di pakai!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>');
                }
                redirect('pemakaian');
            }
        }
    }


    public function _rules()
    {
        $this->form_validation->set_rules('jumlah', 'Jumlah', 'required', array(
            'required' => '%s tidak boleh kosong, harus diisi !!!',
        ));
    }

    public function aksi_penyusutan($id_pemakaian)
    {
        // Ambil data pemakaian
        $pemakaian = $this->m_inventori->get_pemakaian_by_id($id_pemakaian);

        // Ambil masa pakai dari barang_masuk berdasarkan no_inventori
        $masa_pakai = $this->m_inventori->get_masa_pakai_pemakaian($pemakaian->no_inventori);

        // Cek apakah masa pakai sudah habis
        $masa_pakai_berakhir = $masa_pakai <= date('Y-m-d');

        if ($masa_pakai_berakhir) {
            // Update status menjadi Nonaktif
            $this->db->where('id_pemakaian', $id_pemakaian);
            $this->db->update('pemakaian', array('status' => 'Nonaktif'));

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
        redirect('pemakaian');
    }
}

<?php

require 'vendor/autoload.php';

class Nama_barang extends CI_Controller
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
        $data1['title'] = 'Master Nama Barang';
        $this->load->model('m_inventori');
        $data['nama'] = $this->m_inventori->tampil_nama()->result();
        $this->load->view('templates/header', $data1);
        $this->load->view('templates/sidebar');
        $this->load->view('nama_barang', $data);
        $this->load->view('templates/footer');
    }

    //Untuk tampilan tambah nama
    public function tambah_nama()
    {
        $data['title'] = 'Tambah Nama Barang';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('tambah_nama');
        $this->load->view('templates/footer');
    }

    //Untuk melakukan tambah nama
    public function aksi_nama()
    {
        $this->_rules();
        if ($this->form_validation->run() == FALSE) {
            $this->tambah_nama();
        } else {
            $data = array(
                'nama_barang' => $this->input->post('nama_barang'),
            );

            $this->m_inventori->input_nama($data, 'nama_barang');
            $this->session->set_flashdata('pesan_tambah', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Nama Barang Berhasil Di Tambah!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>');
            redirect('nama_barang');
        }
    }

    //Untuk validasi tambahh data harus diisi
    public function _rules()
    {
        $this->form_validation->set_rules('nama_barang', 'Nama barang', 'required|is_unique[nama_barang.nama_barang]', array(
            'required' => '%s harus diisi !!!',
            'is_unique' => 'Nama barang sudah terdaftar'
        ));
    }

    //Edit nama barang
    public function edit_nama($nama_barang)
    {
        $nama_barang = urldecode($nama_barang);
        $data1['title'] = 'Edit Nama Barang';
        $data['nama'] = $this->m_inventori->get_nama_by_name($nama_barang);

        if (!$data['nama']) {
            show_404();
        }

        $this->load->view('templates/header', $data1);
        $this->load->view('templates/sidebar');
        $this->load->view('edit_nama', $data);
        $this->load->view('templates/footer');
    }

    // Proses update nama barang
    public function update_nama()
    {
        $nama_barang_lama = $this->input->post('nama_barang_lama');
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->edit_nama($nama_barang_lama);
        } else {
            $data = array(
                'nama_barang' => $this->input->post('nama_barang'),
            );
            $this->m_inventori->update_nama($nama_barang_lama, $data);
            $this->session->set_flashdata('pesan_edit', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Nama Barang Berhasil Di Edit!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>');
            redirect('nama_barang');
        }
    }

    //Hapus nama barang
    public function hapus_nama($js)
    {
        // $where = array('nama_barang' => $js);
        $where = array('nama_barang' => urldecode($js));

        $result = $this->m_inventori->hapus_nama($where, 'nama_barang');
        if ($result) {
        $this->session->set_flashdata('pesan_berhasil_hapus', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            Nama Barang Berhasil Di Hapus!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>');
        } else {
            $this->session->set_flashdata('pesan_gagal_hapus', '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            Gagal menghapus nama barang. Nama barang ini sudah digunakan di tabel barang masuk, pemakaian atau penyusutan.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>');
        }
        redirect('nama_barang');
    }

    //Untuk tampilan Import
    public function import_nama()
    {
        $data['title'] = 'Import Nama Barang';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('import_nama');
        $this->load->view('templates/footer');
    }
    //untuk importnya
    public function aksi_import_nama()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $upload_status = $this->uploadDoc();
            if ($upload_status != false) {
                // Dapatkan kolom dan baris awal dari input form
                $start_column = $this->input->post('start_column'); // Kolom awal, misal 'C'
                $start_row = $this->input->post('start_row'); // Baris awal, misal 2

                $inputFileName = 'assets/uploads/imports/' . $upload_status;
                $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($inputFileName);
                $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
                $spreadsheet = $reader->load($inputFileName);
                $sheet = $spreadsheet->getSheet(0); // Gunakan sheet pertama
                $count_Rows = 0;

                // Mendapatkan jumlah baris pada sheet
                $highestRow = $sheet->getHighestRow();

                // Mulai membaca data dari kolom dan baris yang ditentukan
                for ($row = $start_row; $row <= $highestRow; $row++) {
                    $nama_barang = $sheet->getCell($start_column . $row)->getValue(); // Membaca nilai dari cell yang ditentukan

                    // Periksa apakah nama barang sudah ada di database
                    if (!empty($nama_barang)) { // Pastikan nilai tidak kosong
                        $exists = $this->db->get_where('nama_barang', ['nama_barang' => $nama_barang])->num_rows();
                        if ($exists == 0) {
                            // Jika tidak ada, masukkan ke database
                            $data = array(
                                'nama_barang' => $nama_barang,
                            );
                            $this->db->insert('nama_barang', $data);
                            $count_Rows++;
                        }
                    }
                }
                $this->session->set_flashdata('berhasil_import', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Data berhasil di import, ' . $count_Rows . ' baris ditambahkan.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>');
                redirect('nama_barang');
            } else {
                $this->session->set_flashdata('gagal_import', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            Data gagal di import!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>');
                redirect('import_nama');
            }
        } else {
            $this->load->view('nama_barang'); // View untuk form upload
        }
    }
    public function uploadDoc()
    {
        $uploadPath = 'assets/uploads/imports/';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, TRUE);
        }

        $config['upload_path'] = $uploadPath;
        $config['allowed_types'] = 'csv|xlsx|xls';
        $config['max_size'] = 100000;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if ($this->upload->do_upload('upload_excel')) {
            $fileData = $this->upload->data();
            return $fileData['file_name'];
        } else {
            return false;
        }
    }
}

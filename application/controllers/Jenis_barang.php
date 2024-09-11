<?php

require 'vendor/autoload.php';

class Jenis_barang extends CI_Controller
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

    //Halaman Janis Barang
    public function index()
    {
        $data1['title'] = 'Master Jenis Barang';
        // $this->load->model('m_inventori');
        $data['jenis'] = $this->m_inventori->tampil_jenis()->result();
        $this->load->view('templates/header', $data1);
        $this->load->view('templates/sidebar');
        $this->load->view('jenis_barang', $data);
        $this->load->view('templates/footer');
    }

    //Halaman untuk tampilan tambah jenis
    public function tambah_jenis()
    {
        $data1['title'] = 'Tambah Jenis Barang';
        $this->load->view('templates/header', $data1);
        $this->load->view('templates/sidebar');
        $this->load->view('tambah_jenis');
        $this->load->view('templates/footer');
    }

    //Untuk melakukan tambah jenis
    public function aksi_jenis()
    {
        $this->_rules();
        if ($this->form_validation->run() == FALSE) {
            $this->tambah_jenis();
        } else {
            $data = array(
                'jenis_barang' => $this->input->post('jenis_barang'),
            );

            $this->m_inventori->input_jenis($data, 'jenis_barang');
            $this->session->set_flashdata('pesan_tambah', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Jenis Barang Berhasil Di Tambah!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>');
            redirect('jenis_barang');
        }
    }

    //Untuk validasi tambahh data harus diisi
    public function _rules()
    {
        $this->form_validation->set_rules('jenis_barang', 'Jenis barang', 'required|is_unique[jenis_barang.jenis_barang]', array(
            'required' => '%s harus diisi !!!',
            'is_unique' => 'Jenis barang sudah terdaftar'
        ));
    }


    //Edit jenis barang
    public function edit_jenis($jenis_barang)
    {
        $jenis_barang = urldecode($jenis_barang);
        $data1['title'] = 'Edit Jenis Barang';
        $data['jenis'] = $this->m_inventori->get_jenis_by_name($jenis_barang);

        if (!$data['jenis']) {
            show_404();
        }

        $this->load->view('templates/header', $data1);
        $this->load->view('templates/sidebar');
        $this->load->view('edit_jenis', $data);
        $this->load->view('templates/footer');
    }

    // Proses update jenis barang
    public function update_jenis()
    {
        $jenis_barang_lama = $this->input->post('jenis_barang_lama');
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->edit_jenis($jenis_barang_lama);
        } else {
            $data = array(
                'jenis_barang' => $this->input->post('jenis_barang'),
            );
            $this->m_inventori->update_jenis($jenis_barang_lama, $data);
            $this->session->set_flashdata('pesan_edit', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Jenis Barang Berhasil Di Edit!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>');
            redirect('jenis_barang');
        }
    }

    //Hapus Jenis Barang
    public function hapus_jenis($js)
    {
        // $where = array('jenis_barang' => $js);
        $where = array('jenis_barang' => urldecode($js));

        $result = $this->m_inventori->hapus_jenis($where, 'jenis_barang');
        if ($result) {
            $this->session->set_flashdata('pesan_hapus', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            Jenis Barang Berhasil Di Hapus!
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
        redirect('jenis_barang');
    }

    //Untuk tampilan Import jenis
    public function import_jenis()
    {
        $data['title'] = 'Import Jenis Barang';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('import_jenis');
        $this->load->view('templates/footer');
    }
    //untuk importnya
    public function aksi_import_jenis()
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
                    $jenis_barang = $sheet->getCell($start_column . $row)->getValue(); // Membaca nilai dari cell yang ditentukan

                    // Periksa apakah jenis barang sudah ada di database
                    if (!empty($jenis_barang)) { // Pastikan nilai tidak kosong
                        $exists = $this->db->get_where('jenis_barang', ['jenis_barang' => $jenis_barang])->num_rows();
                        if ($exists == 0) {
                            // Jika tidak ada, masukkan ke database
                            $data = array(
                                'jenis_barang' => $jenis_barang,
                            );
                            $this->db->insert('jenis_barang', $data);
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
                redirect('jenis_barang');
            } else {
                $this->session->set_flashdata('gagal_import', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            Data gagal di import!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>');
                redirect('import_jenis');
            }
        } else {
            $this->load->view('jenis_barang'); // View untuk form upload
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

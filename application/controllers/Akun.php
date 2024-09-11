<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Akun extends CI_Controller
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
        $data1['title'] = 'Akun';
        $data = $this->m_inventori->getProfile();
        $this->load->view('templates/header', $data1);
        $this->load->view('templates/sidebar');
        $this->load->view('akun', ['data' => $data]);
        $this->load->view('templates/footer');
    }

    public function error()
    {
        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('templates/error');
        $this->load->view('templates/footer');
    }

    public function tambah_akun()
    {
        $data1['title'] = 'Tambah Akun';
        $this->load->view('templates/header', $data1);
        $this->load->view('templates/sidebar');
        $this->load->view('tambah_akun');
        $this->load->view('templates/footer');
    }

    public function action_tambah()
    {
        $nip = $this->input->post('nip');
        $nama = $this->input->post('nama');
        $jenis_kelamin = $this->input->post('jenis_kelamin');
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $level = $this->input->post('level');

        $this->load->library('form_validation');

        // Aturan validasi untuk NIP: wajib diisi, harus berupa angka, dan harus 18 karakter
        $this->form_validation->set_rules(
            'nip',
            'NIP',
            'required|numeric|exact_length[18]',
            array(
                'required' => 'NIP harus diisi.',
                'numeric' => 'NIP harus berupa angka.',
                'exact_length' => 'NIP harus terdiri dari 18 angka.'
            )
        );

        // Aturan validasi lainnya
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required');
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('level', 'Level', 'required');

        // Jika validasi gagal, kembali ke form tambah akun dengan pesan error
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('akun/tambah_akun');
        } else {
            // Jika validasi berhasil, lakukan proses penyimpanan data
            $data = array(
                'nip' => $this->input->post('nip'),
                'nama' => $this->input->post('nama'),
                'jenis_kelamin' => $this->input->post('jenis_kelamin'),
                'username' => $this->input->post('username'),
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'level' => $this->input->post('level'),
            );


            // Periksa apakah NIP sudah ada
            $nip_exist = $this->m_inventori->check_nip_exists($nip);

            if ($nip_exist) {
                // Jika NIP sudah ada, set flashdata dan tampilkan form dengan data yang sudah diisi
                $this->session->set_flashdata('error', 'NIP sudah terdaftar, gunakan NIP yang lain.');
                $data = compact('nip', 'nama', 'jenis_kelamin', 'username', 'password', 'level');
                $this->load->view('templates/header');
                $this->load->view('templates/sidebar');
                $this->load->view('tambah_akun', $data);
                $this->load->view('templates/footer');
            } else {
                // Jika NIP belum ada, lanjutkan untuk menyimpan data
                $data = [
                    'nip' => $nip,
                    'nama' => $nama,
                    'jenis_kelamin' => $jenis_kelamin,
                    'username' => $username,
                    'password' => $password,
                    'level' => $level
                ];
                $this->m_inventori->insert_profile($data);

                $this->session->set_flashdata('success', 'Akun berhasil ditambahkan.');
                redirect('akun');
            }
        }
    }

    public function edit($nip)
    {
        $data1['title'] = 'Edit Akun';
        $data = $this->m_inventori->getData($nip);
        $this->load->view('templates/header', $data1);
        $this->load->view('templates/sidebar');
        $this->load->view('edit_akun', ['data' => $data]);
        $this->load->view('templates/footer');
    }

    public function action_edit($nip)
    {
        $data = $this->input->post();
        if ($this->m_inventori->edit($nip, $data)) {
            $this->session->set_flashdata('success', 'Akun berhasil diperbarui!');
            redirect(base_url('akun'));
        } else {
            $this->session->set_flashdata('error', 'Gagal memperbarui akun!');
            redirect(base_url('index.php/profile/error'));
        }
    }

    public function delete($nip)
    {
        if ($this->m_inventori->delete($nip)) {
            $this->session->set_flashdata('success', 'Akun berhasil dihapus!');
            redirect(base_url('akun'));
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus akun!');
            redirect(base_url('index.php/profile/error'));
        }
    }
}

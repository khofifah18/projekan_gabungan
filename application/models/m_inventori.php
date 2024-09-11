<?php

class M_inventori extends CI_Model
{
    //**Login */
    // function cek_login($where)
    // {
    //     return $this->db->get_where('akun', $where);
    // }
    public function cek_login($where)
    {
        // Mengambil data dari tabel 'akun' berdasarkan kredensial yang diberikan
        $this->db->select('username, level'); // Pilih kolom yang diperlukan
        $this->db->from('akun'); // Ganti dengan nama tabel pengguna Anda
        $this->db->where($where);
        return $this->db->get();
    }





    //**Halaman Dashboard */
    //Jumlah barang masuk
    public function total_barang_masuk()
    {
        $this->db->select_sum('qty');
        $this->db->where('status', 'Aktif');
        $query = $this->db->get('barang_masuk');
        return $query->row()->qty;
    }
    //Jumlah barang dipakai
    public function total_barang_dipakai()
    {
        $this->db->select_sum('jumlah');
        $this->db->where('status', 'Aktif');
        $query = $this->db->get('pemakaian');
        return $query->row()->jumlah;
    }
    //Jumlah penyusutan
    public function total_penyusutan()
    {
        // Menjumlahkan qty dari barang_masuk dengan status 'Nonaktif'
        $this->db->select_sum('qty');
        $this->db->where('status', 'Nonaktif');
        $query_barang_masuk = $this->db->get('barang_masuk');
        $total_barang_masuk = $query_barang_masuk->row()->qty;
        // Menjumlahkan qty dari pemakaian dengan status 'Nonaktif'
        $this->db->select_sum('jumlah');
        $this->db->where('status', 'Nonaktif');
        $query_pemakaian = $this->db->get('pemakaian');
        $total_pemakaian = $query_pemakaian->row()->jumlah;
        // Menggabungkan hasil dari kedua tabel
        $total_penyusutan = $total_barang_masuk + $total_pemakaian;
        return $total_penyusutan;
    }
    //Grafik barang masuk
    public function grafik_barang_masuk()
    {
        // Query untuk mengambil nama barang dan jumlah (qty) dari tabel barang_masuk
        $this->db->select('nama_barang, SUM(qty) as jumlah');
        $this->db->where('status', 'Aktif');
        $this->db->where('qty >', 0);
        $this->db->from('barang_masuk');
        $this->db->group_by('nama_barang');  // Group by nama barang
        $this->db->order_by('jumlah', 'DESC');
        $this->db->limit(4);
        $query = $this->db->get();
        return $query->result();
    }
    //Grafik barang pemakaian
    public function grafik_barang_dipakai()
    {
        // Query untuk mengambil nama barang dan jumlah (qty) dari tabel barang_masuk
        $this->db->select('nama_barang, SUM(jumlah) as jumlah');
        $this->db->where('status', 'Aktif');
        $this->db->from('pemakaian');
        $this->db->group_by('nama_barang');  // Group by nama barang
        $this->db->order_by('jumlah', 'DESC');
        $this->db->limit(4); // Ambil hanya 4 data teratas
        $query = $this->db->get();
        return $query->result();
    }
    // //Grafik barang nonaktif
    public function grafik_barang_nonaktif()
    {
        // Ambil data dari tabel pemakaian yang statusnya Nonaktif
        $this->db->select('nama_barang, SUM(jumlah) as total');
        $this->db->where('status', 'Nonaktif');
        $this->db->group_by('nama_barang');
        $pemakaian = $this->db->get('pemakaian')->result_array();

        // Ambil data dari tabel barang_masuk yang statusnya Nonaktif
        $this->db->select('nama_barang, SUM(qty) as total');
        $this->db->where('status', 'Nonaktif');
        $this->db->group_by('nama_barang');
        $barang_masuk = $this->db->get('barang_masuk')->result_array();

        // Gabungkan kedua hasil query dalam satu array
        $penyusutan = array_merge($pemakaian, $barang_masuk);

        // Format data menjadi array dengan nama barang sebagai key dan total sebagai value
        $result = [];
        foreach ($penyusutan as $item) {
            if (isset($result[$item['nama_barang']])) {
                $result[$item['nama_barang']] += $item['total'];
            } else {
                $result[$item['nama_barang']] = $item['total'];
            }
        }

        // Urutkan data berdasarkan total dari yang terbesar ke yang terkecil
        arsort($result);

        // Ambil 4 item teratas
        $top_items = array_slice($result, 0, 4, true);

        // Konversi array hasil akhir ke bentuk yang sesuai untuk view
        $formatted_result = [
            'labels' => array_keys($top_items),
            'data' => array_values($top_items)
        ];

        return $formatted_result;
    }

    







    //**Halaman tambah akun */
    public function tampil_data()
    {
        // Logika untuk mengambil data dari database
        $query = $this->db->get('akun');
        return $query->result();
    }

    public function simpan()
    {
        $data = $this->input->post();
        if (!empty($data)) {
            return $this->db->insert('akun', $data);
        }
    }

    public function edit($nip, $data)
    {
        if (!empty($data)) {
            return $this->db->update('akun', $data, ['nip' => $nip]);
        }
    }

    public function getProfile()
    {
        $nama = $this->input->get('nama');
        if (empty($nama)) {
            return $this->db->get('akun')->result_array();
        } else {
            return $this->db->query('SELECT * FROM akun WHERE nama LIKE ?', '%' . $nama . '%')->result_array();
        }
    }

    public function getData($nip)
    {
        return $this->db->get_where('akun', ['nip' => $nip])->row_array();
    }

    public function delete($nip)
    {
        return $this->db->delete('akun', ['nip' => $nip]);
    }

    // Method untuk memeriksa apakah NIP sudah ada
    public function check_nip_exists($nip)
    {
        $this->db->where('nip', $nip);
        $query = $this->db->get('akun'); // Menggunakan tabel 'akun' sesuai dengan nama tabel yang Anda gunakan

        return $query->num_rows() > 0;
    }

    // Method untuk menyimpan data profil baru
    public function insert_profile($data)
    {
        $this->db->insert('akun', $data); // Menyimpan data ke tabel 'akun'
    }





    //**Halaman master Nama Barang */
    //Untuk halaman menampilkan nama barang
    public function tampil_nama()
    {
        return $this->db->get('nama_barang');
    }
    //Untuk menambahkan nama 
    public function input_nama($data, $table)
    {
        return $this->db->insert($table, $data);
    }
    // Untuk melakukan update
    public function update_nama($nama_barang_lama, $data)
    {
        $this->db->where('nama_barang', $nama_barang_lama);
        return $this->db->update('nama_barang', $data);
    }
    // Mengambil data nama barang berdasarkan nama
    public function get_nama_by_name($nama_barang)
    {
        $this->db->where('nama_barang', $nama_barang);
        return $this->db->get('nama_barang')->row();
    }
    // Menghapus nama barang
    public function hapus_nama($where, $table)
    {
        // $this->db->where($where);
        // $this->db->delete($table);
        // Cek apakah nama barang masih digunakan di tabel barang_masuk
        $this->db->where('nama_barang', $where['nama_barang']);
        $this->db->from('barang_masuk');
        $count_barang_masuk = $this->db->count_all_results();

        // Cek apakah nama barang masih digunakan di tabel pemakaian
        $this->db->where('nama_barang', $where['nama_barang']);
        $this->db->from('pemakaian');
        $count_pemakaian = $this->db->count_all_results();

        if ($count_barang_masuk > 0 || $count_pemakaian > 0) {
            // Jika nama barang masih digunakan
            return false;
        } else {
            // Jika nama barang tidak digunakan, hapus data
            $this->db->where($where);
            $this->db->delete($table);
            return true;
        }
    }





    //**Halaman master Jenis Barang */
    //Untuk halaman menampilkan jenis barang
    public function tampil_jenis()
    {
        return $this->db->get('jenis_barang');
    }
    //Untuk menambahkan jenis
    public function input_jenis($data, $table)
    {
        return $this->db->insert($table, $data);
    }
    // Untuk melakukan update
    public function update_jenis($jenis_barang_lama, $data)
    {
        $this->db->where('jenis_barang', $jenis_barang_lama);
        return $this->db->update('jenis_barang', $data);
    }
    // Mengambil data jenis barang berdasarkan nama
    public function get_jenis_by_name($jenis_barang)
    {
        $this->db->where('jenis_barang', $jenis_barang);
        return $this->db->get('jenis_barang')->row();
    }
    //Menghapus data jenis barang
    public function hapus_jenis($where, $table)
    {
        // $this->db->where($where);
        // $this->db->delete($table);
        // Cek apakah nama barang masih digunakan di tabel barang_masuk
        $this->db->where('jenis_barang', $where['jenis_barang']);
        $this->db->from('barang_masuk');
        $count_barang_masuk = $this->db->count_all_results();

        // Cek apakah nama barang masih digunakan di tabel pemakaian
        $this->db->where('jenis_barang', $where['jenis_barang']);
        $this->db->from('pemakaian');
        $count_pemakaian = $this->db->count_all_results();

        if ($count_barang_masuk > 0 || $count_pemakaian > 0) {
            // Jika nama barang masih digunakan
            return false;
        } else {
            // Jika nama barang tidak digunakan, hapus data
            $this->db->where($where);
            $this->db->delete($table);
            return true;
        }
    }





    //**Halaman Master Lokasi Barang */
    //Untuk halaman menampilkan lokasi barang
    public function tampil_lokasi()
    {
        return $this->db->get('lokasi_barang');
    }
    //Untuk menambahkan lokasi 
    public function input_lokasi($data, $table)
    {
        return $this->db->insert($table, $data);
    }
    // Untuk melakukan update
    public function update_lokasi($lokasi_barang_lama, $data)
    {
        $this->db->where('lokasi_barang', $lokasi_barang_lama);
        return $this->db->update('lokasi_barang', $data);
    }
    // Mengambil data lokasi barang berdasarkan nama
    public function get_lokasi_by_name($lokasi_barang)
    {
        $this->db->where('lokasi_barang', $lokasi_barang);
        return $this->db->get('lokasi_barang')->row();
    }
    // Menghapus lokasi barang
    public function hapus_lokasi($where, $table)
    {
        // $this->db->where($where);
        // $this->db->delete($table);
        // Cek apakah nama barang masih digunakan di tabel barang_masuk
        $this->db->where('lokasi_barang', $where['lokasi_barang']);
        $this->db->from('barang_masuk');
        $count_barang_masuk = $this->db->count_all_results();

        // Cek apakah nama barang masih digunakan di tabel pemakaian
        $this->db->where('lokasi_barang', $where['lokasi_barang']);
        $this->db->from('pemakaian');
        $count_pemakaian = $this->db->count_all_results();

        if ($count_barang_masuk > 0 || $count_pemakaian > 0) {
            // Jika nama barang masih digunakan
            return false;
        } else {
            // Jika nama barang tidak digunakan, hapus data
            $this->db->where($where);
            $this->db->delete($table);
            return true;
        }
    }





    //**Halaman Barang Masuk */
    //Untuk menambahkan barang masuk 
    public function input_barang_masuk($data, $table)
    {
        return $this->db->insert($table, $data);
    }
    //Untuk menampilkan barang yang sudah didaftarkan/dimauskan
    public function tampil_barang_masuk()
    {
        // return $this->db->get('barang_masuk');

        $this->db->where('status', 'Aktif');
        $this->db->where('qty >', 0);
        return $this->db->get('barang_masuk')->result();
    }
    //ID barang masuk Otomatis
    public function getMaxMasuk($table = null, $field = null)
    {
        $this->db->select_max($field);
        return $this->db->get($table)->row_array()[$field];
    }
    //No inventori otomatis
    public function getMaxInv($table = null, $field = null)
    {
        $this->db->select_max($field);
        return $this->db->get($table)->row_array()[$field];
    }
    //Coba selec option mengambil nama barang
    public function get_master_nama_barang()
    {
        $query = $this->db->query("SELECT * FROM nama_barang ORDER BY nama_barang ASC");
        return $query->result();
    }
    //Coba selec option mengambil jenis barang
    public function get_master_jenis_barang()
    {
        $query = $this->db->query("SELECT * FROM jenis_barang ORDER BY jenis_barang ASC");
        return $query->result();
    }
    // Ngecek masa pakai apakah sudah habis apa belom
    public function get_masa_pakai_barang_masuk($no_inventori)
    {
        $this->db->select('masa_pakai');
        $this->db->from('barang_masuk');
        $this->db->where('no_inventori', $no_inventori);
        $query = $this->db->get();
        return $query->row()->masa_pakai;
    }
    //Mengambil data yang ada di barang_masuk 
    public function get_barang_masuk_by_id($id_barang_masuk)
    {
        return $this->db->get_where('barang_masuk', array('id_barang_masuk' => $id_barang_masuk))->row();
    }
    //Mengubah status yang ada di barang_masuk
    public function update_status_barang_masuk($id_barang_masuk, $data)
    {
        $this->db->where('id_barang_masuk', $id_barang_masuk);
        return $this->db->update('barang_masuk', $data);
    }





    //**Halaman Pemakaian */
    //Menampilkan semua data yang sedang dipakai
    public function tampil_pemakaian()
    {
        $this->db->where('status', 'Aktif');
        return $this->db->get('pemakaian')->result();
    }
    //Unutuk menambahkan barang pakai
    public function input_tambah_pakai($data, $table)
    {
        return $this->db->insert($table, $data);
    }
    //Coba selec option pemakaian
    public function get_nama_barang()
    {
        $tgl = date('Y-m-d');
        $query = $this->db->query("SELECT * FROM barang_masuk WHERE qty > 0 AND status = 'Aktif' AND masa_pakai > '$tgl' ORDER BY no_inventori ASC");
        return $query->result();
    }
    //ID Otomatis
    public function getMax($table = null, $field = null)
    {
        $this->db->select_max($field);
        return $this->db->get($table)->row_array()[$field];
    }
    //Untuk mengupdet qty/mengurangi qty
    public function update_qty_barang($no_inventori, $jumlah_pakai)
    {
        $this->db->set('qty', 'qty - ' . (int)$jumlah_pakai, FALSE);
        $this->db->where('no_inventori', $no_inventori);
        return $this->db->update('barang_masuk');
    }
    //cek stok
    public function cek_stok_barang($no_inventori, $jumlah_pakai)
    {
        $this->db->select('qty');
        $this->db->where('no_inventori', $no_inventori);
        $query = $this->db->get('barang_masuk');

        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->qty >= $jumlah_pakai;
        }
        return FALSE;
    }
    //Untuk mengambil status berdasarkan status di barang masuk
    public function get_status_barang($no_inventori)
    {
        $this->db->select('status');
        $this->db->from('barang_masuk');
        $this->db->where('no_inventori', $no_inventori);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row()->status;
        } else {
            return null; // atau status default jika tidak ditemukan
        }
    }
    //Untuk mengambil nama barang berdasarkan  di barang masuk
    public function get_nama_barang_untuk_pemakaian($no_inventori)
    {
        $this->db->select('nama_barang');
        $this->db->from('barang_masuk');
        $this->db->where('no_inventori', $no_inventori);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row()->nama_barang;
        } else {
            return null; // atau status default jika tidak ditemukan
        }
    }
    //Untuk mengambil jenis barang berdasarkan  di barang masuk
    public function get_jenis_barang($no_inventori)
    {
        $this->db->select('jenis_barang');
        $this->db->from('barang_masuk');
        $this->db->where('no_inventori', $no_inventori);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row()->jenis_barang;
        } else {
            return null; // atau status default jika tidak ditemukan
        }
    }
    //Untuk mengambil masa pakai barang berdasarkan  di barang masuk
    public function get_masa_pakai_barang($no_inventori)
    {
        $this->db->select('masa_pakai');
        $this->db->from('barang_masuk');
        $this->db->where('no_inventori', $no_inventori);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row()->masa_pakai;
        } else {
            return null; // atau status default jika tidak ditemukan
        }
    }
    // Ngecek masa pakai apakah sudah habis apa belom
    public function get_masa_pakai_pemakaian($no_inventori)
    {
        $this->db->select('masa_pakai');
        $this->db->from('barang_masuk');
        $this->db->where('no_inventori', $no_inventori);
        $query = $this->db->get();
        return $query->row()->masa_pakai;
    }
    //Mengambil data yang ada di pemakaian 
    public function get_pemakaian_by_id($id_pemakaian)
    {
        return $this->db->get_where('pemakaian', array('id_pemakaian' => $id_pemakaian))->row();
    }
    //Mengubah status yang ada di pemakaian
    public function update_status_barang($id_pemakaian, $data)
    {
        $this->db->where('id_pemakaian', $id_pemakaian);
        return $this->db->update('pemakaian', $data);
    }
    //Coba selec option mengambil nama barang
    public function get_lokasi_barang()
    {
        $query = $this->db->query("SELECT * FROM lokasi_barang ORDER BY lokasi_barang ASC");
        return $query->result();
    }





    //**Penyusutan */  
    public function tampil_penyusutan()
    {
        // Ambil data dari tabel pemakaian yang statusnya Nonaktif
        $this->db->where('status', 'Nonaktif');
        $pemakaian = $this->db->get('pemakaian')->result_array();

        // Ambil data dari tabel barang_masuk yang statusnya Nonaktif
        $this->db->where('status', 'Nonaktif');
        $barang_masuk = $this->db->get('barang_masuk')->result_array();

        // Gabungkan kedua hasil query dalam satu array
        $penyusutan = array_merge($pemakaian, $barang_masuk);

        return $penyusutan;
    }





    //**Laporan Barang Masuk */
    //Menampilkan laporan Barang Masuk
    public function mengambil_data_barang_masuk()
    {
        $this->db->where('status', 'Aktif');
        $this->db->where('qty >', 0);
        // $this->db->order_by('tanggal', 'ASC');
        return $this->db->get('barang_masuk')->result();
    }
    //**Filter tanggal */
    public function fiter_tanggal_barang_masuk($start_date, $end_date)
    {
        $this->db->where('status', 'Aktif');
        $this->db->where('qty >', 0);
        // return $this->db->get('pemakaian')->result();
        if ($start_date && $end_date) {
            $this->db->where('tanggal >=', $start_date);
            $this->db->where('tanggal <=', $end_date);
        }

        $query = $this->db->get('barang_masuk');
        return $query->result();
    }





    //**Laporan Pemakaian */
    //Menampilkan laporan pemakaian
    public function mengambil_data_pemakaian()
    {
        $this->db->where('status', 'Aktif');
        return $this->db->get('pemakaian')->result();
    }
    //**Filter tanggal */
    public function fiter_tanggal_pemakaian($start_date, $end_date)
    {
        $this->db->where('status', 'Aktif');
        // return $this->db->get('pemakaian')->result();
        if ($start_date && $end_date) {
            $this->db->where('tanggal >=', $start_date);
            $this->db->where('tanggal <=', $end_date);
        }

        $query = $this->db->get('pemakaian');
        return $query->result();
    }





    //**Laporan Penyusutan */
    public function mengambil_data_penyusutan()
    {
        $this->db->where('status', 'Nonaktif');
        $pemakaian = $this->db->get('pemakaian')->result_array();

        // Ambil data dari tabel barang_masuk yang statusnya Nonaktif
        $this->db->where('status', 'Nonaktif');
        $barang_masuk = $this->db->get('barang_masuk')->result_array();

        // Gabuangan dua query
        $penyusutan = array_merge($pemakaian, $barang_masuk);

        return $penyusutan;
    }
    //**Filter tanggal */
    public function fiter_tanggal_penyusutan($start_date, $end_date)
    {
        $this->db->where('status', 'Nonaktif');
        if ($start_date && $end_date) {
            $this->db->where('tanggal >=', $start_date);
            $this->db->where('tanggal <=', $end_date);
        }
        $pemakaian = $this->db->get('pemakaian')->result_array();

        // Filter dari tabel barang_masuk
        $this->db->where('status', 'Nonaktif');
        if ($start_date && $end_date) {
            $this->db->where('tanggal >=', $start_date);
            $this->db->where('tanggal <=', $end_date);
        }
        $barang_masuk = $this->db->get('barang_masuk')->result_array();

        // Gabungkan hasil filter dari kedua tabel
        $penyusutan = array_merge($pemakaian, $barang_masuk);

        return $penyusutan;
    }
}

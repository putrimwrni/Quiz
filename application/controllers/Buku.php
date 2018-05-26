<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Buku extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Buku_model');
        $this->load->model('Kategori_model');
        $this->load->library('pagination');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->database();


        // Konfigurasi Upload
        $config['upload_path']          = './assets/uploads/';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = 2000;
        $config['max_width']            = 800;
        $config['max_height']           = 800;

        $this->load->library('upload', $config);
    }

    public function index()
    {
        $search = ($this->input->post("book_name"))? $this->input->post("book_name") : "NIL";

        $search = ($this->uri->segment(3)) ? $this->uri->segment(3) : $search;

        $data = [];
        $total = $this->Buku_model->getTotal($search);
        if ($total > 0) {
            $limit = 2;
            $start = $this->uri->segment(4, 0);
            $config = [
                'base_url' => site_url() . '/buku/index/' . $search,
                'total_rows' => $total,
                'per_page' => $limit,
                'uri_segment' => 4,
                // Bootstrap 3 Pagination
                'first_link' => '&laquo;',
                'last_link' => '&raquo;',
                'next_link' => 'Next',
                'prev_link' => 'Prev',
                'full_tag_open' => '<ul class="pagination">',
                'full_tag_close' => '</ul>',
                'num_tag_open' => '<li>',
                'num_tag_close' => '</li>',
                'cur_tag_open' => '<li class="active"><span>',
                'cur_tag_close' => '<span class="sr-only">(current)</span></span></li>',
                'next_tag_open' => '<li>',
                'next_tag_close' => '</li>',
                'prev_tag_open' => '<li>',
                'prev_tag_close' => '</li>',
                'first_tag_open' => '<li>',
                'first_tag_close' => '</li>',
                'last_tag_open' => '<li>',
                'last_tag_close' => '</li>',
            ];
            $this->pagination->initialize($config);
            $data = [
                'title' => 'Katalog Buku :: Data Buku',
                'buku' => $this->Buku_model->list($limit, $start, $search),
                'links' => $this->pagination->create_links()
            ];
        }
       

        $this->load->view('buku/index', $data);
    }

    public function create($error='')
    {
        $kategori = $this->Kategori_model->list();
        $data = [
            'error' => $error,
            'data' => $kategori
        ];
        $this->load->view('buku/create', $data);
    }

    public function show($id_buku)
    {
        $buku = $this->Buku_model->show($id_buku);
        $data = [
            'data' => $buku
        ];
        $this->load->view('buku/show', $data);
    }
    
    public function store()
    {
        // Ambil value 
        $judul = $this->input->post('judul');
        $kategori = $this->input->post('kategori');

        // Validasi 
        $dataval = $judul;
        $errorval = $this->validate($dataval);

        // Pesan Error atau Upload
        if ($errorval==false)
        {
            // Percobaan Upload
            if ( ! $this->upload->do_upload('foto'))
            {
                $error = $this->upload->display_errors();
                $this->create($error);
            }
            else
            {
                // Insert data
                $data = [
                    'judul' => $judul,
                    'id_kategori' => $kategori,
                    'foto' => $this->upload->data('file_name')
                    ];
                $result = $this->Buku_model->insert($data);
                
                if ($result)
                {
                    redirect(buku);
                }
                else
                {
                    $error = array('error' => 'Gagal');
                    $this->load->view('buku/create', $error);
                }
            }
        }
        else
        {
            $error = validation_errors();
            $this->create($error);
        }
    }

    public function edit($id_buku,$error='')
    {
      // TODO: tampilkan view edit data
        $buku = $this->Buku_model->show($id_buku);
        $kategori = $this->Kategori_model->list();
        $data = [
            'data' => $buku,
            'datakat' => $kategori,
            'error' => $error
        ];
        $this->load->view('buku/edit', $data);
      
    }

    public function update($id_buku)
    {
        //Ambil Value
        $id_buku=$this->input->post('id_buku');
        $judul = $this->input->post('judul');
        $id_kategori=$this->input->post('id_kategori');

        // Validasi Nama dan Jabatan
        $dataval = [
            'judul' => $judul,
            'kategori' => $kategori
            ];
        $errorval = $this->validate($dataval);

        if ($errorval==false)
        {
            if ( ! $this->upload->do_upload('foto'))
            {
                $data = [
                    'judul' => $judul,  
                    'id_kategori' => $kategori
                    ];
                $result = $this->Buku_model->update($id_buku,$data);

                if ($result)
                {
                    redirect('buku');
                }
                else
                {
                    $data = array('error' => 'Gagal');
                    $this->load->view('buku/edit', $data);
                }
            }
            else
            {
                $data = [
                    'judul' => $judul,
                    'id_kategori' => $kategori,
                    'foto' => $this->upload->data('file_name')
                    ];
                $result = $this->Buku_model->update($id_buku,$data);
                
                if ($result)
                {
                    redirect('buku');
                }
                else
                {
                    $data = array('error' => 'Gagal');
                    $this->load->view('buku/edit', $data);
                }
            }
        }
        else
        {
            $error = validation_errors();
            $this->edit($id_buku,$error);
        }

        
    }

    public function destroy($id_buku)
    {
        $buku = $this->Buku_model->show($id_buku);

        unlink('./assets/uploads/'.$buku->foto);
        
        $this->Buku_model->delete($id_buku);

        redirect('buku');
    }

    public function validate($dataval)
    {
        // Validasi Nama dan Jabatan
        $rules = [
            [
                'field' => 'judul',
                'label' => 'Judul',
                'rules' => 'trim|required'
            ]
          ];

        $this->form_validation->set_rules($rules);

        if (! $this->form_validation->run())
        { return true; }
        else
        { return false; }
    } 
}

/* End of file Controllername.php */

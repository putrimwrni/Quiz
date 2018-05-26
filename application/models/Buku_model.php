<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Buku_model extends CI_Model {

    public function list($limit, $start, $search)
    {        
        $this->db->select('*');
        
        $this->db->join('kategori', 'buku.id_kategori=kategori.id_kategori');

        if($search != 'NIL')
        {
            $this->db->like('judul', $search);
        }
        $query = $this->db->get('buku',$limit, $start);
        return ($query->num_rows() > 0) ? $query->result() : false;
    }

    public function insert($data = [])
    {
        $result = $this->db->insert('buku', $data);
        return $result;
    }

    public function getTotal($search)
    {
        $this->db->select('*');
        
        $this->db->join('kategori', 'buku.id_kategori=kategori.id_kategori');
        if($search != 'NIL')
        {
            $this->db->like('judul', $search);
        }
        return $this->db->count_all_results('buku');
    }

    public function show($id_buku)
    {
        $this->db->select('*');
        $this->db->from('buku'); 
        $this->db->join('kategori', 'buku.id_kategori=kategori.id_kategori');
        $this->db->where('id_buku',$id_buku);     
        $query = $this->db->get();
        return $query->row();
    }

    public function update($id_buku, $data = [])
    {
        // TODO: set data yang akan di update
        $this->db->where('id_buku', $id_buku);
        $this->db->update('buku', $data);
        return result;
    }
    
    public function delete($id_buku)
    {
        // TODO: tambahkan logic penghapusan data
        $this->db->where('id_buku', $id_buku);

        $this->db->delete('buku');
    }
}

/* End of file ModelName.php */
<?php $this->load->view('layout/base_start') ?>

<div class="container">
  <legend>Lihat Buku</legend>
  <div class="content">
    <div class="form-group">
      <label for="judul">Judul Buku</label>
      <p><?php echo $data->judul ?></p>
    </div>
    <div class="form-group">
      <label for="foto">Foto</label>
      <p><img src="<?php echo base_url('assets/uploads/').$data->foto; ?>"></p>
      <p><?php echo $data->foto ?></p>
    </div>
    <div class="form-group">
      <label for="kategori">Kategori Buku</label>
      <p><?php echo $data->kategori ?></p>
    </div>
    <a class="btn btn-info" href="<?php echo site_url('buku/') ?>">Kembali</a>
  </div>
</div>

<?php $this->load->view('layout/base_end') ?>
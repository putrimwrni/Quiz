<?php $this->load->view('layout/base_start') ?>

<div class="container">

  <legend>Daftar Buku</legend>
  
  <?php echo form_open("buku/index");?>
            <div class="form-group">
                <div class="col-md-6">
                    <input class="form-control" id="book_name" name="book_name" placeholder="Search for Book Name..." type="text" value="<?php echo set_value('book_name'); ?>" />
                </div>
                <div class="col-md-6">
                    <input id="btn_search" name="btn_search" type="submit" class="btn btn-danger" value="Search" />
                    <a href="<?php echo site_url(). "buku/index"; ?>" class="btn btn-primary">Show All</a>
                </div>
            </div>
        <?php echo form_close(); ?>
        </div>
  <div class="col-xs-12 col-sm-12 col-md-12">
  
    <table class="table table-striped">
      <thead>
        <th>No</th>
        <th>Judul</th>
        <th>Kategori</th>
        <th width="200">Foto</th>
        <th>
          <a class="btn btn-primary" href="<?php echo site_url('buku/create/') ?>">
            Tambah
          </a>
        </th>
      </thead>
      <?php if (isset($buku)) { ?>
      <tbody>
        <?php $number = 1; foreach($buku as $row) { ?>
        <tr>
          <td>
            <a href="<?php echo site_url('buku/show/'.$row->id_buku) ?>">
              <?php echo $number++ ?>
            </a>
          </td>
          <td>
            <a href="<?php echo site_url('buku/show/'.$row->id_buku) ?>">
              <?php echo $row->judul ?>
            </a>
          </td>
          <td>
            <a href="<?php echo site_url('buku/show/'.$row->id_buku) ?>">
              <?php echo $row->kategori ?>
            </a>
          </td>
          <td>
              <img src="<?php echo base_url('assets/uploads/').$row->foto; ?>" style="display:block; width:100%; height:100%;">
          </td>
          <td>
            <?php echo form_open('buku/destroy/'.$row->id_buku); ?>
            <a class="btn btn-info" href="<?php echo site_url('buku/edit/'.$row->id_buku) ?>">
              Ubah
            </a>
            <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah anda yakin?')">Hapus</button>
            <?php echo form_close() ?>
          </td>
        </tr>
        <?php } ?>
        
      </tbody>
    </table>
    <?php echo $links; ?>
  <?php }
        else { ?>
          <div>tidak ada data</div>
        <?php } ?>
  </div>
</div>


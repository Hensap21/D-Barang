<?php
//koneksi database
$server     = "localhost";
$user       = "root";
$password   = "";
$database   = "Store";

$koneksi    = mysqli_connect($server, $user, $password, $database) or die(mysqli_error($koneksi));

$q = mysqli_query($koneksi, "SELECT kode FROM tbarang order by kode desc limit 1");
$datax = mysqli_fetch_array($q);
if($datax){
  $no_terakhir = substr($datax['kode'], -3);
  $no = $no_terakhir + 1;

  if ($no > 0 and $no < 100){
    $kode = "00".$no;
  }else if($no > 10 and $no < 100){
    $kode = "0" .$no;
  }else if($no > 100){
    $kode = $no;
  }
}else{
  $kode = "001";
}

$tahun = date('Y');
$vkode = "INV-" . $tahun . '-' . $kode;

//Button Simpan
if (isset($_POST['bsimpan'])) {
  // Edit
  if (isset($_GET['hal']) == "edit") {
    $edit = mysqli_query($koneksi, "UPDATE tbarang SET
                                              nama = '$_POST[tnama]',
                                              asal = '$_POST[tasal]',
                                              jumlah = '$_POST[tjumlah]',
                                              satuan = '$_POST[tsatuan]',
                                              tanggal_diterima = '$_POST[ttanggal_diterima]'
                                      WHERE id_barang = '$_GET[id]'        
                                      ");
    if ($edit) {
      echo "<script>
      alert('Edit data sukses!');
      document.location='index.php';
      </script>";
    } else {
      echo "<script>
      alert('Gagal mengedit data!');
      document.location='index.php';
      </script>";
    }
  } else {
    //simpan  
    $simpan = mysqli_query($koneksi, "INSERT INTO tbarang (kode, nama, asal, jumlah, satuan, tanggal_diterima)
    VALUE ('$_POST[tkode]',
           '$_POST[tnama]',
           '$_POST[tasal]',
           '$_POST[tjumlah]',
           '$_POST[tsatuan]',
           '$_POST[ttanggal_diterima]')
");

    if ($simpan) {
          echo "<script>
          alert('Simpan data sukses!');
          document.location='index.php';
          </script>";
    } else {
          echo "<script>
          alert('Gagal menyimpan data!');
          document.location='index.php';
          </script>";
    }
  }
}

// edit & hapus
$vnama = "";
$vasal = "";
$vjumlah = "";
$vsatuan = "";
$vtanggal_diterima = "";

if (isset($_GET['hal'])) {
  if ($_GET['hal'] == "edit") {
    $tampil = mysqli_query($koneksi, "SELECT * FROM tbarang WHERE id_barang = '$_GET[id]' ");
    $data = mysqli_fetch_array($tampil);
    if ($data) {
      $vkode = $data['kode'];
      $vnama = $data['nama'];
      $vasal = $data['asal'];
      $vjumlah = $data['jumlah'];
      $vsatuan = $data['satuan'];
      $vtanggal_diterima = $data['tanggal_diterima'];
    }
  }else if($_GET['hal'] == "hapus"){
    $hapus = mysqli_query($koneksi, "DELETE FROM tbarang WHERE id_barang = '$_GET[id]'");
    if ($hapus) {
      echo "<script>
      alert('Hapus data sukses!');
      document.location='index.php';
      </script>";
    } else {
      echo "<script>
      alert('Gagal menghapus data!');
      document.location='index.php';
      </script>";
    }
  }
}
?>


<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Data</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>
  <div class="container">
    <h3 class="text-center">Data</h3>
    <div class="row">
      <div class="col-md-8 mx-auto">
        <div class="card">
          <div class="card-header bg-info text-light">
            Form imput data barang
          </div>
          <div class="card-body">
            <form method="POST">
              <div class="mb-2">
                <label class="form-label">Kode Barang</label>
                <input type="text" name="tkode" value="<?= $vkode ?>" class="form-control" placeholder="Masukan Kode Barang">
              </div>
              <div class="mb-2">
                <label class="form-label">Nama Barang</label>
                <input type="text" name="tnama" value="<?= $vnama ?>" class="form-control" placeholder="Masukan nama Barang">
              </div>
              <div class="mb-2">
                <label class="form-label">Asal Barang</label>
                <select class="form-select" name="tasal">
                  <option value="<?= $vasal ?>"><?= $vasal ?></option>
                  <option value="England">England</option>
                  <option value="USA">USA</option>
                  <option value="China">China</option>
                  <option value="Japan">Japan</option>
                  <option value="Germany">Germany</option>
                </select>
              </div>

              <div class="row">
                <div class="col">
                  <div class="mb-2">
                    <label class="form-label">Jumlah</label>
                    <input type="number" name="tjumlah" value="<?= $vjumlah ?>" class="form-control" placeholder="Jumlah Barang">
                  </div>
                </div>

                <div class="col">
                  <div class="mb-2">
                    <label class="form-label">Satuan</label>
                    <select class="form-select" name="tsatuan">
                      <option value="<?= $vsatuan ?>"><?= $vsatuan ?></option>
                      <option value="Unit">Unit</option>
                      <option value="Box">Box</option>
                      <option value="Pcs">Pcs</option>
                    </select>
                  </div>
                </div>

                <div class="col">
                  <div class="mb-2">
                    <label class="form-label">Tanggal Diterima</label>
                    <input type="date" name="ttanggal_diterima" value="<?= $vtanggal_diterima ?>" class="form-control" placeholder="Jumlah Barang">
                  </div>
                </div>

                <div class="text-center">
                  <hr>
                  <button class="btn btn-primary" name="bsimpan" type="submit">simpan</button>
                  <button class="btn btn-danger" name="bkosongkan" type="reset">kosongkan</button>
                </div>

              </div>
            </form>
          </div>
          <div class="card-footer bg-info">

          </div>
        </div>
      </div>

      <div class="card mt-6">
        <div class="card-header bg-info text-light">
          Data Barang
        </div>

        <div class="card-body">
          <div class="col-md-8 mx-auto">
            <form method="POST">
              <div class="input-group mb-3">
                <input type="text" name="tcari" value="<?= @$_POST['tcari'] ?>" class="form-control" placeholder="Masukan Kata Kunci">
                <button class="btn btn-primary" name="bcari" type="submit">Cari</button>
                <button class="btn btn-danger" name="breset" type="reset">Reset</button>
                <button class="btn btn-primary"  name="bcetak" type="submit"><a href="cetak.php" target="_blank">Cetak</a></button>
              </div>
            </form>
          </div>

          <table class="table table-striped table-hover table-border">
            <tr>
              <th>No.</th>
              <th>Kode Barang</th>
              <th>Nama Barang</th>
              <th>Asal Barang</th>
              <th>Jumlah</th>
              <th>Tanggal Diterima</th>
              <th>Aksi</th>
            </tr>

            <?php
            //Tampil data
            $no = 1;

            //Pencarian
            if(isset($_POST['bcari'])){
              $keyword = $_POST['tcari'];
              $q = "SELECT * FROM tbarang WHERE kode like '%$keyword%' or nama like '%$keyword%'or asal like '%$keyword%'order by
              id_barang desc";

            }else{
              $q = "SELECT * FROM tbarang order by id_barang desc";
            }
            
            $tampil = mysqli_query($koneksi, $q);
            while ($data = mysqli_fetch_array($tampil)) :
            ?>


              <tr>
                <td><?= $no++ ?></td>
                <td><?= $data['kode'] ?></td>
                <td><?= $data['nama'] ?></td>
                <td><?= $data['asal'] ?></td>
                <td><?= $data['jumlah'] ?> <?= $data['satuan'] ?> </td>
                <td><?= $data['tanggal_diterima'] ?></td>
                <td>
                  <a href="index.php?hal=edit&id=<?= $data['id_barang'] ?>" class="btn btn-warning">Edit</a>
                  <a href="index.php?hal=hapus&id=<?= $data['id_barang'] ?>" class="btn btn-danger" Onclick="return confirm('Apakah anda Serius menghapus Kenangan ini?')">Hapus</a>
                </td>
              </tr>

            <?php endwhile; ?>
          </table>
        </div>
        <div class="card-footer bg-info">

        </div>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>
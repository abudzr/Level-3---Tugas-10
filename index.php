<?php
//  Koneksi
  $server = "localhost";
  $user = "root";
  $pass = "";
  $database ="arkademy";

  $con = mysqli_connect($server,$user,$pass,$database) or die(mysqli_error($con));

  // save 
  if(isset($_POST['bsimpan']))
  {
    // Pengujian edit
    if($_GET['hal'] ==  "edit")
    {
        $edit = mysqli_query($con, "UPDATE produk set 
                                    nama_produk = '$_POST[nama_produk]',
                                    keterangan = '$_POST[keterangan]',
                                    harga = '$_POST[harga]',
                                    jumlah = '$_POST[jumlah]'
                                    WHERE id_produk = '$_GET[id]'
                                    ");

          if($edit)
          {
            echo "<script>
                    alert('Edit data Sukses!');
                    document.location='index.php';
                  </script>";
          }
          else{
            echo "<script>
                    alert('Edit Data Gagal!');
                    document.location='index.php';
                  </script>";
        
      }
    }
    else
    // simpan
    {
      $simpan = mysqli_query($con, "INSERT INTO produk(nama_produk,keterangan,harga,jumlah)
      VALUES ('$_POST[nama_produk]','$_POST[keterangan]','$_POST[harga]','$_POST[jumlah]')
      ");

        if($simpan)
        {
          echo "<script>
                  alert('Simpan Data Sukses!');
                  document.location='index.php';
                </script>";
        }
        else{
          echo "<script>
                  alert('Simpan Data Gagal!');
                  document.location='index.php';
                </script>";
      }
    }


    
  }

  // edit dan hapus
  if(isset($_GET['hal']))
  {
    // pengujian edit
    if($_GET['hal']== "edit")
    {
      // tampil data
      $tampil = mysqli_query($con,"SELECT * FROM produk WHERE id_produk = '$_GET[id]'");
      $data = mysqli_fetch_array($tampil);
      if($data)
      {
        // 
        $vnama_produk = $data['nama_produk'];
        $vketerangan = $data['keterangan'];
        $vharga = $data['harga'];
        $vjumlah = $data['jumlah'];
      }
    }
    else if($_GET['hal'] == "delete")
    {
      $delete = mysqli_query($con, "DELETE FROM produk WHERE id_produk = '$_GET[id]' ");
      if($delete){
        echo "<script>
                  alert('Hapus Data Sukses!');
                  document.location='index.php';
                </script>";
      }
    }
  }
?>


<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>CRUD Abu Dzar Al-Ghifari</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
  </head>
  <body>
  <div class="container">
    <h1 class="text-center">CRUD</h1>
    <h2 class="text-center">Abu Dzar Al-Ghifari</h2>
    
    <!-- awal card form-->
    <div class="card">
      <div class="card-header bg-warning text-white">
        Form Input Data Produk Arkademy
      </div>
      <div class="card-body">
        <form method="post" action="">
          <div class="form-group">
            <label>Nama Produk</label>
            <input type="text" name="nama_produk" value="<?=@$vnama_produk?>" class="form-control" placeholder="Masukkan Nama Produk" required>
          </div>
          <div class="form-group">
            <label>Keterangan</label>
            <select class="form-control" name="keterangan" >
              <option value="<?=@$vketerangan?>"><?=@$vketerangan?></option>
              <option value="makanan">Makanan</option>
              <option value="minuman">Minuman</option>
              <option value="pakaian">Pakaian</option>
              <option value="furniture">Furniture</option>
              <option value="elektronik">Elektronik</option>
            </select>
          </div>
          <div class="form-group">
            <label>Harga</label>
            <input type="number" name="harga" value="<?=@$vharga?>" class="form-control" placeholder="Harga Produk" required>
          </div>
          <div class="form-group">
            <label>Jumlah</label>
            <input type="number" name="jumlah" value="<?=@$vjumlah?>" class="form-control" placeholder="Jumlah" required><br>
          </div>
          
          <button type="submit" class="btn btn-success" name="bsimpan">Simpan</button>
          <button type="reset" class="btn btn-danger" name="breset">Reset</button>
        </form>
      </div>
    </div>
    <!-- akhir card form -->
    <br>
    <!-- awal card tabel-->
    <div class="card">
      <div class="card-header bg-info text-white">
        Daftar Produk
      </div>
      <div class="card-body">
        <table class="table table-bordered table-striped text-center" >
          <tr>
            <th>No.</th>
            <th>Nama Produk</th>
            <th>Keterangan</th>
            <th>Harga</th>
            <th>Jumlah</th>
            <th>Aksi</th>
          </tr>

          <?php
            $no =1;
            $tampil = mysqli_query($con,"SELECT * FROM produk order by id_produk asc");
            while($data = mysqli_fetch_array($tampil)):
          ?>
          <tr>
            <td><?=$no++;?></td>
            <td><?=$data['nama_produk']?></td>
            <td><?=$data['keterangan']?></td>
            <td><?=$data['harga']?></td>
            <td><?=$data['jumlah']?></td>
            <td>
              <a href="index.php?hal=edit&id=<?=$data['id_produk']?>" class="btn btn-warning">Edit</a>
              <a href="index.php?hal=delete&id=<?=$data['id_produk']?>" onclick="return confirm('Apakah Yakin Akan Menghapus Data?')" class="btn btn-danger">Delete</a>
            </td>
          </tr>
          <?php endwhile;?> 
        </table>
      </div>
    </div>
    <!-- akhir card tabel -->
  </div>
  

  <script type="text/javascript" src="js/bootstrap.min.js"></script>    
  </body>
</html>
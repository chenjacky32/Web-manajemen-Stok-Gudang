<?php
require 'function.php';
require 'cek.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Transaksi Barang Keluar</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.php">CV.Teknik Steel</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                    <div class="nav">
                            <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Stock Barang
                            </a>
                            <a class="nav-link" href="customer.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Data Customer
                            </a>
                            <a class="nav-link" href="supplier.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                 Data Supplier
                            </a>
                            <a class="nav-link" href="masuk.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Barang Masuk
                            </a> 
                            <a class="nav-link" href="keluar.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Barang Keluar
                            </a>
                            <a class="nav-link" href="kelolaadmin.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                               Kelola Admin
                            </a>
                            <a class="nav-link" href="logout.php">  
                                Log Out
                            </a>
                            </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Transaksi Barang Keluar</h1>
                        
                        <div class="card mb-4">  
                            <div class="card-header">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
                            Tambah Barang
                        </button>
                        <a href="exportkeluar.php" class="btn btn-info">Export Data</a>   
                        <br>
                            <div class="row mt-2">   
                                <div class="col-lg-2">
                                <form method="post" class="form-inline"><br>
                                    <label>Tanggal Mulai</label></br>
                                        <input type="date" name="tgl_mulai" class="form-control"> </br>
                                    <label>Tanggal Selesai</label></br>
                                        <input type="date" name="tgl_selesai" class="form-control ml-3"></br>
                                    <button type="submit" name="filter_tgl" class="btn btn-info ml-3">Filter</button>      
                                         </form>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class ="table-responsive">
                                <table class="table table-bordered" id="mauexport" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Nama Barang</th>
                                            <th>Jumlah</th>
                                            <th>Penerima</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php

                                        if(isset($_POST['filter_tgl'])){
                                            $mulai = $_POST['tgl_mulai'];
                                            $selesai= $_POST['tgl_selesai'];

                                            if($mulai!=null || $selesai!=null){

                                            $ambilsemuadatastock = mysqli_query($conn,"select * from keluar ,stock where stock.idbarang = keluar.idbarang 
                                            and tanggal BETWEEN '$mulai' and DATE_ADD('$selesai',INTERVAL 1 DAY)");
                                        } else {
                                            $ambilsemuadatastock = mysqli_query($conn,"select * from keluar ,stock where stock.idbarang = keluar.idbarang");
                                        }

                                        } else {
                                        $ambilsemuadatastock = mysqli_query($conn,"select * from keluar ,stock where stock.idbarang = keluar.idbarang");
                                        }

                                        while($data=mysqli_fetch_array($ambilsemuadatastock)){
                                            $idkeluar   = $data['idkeluar'];
                                            $idbarang   = $data['idbarang'];
                                            $tanggal    = $data['tanggal'];
                                            $namabarang = $data['namabarang'];
                                            $qty        = $data['qty'];
                                            $penerima   = $data['penerima'];
                                        ?>
                                        <tr>
                                            <td><?=$tanggal;?></td>
                                            <td><?=$namabarang;?></td>
                                            <td><?=$qty;?></td>
                                            <td><?=$penerima;?></td>
                                            <td>
                                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#edit<?=$idkeluar;?>">
                                                Edit
                                                </button>
                                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete<?=$idkeluar;?>">
                                                Delete
                                                </button>
                                            </td>
                                        </tr>

                                        <!-- Edit The Modal -->
                                        <div class="modal fade" id="edit<?=$idkeluar;?>">
                                                <div class="modal-dialog">
                                                <div class="modal-content">
                                                
                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                    <h4 class="modal-title">Edit Barang</h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>
                                                    
                                                    <!-- Modal body -->
                                                    <form method="post">
                                                    <div class="modal-body">
                                                    <input type="text" name="penerima" value="<?=$penerima;?>" class="form-control" required>
                                                        </br>
                                                        <input type="number" name="qty" value="<?=$qty;?>" class="form-control" required>
                                                        </br>
                                                    <input type="hidden" name="idbarang" value="<?=$idbarang;?>"> 
                                                    <input type="hidden" name="idkeluar" value="<?=$idkeluar;?>"> 
                                                    <button type="submit" class="btn btn-primary" name="updatebarangkeluar">Submit</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                            <!-- Delete The Modal -->
                                                            <div class="modal fade" id="delete<?=$idkeluar;?>">
                                                                <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                
                                                                    <!-- Modal Header -->
                                                                    <div class="modal-header">
                                                                    <h4 class="modal-title">Hapus Barang Keluar?</h4>
                                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                    </div>
                                                                    
                                                                    <!-- Modal body -->
                                                                    <form method="post">
                                                                    <div class="modal-body">
                                                                    Apakah Anda Yakin ingin menghapus <?=$namabarang;?>?    
                                                                        </br>
                                                                        </br> 
                                                                        <input type="hidden" name="idbarang" value="<?=$idbarang;?>">     
                                                                        <input type="hidden" name="qty" value="<?=$qty;?>">    
                                                                        <input type="hidden" name="idkeluar" value="<?=$idkeluar;?>">  
                                                                    <button type="submit" class="btn btn-danger" name="hapusbarangkeluar">Hapus</button>
                                                                    </div>
                                                                    </form>
                                                    </div>
                                                    </div>
                                                    </div>
                                        
                                        <?php

                                        };
                                        
                                        ?>
                                        </tr>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2022</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>
    <!-- The Modal -->
<div class="modal fade" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Tambah Barang Keluar</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <form method="post">
        <div class="modal-body">
        <select name="barangnya" class="form-control">
<?php
    $ambilsemuadatanya = mysqli_query($conn,"select * from stock");
    while($fetcharray = mysqli_fetch_array($ambilsemuadatanya)){
        $namabarangnya = $fetcharray['namabarang'];
        $idbarangnya = $fetcharray['idbarang'];

        ?>

        <option value="<?=$idbarangnya;?>"><?=$namabarangnya;?></option>
        
        <?php
                }
?>
        </select>     
            <br>
            <input type="number" name="qty" class="form-control" placeholder="qty"required>
            </br>
            <input type="text" name="penerima" class="form-control" placeholder="Penerima"required>
            </br>
          <button type="submit" class="btn btn-primary" name="barangkeluar">Submit</button>
        </div>
        </div>
    </div>
</form>

</html>

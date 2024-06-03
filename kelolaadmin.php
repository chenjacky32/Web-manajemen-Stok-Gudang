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
        <title>Dashboard - CV. Teknik Steel</title>
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
                    <div class="container-fluid ">
                        <h1 class="mt-4">Kelola Admin</h1>
                        </ol>
                            <div class="card mb-4">  
                            <div class="card-header">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
                            Tambah Admin
                            </div>
                        <div class="card-body">
                        <table id="datatablesSimple">
                            <table class="table table-bordered" id="mauexport" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Email Admin</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        <?php
                                        $ambilsemuadataadmin = mysqli_query($conn,"select * from login");
                                        $i = 1;
                                        while($data=mysqli_fetch_array($ambilsemuadataadmin)){
                                            $email      = $data['email'];
                                            $iduser     = $data['id_user'];
                                            $password   = $data['password'];
                
                                        ?>
                                        <tr>
                                            <td><?=$i++;?></td>
                                            <td><?=$email;?></td>
                                            <td>
                                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#edit<?=$iduser;?>">
                                                Edit
                                                </button>
                                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete<?=$iduser;?>">
                                                Delete
                                                </button>
                                            </td>
                                        </tr>
                                        
                                            <!-- Edit The Modal -->
                                            <div class="modal fade" id="edit<?=$iduser;?>">
                                                <div class="modal-dialog">
                                                <div class="modal-content">
                                                
                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                    <h4 class="modal-title">Edit User</h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>
                                                    
                                                    <!-- Modal body -->
                                                    <form method="post">
                                                    <div class="modal-body">
                                                    <input type="email" name="emailadmin" value="<?=$email;?>" class="form-control" placeholder="Email" required>
                                                        </br>
                                                    <input type="password" name="passwordbaru"  value="<?=$password;?>"class="form-control" placeholder="password">
                                                        </br>
                                                    <input type="hidden" name="iduser" value="<?=$iduser;?>"> 
                                                    <button type="submit" class="btn btn-primary" name="updateadmin">Submit</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                                    </div>
                                                </div>
                                            </div>
                                                            <!-- Delete The Modal -->
                                                            <div class="modal fade" id="delete<?=$iduser;?>">
                                                                <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                
                                                                    <!-- Modal Header -->
                                                                    <div class="modal-header">
                                                                    <h4 class="modal-title">Hapus User?</h4>
                                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                    </div>
                                                                    
                                                                    <!-- Modal body -->
                                                                    <form method="post">
                                                                    <div class="modal-body">
                                                                    Apakah Anda Yakin ingin menghapus <?=$email;?>?
                                                                        </br>
                                                                        </br> 
                                                                        <input type="hidden" name="iduser" value="<?=$iduser;?>">       
                                                                    <button type="submit" class="btn btn-danger" name="hapusadmin">Hapus</button>
                                                                    </div>
                                                                    </form>
                                                    </div>
                                                    </div>
                                                    </div>
                                        <?php

                                        };
                                        
                                        ?>
                                    </tbody>
                                </table>
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
          <h4 class="modal-title">Tambah Admin</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <form method="post">
        <div class="modal-body">
          <input type="email" name="email" placeholder="Email" class="form-control" required>
            </br>
          <input type="password" name="password" placeholder="Password" class="form-control" required>
            </br>
          <button type="submit" class="btn btn-primary" name="addnewadmin">Submit</button>
        </div>
        </div>
    </div>
</form>

    </html>

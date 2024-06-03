<?php
session_start(); 
//buat koneksi ke database
$conn = mysqli_connect("localhost","root","","stokbarang");





//input nama barang baru
if(isset($_POST['addnewbarang'])){
    $namabarang = $_POST['namabarang'];
    $deskripsi = $_POST['deskripsi'];
    $stock= $_POST['stock'];
 
    $addtotable = mysqli_query($conn,"insert into stock (namabarang, deskripsi, stock) values('$namabarang','$deskripsi','$stock')");
    if($addtotable){
        header('location:index.php');
    } else {
        echo 'Gagal';
        header('location:index.php');
    }
}

//menambah barang masuk
if(isset($_POST['barangmasuk'])){
    $barangnya  = $_POST['barangnya'];
    $penerima   = $_POST['penerima'];
    $qty        = $_POST['qty'];   

    $cekkstocksekarang = mysqli_query($conn,"select * from stock where idbarang='$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekkstocksekarang);

    $stocksekarang = $ambildatanya['stock'];
    $tambahkanstocksekarangdenganqty = $stocksekarang + $qty;

    $addtomasuk = mysqli_query($conn,"insert into masuk (idbarang, keterangan, qty) values ('$barangnya','$penerima','$qty')");
    $updatestockmasuk = mysqli_query($conn,"update stock set stock='$tambahkanstocksekarangdenganqty' where idbarang= '$barangnya'");
    if($addtomasuk&&$updatestockmasuk){
        header('location:masuk.php');
    } else {
        echo 'Gagal';
        header('location:masuk.php');
    }
}

//menambah barang keluar
if(isset($_POST['barangkeluar'])){
    $barangnya  = $_POST['barangnya'];
    $penerima   = $_POST['penerima'];
    $qty        = $_POST['qty'];   

    $cekkstocksekarang = mysqli_query($conn,"select * from stock where idbarang='$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekkstocksekarang);

    $stocksekarang = $ambildatanya['stock'];

    if($stocksekarang >= $qty){
//kalau barangnya cukup
    $kurangkanstocksekarangdenganqty = $stocksekarang - $qty;

    $addtokeluar = mysqli_query($conn,"insert into keluar (idbarang, penerima, qty) values ('$barangnya','$penerima','$qty')");
    $updatestockkeluar = mysqli_query($conn,"update stock set stock='$kurangkanstocksekarangdenganqty' where idbarang= '$barangnya'");
    if($addtokeluar&&$updatestockmasuk){
        header('location:keluar.php');
    } else {
        echo 'Gagal';
        header('location:keluar.php');
    }

} else {
    //kalau barangnya ga cukup
    echo ' <script>
        alert("Maaf stock untuk saat ini tidak mencukupi");
        window.location.href="keluar.php";
        </script>
        ';
}
}





//update info barang

if(isset($_POST['updatebarang'])){
    $idbarang       = $_POST['idb'];
    $namabarang     = $_POST['namabarang'];
    $deskripsi      = $_POST['deskripsi'];   

    $update = mysqli_query($conn,"update stock set namabarang='$namabarang', deskripsi='$deskripsi' where idbarang= '$idbarang'");
    if($update){      
        header('location:index.php');
    } else {
        echo 'Gagal';
        header('location:index.php');

    }
}





//Hapus Barang dari stock
if(isset($_POST['hapusbarang'])){
    $idbarang      = $_POST['idb'];

    $hapus = mysqli_query($conn, "delete from stock where idbarang='$idbarang'");
    if($hapus){      
        header('location:index.php');
    } else {
        echo 'Gagal';
        header('location:index.php');

    }
};







//Mengubah Data Barang Masuk
if(isset($_POST['updatebarangmasuk'])){
    $idbarang       = $_POST['idbarang'];
    $idmasuk        = $_POST['idmasuk'];
    $keterangan      = $_POST['keterangan'];
    $qty            = $_POST['qty'];
    
    $lihatstock = mysqli_query($conn,"select * from stock where idbarang='$idbarang'");
    $stocknya   = mysqli_fetch_array($lihatstock);
    $stockskrng = $stocknya['stock'];

    $qtyskrng = mysqli_query($conn,"select * from masuk where idmasuk='$idmasuk'");
    $qtynya   = mysqli_fetch_array($qtyskrng);
    $qtyskrng = $qtynya['qty'];
    
    if($qty>$qtyskrng){
        $selisih   =    $qty-$qtyskrng;
        $tambahin   =    $stockskrng + $selisih;
        $tambahinstocknya =  mysqli_query($conn, "update stock set stock='$tambahin' where idbarang='$idbarang'" );
        $updatenya  = mysqli_query($conn,"update masuk set qty='$qty', keterangan='$keterangan' where idmasuk='$idmasuk'");
            if($tambahinistocknya&&$updatenya){
                header('location:masuk.php');
                } else {
                    echo 'Gagal';
                    header('location:masuk.php');
        }
    }else{
        $selisih   = $qtyskrng-$qty;
        $tambahin   = $stocksekarang - $selisih;
        $tambahinstocknya =  mysqli_query($conn,"update stock set stock='$tambahin' where idbarang='$idbarang'");
        $updatenya  = mysqli_query($conn,"update masuk set qty='$qty',keterangan='$keterangan'  where idmasuk='$idmasuk'");
    if($stocknya&&$updatenya){
        header('location:masuk.php');
                } else {
                    echo 'Gagal';
                    header('location:masuk.php');
                }
    }
}





//menghapus barang masuk
if(isset($_POST['hapusbarangmasuk'])){
    $idbarang   = $_POST['idbarang'];
    $qty        = $_POST['qty'];
    $idmasuk    = $_POST['idmasuk'];

    $getdatastock   =  mysqli_query($conn,"select * from stock where idbarang='$idbarang'");
    $data           =  mysqli_fetch_array($getdatastock);
    $stock          =  $data['stock'];

    $selisih        =   $stock-$qty;

    $update = mysqli_query($conn,"update stock set stock='$selisih' where idbarang='$idbarang'");
    $hapusdata  = mysqli_query($conn,"delete from masuk where idmasuk='$idmasuk'");

    if($update&&$hapusdata){
    header('location:masuk.php');
} else {
    header('location:masuk.php');
    echo 'Gagal';
    }
}



//Mengubah Data Barang Keluar
if(isset($_POST['updatebarangkeluar'])){
    $idbarang       = $_POST['idbarang'];
    $idkeluar       = $_POST['idkeluar'];
    $penerima       = $_POST['penerima'];
    $qty            = $_POST['qty'];
    
    $lihatstock = mysqli_query($conn,"select * from stock where idbarang='$idbarang'");
    $stocknya   = mysqli_fetch_array($lihatstock);
    $stockskrng = $stocknya['stock'];

    $qtyskrng = mysqli_query($conn,"select * from keluar where idkeluar='$idkeluar'");
    $qtynya   = mysqli_fetch_array($qtyskrng);
    $qtyskrng = $qtynya['qty'];
    
    if($qty>$qtyskrng){
        $selisih   =    $qty-$qtyskrng;
        $kurangin  =    $stockskrng-$selisih;
        $kurangistocknya =  mysqli_query($conn, "update stock set stock='$kurangin' where idbarang='$idbarang'" );
        $updatenya  = mysqli_query($conn,"update keluar set qty='$qty', penerima='$penerima' where idkeluar='$idkeluar'");
            if($kurangistocknya&&$updatenya){
                header('location:keluar.php');
                } else {
                    echo 'Gagal';
                    header('location:keluar.php');
        }
    }else{
        $selisih   = $qtyskrng-$qty;
        $kurangin   = $stocksekarang + $selisih;
        $kurangistocknya =  mysqli_query($conn,"update stock set stock='$kurangin' where idbarang='$idbarang'");
        $updatenya  = mysqli_query($conn,"update keluar set qty='$qty',penerima='$penerima'  where idkeluar='$idkeluar'");
    if($kurangistocknya&&$updatenya){
        header('location:keluar.php');
                } else {
                    echo 'Gagal';
                    header('location:keluar.php');
        

                }
    }
}


//menghapus barang keluar

if(isset($_POST['hapusbarangkeluar'])){
    $idbarang   = $_POST['idbarang'];
    $qty        = $_POST['qty'];
    $idkeluar   = $_POST['idkeluar'];

    $getdatastock   =  mysqli_query($conn,"select * from stock where idbarang='$idbarang'");
    $data           =  mysqli_fetch_array($getdatastock);
    $stock          =  $data['stock'];

    $selisih        =   $stock+$qty;

    $update = mysqli_query($conn,"update stock set stock='$selisih' where idbarang='$idbarang'");
    $hapusdata  = mysqli_query($conn,"delete from keluar where idkeluar='$idkeluar'");

    if($update&&$hapusdata){
    header('location:keluar.php');
} else {
    header('location:keluar.php');

    }
}

//tambah admin baru
if(isset($_POST['addnewadmin'])){
    $email          = $_POST['email'];
    $password       = $_POST['password'];
  
    $queryinsert   =  mysqli_query($conn,"insert into login (email, password) values ('$email','$password')");

    if($queryinsert){
    header('location:kelolaadmin.php');
} else {
    header('location:kelolaadmin.php');

    }
}

//edit data admin

if(isset($_POST['updateadmin'])){
    $email          = $_POST['emailadmin'];
    $password       = $_POST['passwordbaru'];
    $idnya          = $_POST['iduser'];
    
    $update = mysqli_query($conn,"update login set email='$email', password='$password'  where id_user ='$idnya'");
    
    if($update){
        header('location:kelolaadmin.php');
                } else {
                    header('location:kelolaadmin.php');
    
                }
    }

    //hapus data admin
    if(isset($_POST['hapusadmin'])){
        $idnya   =$_POST['iduser'];       
        $querydelete  = mysqli_query($conn,"delete from login where id_user='$idnya'");
    
        if($querydelete){
            header('location:kelolaadmin.php');
        } else {
            header('location:kelolaadmin.php');
        }
    }



    ////tambah supplier baru
if(isset($_POST['addnewsupplier'])){
    $namasupplier          = $_POST['namasupplier'];
    $alamat                = $_POST['alamat'];
    $hp                    = $_POST['hp'];
  
    $queryinsert   =  mysqli_query($conn,"insert into supplier (namasupplier, alamat, hp) values ('$namasupplier','$alamat','$hp')");

    if($queryinsert){
    header('location:supplier.php');
} else {
    header('location:supplier.php');

    }
}

//edit data supplier

if(isset($_POST['updates'])){
    $namasupplier               = $_POST['namasupplier'];
    $alamat                     = $_POST['alamat'];
    $hp                         = $_POST['hp'];
    $idsupp                     = $_POST['idsupplier'];
  
    $updatedata = mysqli_query($conn,"update supplier set namasupplier='$namasupplier', alamat='$alamat', hp='$hp' where idsupplier ='$idsupp'");
    
    if($updatedata){
        header('location:supplier.php');
    } else {
        header('location:supplier.php');
    
        }
    }
    
    
//

    //hapus data admin
    if(isset($_POST['hapussupplier'])){
        $idsupp    =$_POST['idsupplier'];       
        $querydelete  = mysqli_query($conn,"delete from supplier where idsupplier='$idsupp'");
    
        if($querydelete){
            header('location:supplier.php');
        } else {
            header('location:supplier.php');
        
            }
        }


        //

    ////tambah customer baru
if(isset($_POST['addnewcustomer'])){
    $namacustomer          = $_POST['namacustomer'];
    $alamat                = $_POST['alamat'];
    $hp                    = $_POST['hp'];
  
    $queryinsert   =  mysqli_query($conn,"insert into customer (namacustomer, alamat, hp) values ('$namacustomer','$alamat','$hp')");

    if($queryinsert){
    header('location:customer.php');
} else {
    header('location:customer.php');

    }
}

//edit data customer

if(isset($_POST['updates'])){
    $namacustomer               = $_POST['namacustomer'];
    $alamat                     = $_POST['alamat'];
    $hp                         = $_POST['hp'];
    $idcust                     = $_POST['idcust'];
  
    $updatedata = mysqli_query($conn,"update customer set namacustomer='$namacustomer', alamat='$alamat', hp='$hp' where idcustomer ='$idcust'");
    
    if($updatedata){
        header('location:customer.php');
    } else {
        header('location:customer.php');
    
        }
    }
    
    
//

    //hapus data customer
    if(isset($_POST['hapuscustomer'])){
        $idcust    =$_POST['idcust'];       
        $querydelete  = mysqli_query($conn,"delete from customer where idcustomer='$idcust'");
    
        if($querydelete){
            header('location:customer.php');
        } else {
            header('location:customer.php');
        
            }
        }

?>

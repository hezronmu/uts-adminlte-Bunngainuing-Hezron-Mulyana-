<?php include 'koneksi.php';
$limit = $_GET['limit'] ?? 5; $page = $_GET['page'] ?? 1; $offset=($page-1)*$limit;
$search_name=$_GET['search_name'] ?? ''; $search_predikat=$_GET['search_predikat'] ?? 'Semua';
$sort=$_GET['sort'] ?? 'nim'; $order=$_GET['order'] ?? 'ASC'; $next=$order=='ASC'?'DESC':'ASC';
$where="WHERE 1=1 "; if($search_name!='') $where.="AND nama_mahasiswa LIKE '%$search_name%' ";
if($search_predikat!='Semua' && $search_predikat!='') $where.="AND predikat='$search_predikat' ";
$tot=mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) as tot FROM nilaimhsw $where"))['tot'];
$pages=ceil($tot/$limit); $q=mysqli_query($conn,"SELECT * FROM nilaimhsw $where ORDER BY $sort $order LIMIT $offset,$limit");
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
<div class="container mt-3"><h3>Data Mahasiswa</h3>
<form><input name="search_name" value="<?=$search_name?>" placeholder="Cari nama"><select name="search_predikat"><option>Semua</option><option <?=($search_predikat=='Memuaskan'?'selected':'')?>>Memuaskan</option><option <?=($search_predikat=='Sangat Memuaskan'?'selected':'')?>>Sangat Memuaskan</option><option <?=($search_predikat=='Dengan Pujian'?'selected':'')?>>Dengan Pujian</option></select><button>Cari</button></form><br>
<table class="table table-bordered"><tr><th>Foto</th><th>NIM</th><th>Nama</th><th>Nilai</th><th>Predikat</th></tr>
<?php while($r=mysqli_fetch_assoc($q)){?><tr><td><img src="<?=$r['file_path']?>" style="width:45px;height:45px;border-radius:50%;object-fit:cover"></td><td><?=$r['nim']?></td><td><?=$r['nama_mahasiswa']?></td><td><?=$r['nilai']?></td><td><?=$r['predikat']?></td></tr><?php }?></table></div>
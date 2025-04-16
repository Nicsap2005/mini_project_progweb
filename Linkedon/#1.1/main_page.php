<?php
include "method.php";
$conn = openDB("localhost","root","","linkedon");
$tipe = companyOrClient($conn);
$current = $conn->query("select * from current_$tipe");
$curRow = $current->fetch_assoc();
$curEmail = $curRow["_email"];

$result = $conn->query("select * from $tipe where _email = '$curEmail'");
$row = $result->fetch_assoc();
$usertype = $row["_user_type"];
$curusertype = "current_".$row["_user_type"];

$mainPageResult = $conn->query("SELECT *,FORMAT(_gaji, 0, 'de_DE') AS gaji FROM loker");
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    if (isset($_POST["form_type"])) {
        if ($_POST["form_type"] == "deleteAccount"){
            DeleteAccount($conn,$curEmail,$usertype);
            header("location: login_page.php");
        }
        if ($_POST["form_type"] == "logout"){
            truncateTable($conn,$curusertype);
            header("location: login_page.php");
        }    
    }
    if (isset($_POST["detailLowongan"])) {
        truncateTable($conn,"detaillowongan");
        list($namaPerusahaan, $job) = explode("|", $_POST["detailLowongan"]);
        $conn->query("INSERT INTO detaillowongan values('$namaPerusahaan','$job',false)");
        header("location: detail.php");
    }
    if (isset($_POST["Search"])) {
        $Nama =  $_POST["Nama"];
        $Kategori =  $_POST["Job"];
        $Lokasi =  $_POST["Lokasi"];
        $Tipe =  $_POST["Tipe"];
        $Gaji =  $_POST["Gaji"];
        $query = mainPage($Nama,$Kategori,$Lokasi,$Tipe,$Gaji);
        $mainPageResult = $conn->query($query);
        
    }
    if (isset($_POST["buatLowongan"])) {
        header("location: pengajuanPage.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/tampilan_halaman.css">
    <link rel="stylesheet" href="style/tampilan_main.css">
    <title>Document</title>
</head>

<body>
    <header>
        <span><h1 style="text-align:left"><b>LinkedOn</b></h1></span>
        <div class="dropdown">
        <button class="dropbtn"><img src="../decoration/menuHamburger.png" width="50px" alt=""></button>
        <div class="dropdown-content">
                <form action="" method="post"> 
                    <input type="hidden" name="form_type" value="Account">
                    <button type="submit" class="Account">
                        <table>
                                <td>
                                    <img src="../decoration/profile.png" width="60px" alt="">
                                </td>
                                <td>
                                    <?php echo getName($conn,$curEmail);?>
                                </td>
                        </table>
                    </button>
                </form>
                <?php 
                if ($usertype == "Company"){
                    echo "
                    <form action='' method='post'>
                        <input type='hidden' name='buatLowongan' value='Lowongan'>
                        <button type='submit' class='logout-button' style='background-color:limegreen'>Buat Lowongan</button>
                    </form>";
                }
                ?>
                <form action="" method="post"> 
                    <input type="hidden" name="form_type" value="deleteAccount">
                    <button type="submit" class="logout-button">Delete Account</button>
                </form>
                <form action="" method="post"> 
                    <input type="hidden" name="form_type" value="logout">
                    <button type="submit" class="logout-button">Logout</button>
                </form>
            </div>
        </div> 
        <h1>Lowongan Pekerjaan</h1>
    </header>
    
    <div class="hero">
        <h2>Temukan Pekerjaan Impianmu!!</h2>
        <h4>Mulai Karirmu Sekarang</h4>
    </div>
    



    <div class="search-box">
        <form action="" method="post">
            <input type="hidden" name="Search" value="">
            <input style="width: 20%;" name="Nama" type="text" placeholder="Nama Perusahaan"> 
            <select name = "Job">
                <option value="">Job</option>
                <?php 
                    $option = $conn->query("SELECT DISTINCT _job FROM loker");
                    while ($row = $option->fetch_assoc()) {
                        echo "<option value = \"{$row['_job']}\">{$row['_job']}</option>";
                    }
                ?>
            </select>
            <select name = "Lokasi">
                <option value="">Semua Lokasi</option>
                <?php
                $option = $conn->query("SELECT DISTINCT _alamat FROM loker");
                while ($row = $option->fetch_assoc()) {
                    echo "<option value =\"{$row['_alamat']}\">{$row['_alamat']}</option>";
                } 
                ?>
            </select>
            <select name = "Tipe">
                <option value="">Semua Jenis</option>
                <?php
                $option = $conn->query("SELECT DISTINCT _tipe FROM loker");
                while ($row = $option->fetch_assoc()) {
                    echo "<option value=\"{$row['_tipe']}\">{$row['_tipe']}</option>";
                } 
                ?>
            </select>
            <input style="width: 20%;" name = "Gaji" type="text" placeholder="gaji: 100000000-30000000">
            <button type="submit"><img width="15px" src="../decoration/search.png  " alt=""></button>
        </form>
    </div>

        
        <?php
       
        if ($mainPageResult->num_rows > 0) {
            $counter = 0;
            echo "<div class='job-container'>";
            while ($row = $mainPageResult->fetch_assoc()) {
                $pict = $row['_pictpath'];
                echo"<div class='job-item'>
                            <td><img src='$pict' alt='' width = 150px></td>
                            <h2><b>{$row['_job']}</b></h2>
                            <p>Perusahaan: {$row['_namaPerusahaan']}</p>
                            <p>Jenis: {$row['_tipe']}</p>
                            <p>Gaji: Rp {$row['_gaji']}/{$row['_gajiPer']}</p>
                            <form action='' method='post'> 
                                <input type='hidden' name='detailLowongan' value='" . htmlspecialchars($row["_namaPerusahaan"] . "|" . $row["_job"], ENT_QUOTES, 'UTF-8') . "'>
                                <button type='submit' class='btn'>Lihat Detail</button>
                            </form>
                        </div>
                        ";
                }
            echo "</div>";
        } else {
            echo "No records found";
        }
        $conn->close();
        ?>
    <footer>
    2025 Portal Lowongan Kerja | Dibuat dengan sepenuh hati😍
    </footer>
    
</body>
    </html>
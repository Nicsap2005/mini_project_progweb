<?php
function DeleteAccount($conn,$curEmail,$usertype){
    $conn->query("Delete from $usertype where _email = '$curEmail'");
    truncateTable($conn,"current_".$usertype);
}

function truncateTable($conn,$usertype) {
    $conn->query("truncate table $usertype");
   
}

function getEmail($conn){
    $email = null;
    $tipe= companyOrClient($conn);
    if ($tipe == "company"){
        $email = $conn->query("SELECT _email FROM current_company");
    }
    else if ($tipe == "client"){
        $email = $conn->query("SELECT _email FROM current_client");
    }
    $email = $email->fetch_assoc()["_email"];
    return $email;
}

function companyOrClient($conn){
    $checkCompany = $conn->query("SELECT * FROM current_company");
    $checkClient = $conn->query("SELECT * FROM current_client");
    if ($checkCompany->num_rows > 0){
        return "company";
    }
    else if($checkClient->num_rows > 0){
        return "client";
    }
    else{
        return null;
    }
}
function getTypeFromEmail($conn,$email){
    $checkCompany= $conn->query("select * from company where _email = '$email'");
    $checkClient= $conn->query("select * from client where _email = '$email'");
    if ($checkCompany->num_rows>0){
        return "company";
    }
    else if ($checkClient->num_rows>0){
        return "client";
    }
}


function registerClient($conn,$email,$password,$namdep,$nambel,$tanggalLahir,$alamat,$target_file,$tipe_user){
    $conn->query("INSERT INTO client VALUES('$email','$password','$namdep','$nambel','$tanggalLahir','$alamat','$target_file','$tipe_user')");
    return checkUser($conn,$email,$tipe_user);
}
function registerCompany($conn,$email,$password,$namaperusahaan,$tanggalberdiri,$alamat,$target_file,$tipe_user){
    $conn->query("INSERT INTO company VALUES('$email','$password','$namaperusahaan','$tanggalberdiri','$alamat','$target_file','$tipe_user')");
    return checkUser($conn,$email,$tipe_user);
}

function getName($conn,$email){
    $tipe = getTypeFromEmail($conn,$email);
    if ($tipe == "company"){
        return getCompanyName($conn,$email);
    }
    else if ($tipe == "client"){
        return getClientName($conn,$email);
    }
}

function getClientName($conn,$email){
    $row = $conn->query("SELECT _namadepan,_namabelakang from client where _email = '$email'");
    $row = $row->fetch_assoc();
    return $row["_namadepan"]." ".$row["_namabelakang"];
}

function getCompanyName($conn,$email){
    $row = $conn->query("SELECT _namaPerusahaan from company where _email = '$email'");
    $row = $row->fetch_assoc();
    return $row["_namaPerusahaan"];
}

function checkUser($conn,$email,$tipe_user){
    $check = $conn->query("SELECT * FROM $tipe_user WHERE _email = '$email'");
    return $check->num_rows > 0;
}

function checkCV($conn,$name,$namaPerusahaan,$job){
    $result = $conn->query("select * from cv where _nama = '$name' and _namaPerusahaan = '$namaPerusahaan' and _job = '$job'");
    return $result->num_rows > 0;
}

function getFile($folder){
    $target_dir = $folder."/";
    // Get file extension
    $file_extension = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
    // Generate a unique filename using timestamp
    $new_filename = time() . "." . $file_extension;
    $target_file = $target_dir . $new_filename; // pict path
    move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
    return $target_file;
}

function getPDF($folder) {
    if (!isset($_FILES["pdf"]) || $_FILES["pdf"]["error"] !== UPLOAD_ERR_OK) {
        return false;
    }

    $file_extension = strtolower(pathinfo($_FILES["pdf"]["name"], PATHINFO_EXTENSION));
    if ($file_extension !== "pdf") {
        return false;
    }

    $new_filename = time() . ".pdf";
    $target_file = rtrim($folder, "/") . "/" . $new_filename;

    return move_uploaded_file($_FILES["pdf"]["tmp_name"], $target_file) ? $target_file : false;
}

function openDB($servername,$username,$password,$dbname){
    $conn = new mysqli($servername,$username,$password,$dbname);
    return $conn;
}

function closeDB($conn){
    $conn->close();
}

function mainPage($nama,$job,$lokasi,$tipe,$gaji){
    $query = "SELECT * FROM loker WHERE ";
    $input = [$nama,$job,$lokasi,$tipe,$gaji];
    $cell = ["_namaPerusahaan","_job","_alamat","_tipe","_gaji"];
    $temp = [];
    $counter = 0;
    for ($i = 0; $i < count($input); $i++) {
        if ($input[$i] != ""){
            if ($cell[$i] == "_gaji"){
                $arrGaji = explode("-",$gaji);
                $cellQuery = $cell[$i]."    = ".$arrGaji[0]." < ".$cell[$i]." AND ".$arrGaji[1]." > ".$cell[$i];
            }
            else{
                $cellQuery = $cell[$i]." = ".'"'.$input[$i].'"';
            }
            array_push($temp, $cellQuery);
            $counter += 1;
        }
    }
    $joinedString = implode(' AND ', $temp);
    $query .= $joinedString;
    echo $query;

    if ($counter > 0) {
        return $query;
    }else{
        return 'SELECT * FROM loker';
    }
    }



?>
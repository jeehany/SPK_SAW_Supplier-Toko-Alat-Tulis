<?php
require "include/conn.php";
$id = $_GET['id'];
mysqli_query($db, "DELETE FROM supplier WHERE id_supplier='$id'");
header("location:./supplier.php");

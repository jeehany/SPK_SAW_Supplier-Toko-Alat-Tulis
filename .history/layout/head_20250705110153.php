<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPK - SAW Method</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/spksaw-master/assets/css/bootstrap.css">

    <link rel="stylesheet" href="/spksaw-master/assets/vendors/iconly/bold.css">

    <link rel="stylesheet" href="/spksaw-master/assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="/spksaw-master/assets/vendors/bootstrap-icons/bootstrap-icons.css">
<link rel="stylesheet" href="/spksaw-master/assets/css/app.css">
<link rel="stylesheet" href="/spksaw-master/assets/css/modern-theme.css">
    <link rel="shortcut icon" href="/spksaw-master/assets/images/favicon.png" type="image/x-icon">
</head>
<?php
session_start();
if ($_SESSION['status'] != 'login') {
    header('location:./login.php');
}
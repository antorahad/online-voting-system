<?php
session_start();
require_once("config.php");

if ($_SESSION['key'] != "Adminkey") {
    header("location: ../admin/logout.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Online Voting System</title>
    <!-- Fav link -->
    <link rel="shortcut icon" href="../img/vote.png" type="image/x-icon">
    <!-- CSS link -->
    <link rel="stylesheet" href="../style.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
</head>

<body>
    <header class="header_wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex align-text-center">
                        <a href="../admin/index.php?homePage=1">
                            <img src="../img/vote.png" alt="logo">
                            Online Voting System 
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

   
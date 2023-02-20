<?php 

include "db_connect.php";
include "header.php";

if (isset($_POST['update'])) {
    $user_id = $_POST['user_id'];
    $operator_id = $_POST['operator_id'];
    $part_number = $_POST['part_no'];
    $quantity = $_POST['qty'];
    $receive_date = $_POST['receive_date'];
    $expiry_date = $_POST['expiry_date']; 

    // $sql = "UPDATE `users` SET `first_name`='$firstname',`last_name`='$lastname',`email`='$email',`password`='$password',`gender`='$gender' WHERE `id`='$user_id'"; 
    $sql = "UPDATE `inventory` SET `operator_id` = '$operator_id', `part_no` = '$part_number', `qty` = '$quantity', `receive_date` = '$receive_date', `expiry_date` = '$expiry_date' WHERE `id`='$user_id'"; 
    $result = $conn->query($sql); 

    if ($result == TRUE) {

        echo "Record updated successfully.";

    }else{

        echo "Error:" . $sql . "<br>" . $conn->error;

    }

    header("Location: receiving-list.php");
    exit();

} 

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM `inventory` WHERE `id` = '$id'");

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "Error: Record not found";
    exit;
}

$conn->close();
    
?>
 
<!-- ------------------------------------------------------------------------------------------------------------------------------------- -->

<!DOCTYPE html> 
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>S-EMS</title>
        </head>
    <body class="sb-nav-fixed" style= "background-color: #142739;">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="dashboard.php">S-EMS</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            
            <!-- Navbar-->
            <ul class="navbar-nav d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                <li class="nav-item dropdown">
                    <!-- <a class="btn btn-danger" id="admin" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i> Admin</a> -->
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#!">Settings</a></li>
                        <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item" href="#!">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                    <div class="nav"> 
                            <div class="sb-sidenav-menu-heading"></div>
                            <a class="nav-link" href="dashboard.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-download"></i></div>
                                Supply
                            </a>
                            
                            <a class="nav-link" href="add-receiving.php" >
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-clipboard-check"></i></div>
                                Receiving Expiry Confirmation
                            </a>
                            
                            <a class="nav-link" href="receiving-list.php">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-scroll"></i></div>
                                Inventory <link rel="stylesheet" href="">
                            </a>
                             
                            <a class="nav-link" href="supply-list.php">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-clock-rotate-left"></i></div>
                                Supply - History
                            </a>

                            <a class="nav-link" href="hold-list.php">
                                <div class="sb-nav-link-icon"><i class="fa-regular fa-hand"></i></div>
                                Hold part list <link rel="stylesheet" href="">
                            </a>

                            <a class="nav-link" href="part-list.php">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-boxes-stacked"></i></div>
                                Expiration Maintenance <link rel="stylesheet" href="">
                            </a>

                            <!-- <a class="nav-link" href="users.html">
                                <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                                Users <link rel="stylesheet" href="">
                            </a> -->
                            
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div> 
                        Operator
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        
                        <h1 class="mt-4 text-white">Edit Receiving</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Edit Receiving</li>
                        </ol>
                    
                        <div class="card mb-4">
                            <div class="card-header">
                                <b class="col-sm-4">Edit Receiving</b>
                            </div>
                           
                            <div class="card-body">
                                <!-- Start update receiving -->
                                <form action="" method="POST" autocomplete="off">
                                    
                                    <div class="form-group">
                                        <label for="">Operator ID:</label>
                                        <input type="text" id="operator_id" name="operator_id" class="form-control" style="color: black" value="<?php echo $row['operator_id']; ?>" required>
                                        <input type="hidden" name="user_id" value="<?php echo $id; ?>">
                                           
                                        <label for="">Part Number: </label>
                                        <input type="text" id="part_no" name="part_no" class="form-control" style="color: black" value="<?php echo $row['part_no']; ?>" required>

                                        <label for="">Quantity: </label>
                                        <input type="number" id="qty" name="qty" class="form-control" style="color: black" value="<?php echo $row['qty']; ?>" required>
                                        
                                        <label for="">Received Date: </label>
                                        <input type="date" id="receive_date" name="receive_date" class="form-control" style="color: black" value="<?php echo $row['receive_date']; ?>" required>
                                            
                                        <label for="">Expiry Date: </label>
                                        <input type="date" id="expiry_date" name="expiry_date" class="form-control" style="color: black" value="<?php echo $row['expiry_date']; ?>" required>

                                        <div class="modal-footer">
                                            <a href="receiving-list.php"><button type="button" class="btn btn-default" data-bs-dismiss="modal" >Cancel</button></a>
                                            <input type="submit" value="Update" name="update" class="btn btn-primary">                                        
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </body>
</html>
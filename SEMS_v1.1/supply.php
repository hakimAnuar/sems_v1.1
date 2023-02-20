
<!-- This fx would probably work after looking it more.... -->
<!-- Same fx as hold.php but instead for supply_list table from `inventory` table -->


<?php
include 'db_connect.php';
include 'header.php';

if (isset($_POST['hold'])) {
    $id = $_POST['id'];
    $operator_id = $_POST['operator_id'];
    $part_no = $_POST['part_no'];
    $quantity = $_POST['qty'];
    $expiry_date = $_POST['expiry_date']; 
    $input_date = DateTime::createFromFormat('d/m/Y', $expiry_date);
    $f_date = $input_date->format('Y-m-d');

    $sql = "SELECT * FROM inventory WHERE id = ?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($result->num_rows > 0) {
        $data = mysqli_fetch_assoc($result);
        if($part_number != $row['part_no'] || $f_date != $row['expiry_date']){
        
            echo "<script>alert('Part number or expiry date does not match with the selected parts to be supplied. Please scan the correct item.')</script>";
        
        } else {
    
            if ($quantity > $data['qty']) {
                echo "Error: The entered quantity is greater than the available quantity";
                exit;
            }

            $sql = "SELECT * FROM supply_list WHERE id = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, 'i', $id);
            mysqli_stmt_execute($stmt);
            $supply_result = mysqli_stmt_get_result($stmt);

            if ($supply_result = true) {
            //     $sql = "UPDATE supply_list SET qty = qty + ?, operator_id = '$operator_id' WHERE id = ?";
            //     $stmt = mysqli_prepare($conn, $sql);
            //     mysqli_stmt_bind_param($stmt, 'ii', $quantity, $id);
            //     mysqli_stmt_execute($stmt);
            // } else {
                date_default_timezone_set('Asia/Kuala_Lumpur');
                $supply_date = date('Y-m-d H:i:s');

                $sql = "INSERT INTO supply_list (id, operator_id, part_no, qty, supply_date, expiry_date)
                        VALUES (?, ?, ?, ?, ?, ?, ?)";

                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, 'ississ', $data['id'], $operator_id, $part_no, $quantity, $supply_date, $expiry_date);
                mysqli_stmt_execute($stmt);
            }

            $sql = "UPDATE inventory SET qty = qty - ? WHERE id = ?";

            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, 'ii', $quantity, $id);
            mysqli_stmt_execute($stmt);

            if ($data['qty'] - $quantity == 0) {
                $sql = "DELETE FROM inventory WHERE id = ?";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, 'i', $id);
                mysqli_stmt_execute($stmt);
            }

            header("Location: dashboard.php");
            exit();

        }

    } else {

        echo "Error: Record not found";
        exit;
    }

}

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM `inventory` WHERE `id` = '$id'");

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "Error: Record not found";
    exit;
}

mysqli_close($conn);

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
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>
                            
                            <!-- <a class="nav-link" href="inventory.html" >
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-scroll"></i></div>
                                Inventory
                            </a> -->
                            
                            <a class="nav-link" href="receiving-list.php">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-download"></i></div>
                                Receiving <link rel="stylesheet" href="">
                            </a>
                             
                            <a class="nav-link" href="supply-list.php">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-upload"></i></i></div>
                                Supply
                            </a>

                            <a class="nav-link" href="hold-list.php">
                                <div class="sb-nav-link-icon"><i class="fa-regular fa-hand"></i></div>
                                Hold part list <link rel="stylesheet" href="">
                            </a>

                            <a class="nav-link" href="part-list.php">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-boxes-stacked"></i></div>
                                Part list <link rel="stylesheet" href="">
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
                        
                        <h1 class="mt-4 text-white">Supply Part</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Supplying</li>
                        </ol>
                    
                        <div class="card mb-4">
                            <div class="card-header">
                                <b class="col-sm-4">Supply Part</b>
                            </div>
                           
                            <div class="card-body">
                                <!-- Start Supply part form -->
                                <form action="" method="POST" autocomplete="off">
                                    
                                    <div class="form-group">
                                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                                        
                                        <label for="">Operator ID:</label>
                                        <input type="text" id="operator_id" name="operator_id" class="form-control" style="color: black" value="" required>
                                        
                                        <label for="">Part Number: </label>
                                        <input type="text" id="part_no" name="part_no" class="form-control" style="color: black" value="" required>

                                        <label for="">Quantity: </label>
                                        <input type="number" id="qty" name="qty" class="form-control" style="color: black" value="" required>
                                        
                                        <!-- Change input:date to input:text in order to make scanning possible -->
                                        <label for="">Expiry Date: </label>
                                        <input type="text" id="expiry_date" name="expiry_date" class="form-control" style="color: black" value="" required>

                                        <div class="modal-footer">
                                            <a href="dashboard.php"><button type="button" class="btn btn-default" data-bs-dismiss="modal" >Cancel</button></a>
                                            <input type="submit" value="Supply" name="supply" class="btn btn-primary">                                        
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
<?php 

include "db_connect.php";
include "header.php";

if (isset($_POST['supply'])) {
    $user_id = $_POST['user_id'];
    $operator_id = $_POST['operator_id'];
    $part_no = $_POST['part_no'];
    $quantity = $_POST['qty'];
    $expiry_date = $_POST['expiry_date']; 
    $input_date = DateTime::createFromFormat('d/m/Y', $expiry_date);
    $f_date = $input_date->format('Y-m-d');

    $result = $conn->query("SELECT * FROM `inventory` WHERE `id` = '$user_id'");
    if ($result->num_rows > 0) {
        
        // Check matching part_no and expiry_date
        $row = $result->fetch_assoc();        
        if($part_no != $row['part_no'] || $f_date != $row['expiry_date']){
        
            echo "<script>alert('Part number or expiry date does not match with the selected parts to be supplied. Please scan the correct item.')</script>";
        
        } else {

            $new_quantity = $row['qty'] - $quantity;
            if ($new_quantity < 0 ) {
                    
                echo "<script>alert('Quantity entered is greater than the available quantity')</script>";
                
            } else if ($new_quantity == 0) {

                $sql = "DELETE FROM `inventory` WHERE `id`='$user_id'";
                $result = $conn->query($sql);

                header("Location: dashboard.php");
                exit();
                    
            } else {
                // If possible, try create INSERT INTO supply_list while UPDATE inventory to work simultanoeusly
                $sql = "UPDATE `inventory` SET `part_no` = '$part_no', `qty` = '$new_quantity', `expiry_date` = '$f_date' WHERE `id`='$user_id'"; 
                $result = $conn->query($sql); 
       
                date_default_timezone_set('Asia/Kuala_Lumpur');
                $supply_date = date('Y-m-d H:i:s');
                $sql_supply = "INSERT INTO supply_list(`operator_id`, `part_no`, `qty`, `supply_date`, `expiry_date`)
                               VALUES ('$operator_id', '$part_no', '$quantity', '$supply_date', '$f_date')";
                $supply_result = $conn->query($sql_supply);
                
                if ($result && $supply_result == TRUE) {
                    echo "Part supplied successfully.";
                }else{
                    echo "Error:" . $sql . "<br>" . $conn->error;
                }

                header("Location: dashboard.php");
                exit();
                
            }
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
                        
                        <h1 class="mt-4 text-white">Part Supply</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Supplying</li>
                        </ol>
                    
                        <div class="card mb-4">
                            <div class="card-header">
                                <b class="col-sm-4">Part Supply</b>
                            </div>
                           
                            <div class="card-body">
                                <!-- Start supply -->
                                <form action="" method="POST" autocomplete="off">
                                    
                                    <div class="form-group">
                                        <label for="">Operator ID:</label>
                                        <input type="text" id="operator_id" name="operator_id" class="form-control" style="color: black" value="" required>
                                        <input type="hidden" name="user_id" value="<?php echo $id; ?>">

                                        <label for="">Part Number: </label>
                                        <input type="text" id="part_no" name="part_no" class="form-control" style="color: black" value="" required>
                                        
                                        <label for="">Quantity: </label>
                                        <input type="number" name="qty" class="form-control" style="color: black" value="" required>
                                            
                                        <!-- Change input:date to input:text in order to make scanning possible -->
                                        <label for="">Expiry Date: </label>
                                        <input type="text" id="expiry_date" name="expiry_date" class="form-control" style="color: black" value="" required>

                                        <div class="modal-footer">
                                            <a href="dashboard.php"><button type="button" class="btn btn-default" data-bs-dismiss="modal" href="dashboard.php">Cancel</button></a>
                                            <input type="submit" name="supply" class="btn btn-primary" value="Supply">                                        
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
<?php
include 'db_connect.php';
include 'header.php';
?>

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
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
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
                        
                        <h1 class="mt-4 text-white">Receiving Expiry Confirmation</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Check receiving</li>
                        </ol>
                    
                        <div class="card mb-4">
                            <div class="card-header">
                                <b class="col-sm-4">Check receiving</b>
                            </div>
                           
                            <div class="card-body">
                                <!-- Start create new entry -->
                                <form action="" method="POST" >
                                    
                                    <div class="form-group">
                                        <label for="">Operator ID:</label>
                                        <input type="text" name="operator_id" class="form-control" style="color: black" value="" required>
                                            
                                        <!-- Start select attribute for part_no & part_desc called from other table -->
                                        <label for="">Part Number: </label><br>
                                        <select name="part_no" id="">
                                            <?php
                                                include 'db_connect.php';
                                                $query = "SELECT part_no, part_desc FROM part_list";
                                                $result = mysqli_query($conn, $query);
                                                while ($row = mysqli_fetch_array($result)) {
                                                    echo "<option value='" .$row['part_no'] . "'>" . $row['part_no'] . "    ||     " . $row['part_desc']. "</option>";
                                                }
                                            ?>
                                        </select>        
                                        <br>
                                        <!-- end select -->

                                        <label for="">Quantity: </label>
                                        <input type="number" name="qty" class="form-control" style="color: black" value="" autocomplete="off" required>
                                            
                                        <label for="">Manufacturing Date: </label>
                                        <input type="date" name="mnf_date" class="form-control" style="color: black" value="" autocomplete="off" >
                                            
                                        <label for="">Received Date: </label>
                                        <input type="date" name="receive_date" class="form-control" style="color: black" value="" autocomplete="off" required>
                                            
                                        <label for="">Expiry Date: </label>
                                        <input type="date" name="expiry_date" class="form-control" style="color: black" value="" autocomplete="off" >

                                        <div class="modal-footer">
                                            <a href="receiving-list.php"><button type="button" class="btn btn-default" data-bs-dismiss="modal" >Cancel</button></a>
                                            <input type="submit" name="insertData" class="btn btn-primary" value="Submit">                                        
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>

<!-- ------------------------------------------------------------------------------------------------------------------------------------- -->        

    <?php
        // Check if the form to insert data into the inventory table has been submitted 
        if (isset($_POST['insertData'])) {

            $operator_id = $_POST['operator_id'];
            $part_no = $_POST['part_no'];
            $quantity = $_POST['qty'];
            $receive_date = $_POST['receive_date'];
            $expiry_date = $_POST['expiry_date'];
            $mnf_date = $_POST['mnf_date'];

            if (empty($expiry_date)){

                $query = "SELECT shelf_life FROM part_list WHERE part_no = '$part_no'";
                $result = mysqli_query($conn, $query);
                $shelf_life = mysqli_fetch_assoc($result)['shelf_life'];
                
                // inventory for value properly assigned to $shelf_life 
                // echo $shelf_life;
    
                // Calculate number of seconds of $shelf_life
                $month = $shelf_life * 30.44 * 86400;
                $exp_date = date('Y-m-d', strtotime($mnf_date) + $month);
                echo $exp_date . "\n";
                
                // Check if part is acceptable to be received based on duration between receive date & expiry date and compared it to expiration limit(month)
                $query = "SELECT expiration_limit FROM part_list WHERE part_no = '$part_no'";
                $result = mysqli_query($conn, $query);
                $expiration_limit = mysqli_fetch_assoc($result)['expiration_limit'];
            
                $diff = (strtotime($exp_date) - strtotime($receive_date)) / (60 * 60 * 24 * 30);
    
                if ($diff < $expiration_limit){
                    echo "<script>alert('Expiry date must be at least $expiration_limit months after receive date. Please reject this received parts.');</script>";
                } else {
    
                    // If all check passed, create new entry at `inventory` table
                    $sql = "INSERT INTO `inventory`(`operator_id`, `part_no`, `qty`, `mnf_date`, `receive_date`, `expiry_date`) 
                            VALUES ('$operator_id', '$part_no', '$quantity', '$mnf_date', '$receive_date', '$exp_date')";
                    $result = $conn->query($sql);
                
                    if ($result == TRUE) {
                
                        echo "New record created successfully.";
                
                    }else{
                
                        echo "Error:". $sql . "<br>". $conn->error;
                
                    }
                }
                
            // Check is user filled both expiry_date and manufactured date at the same time
            } else if (!empty($expiry_date) && !empty($mnf_date)){
                echo "<script>alert('Please fill either the Expiry date or the Manufacturing date, not both at the same time.');</script>";
            } else {
    
                // Check if part is acceptable to be received based on duration between receive date & expiry date and compared it to expiration limit(month)
                $query = "SELECT expiration_limit FROM part_list WHERE part_no = '$part_no'";
                $result = mysqli_query($conn, $query);
                $expiration_limit = mysqli_fetch_assoc($result)['expiration_limit'];
            
                // Dividing the result of strtotime($expiry_date) - strtotime($receive_date) by the number of seconds in a month
                $diff = (strtotime($expiry_date) - strtotime($receive_date)) / (60 * 60 * 24 * 30);
            
                if ($diff < $expiration_limit) {
                  echo "<script>alert('Expiry date must be at least $expiration_limit months after receive date. Please reject this received parts.');</script>";
                } else {
                    
                    // If all check passed, create new entry at `inventory` table
                    $sql = "INSERT INTO `inventory`(`operator_id`, `part_no`, `qty`, `mnf_date`, `receive_date`, `expiry_date`) 
                            VALUES ('$operator_id', '$part_no', '$quantity', '$mnf_date', '$receive_date', '$expiry_date')";
                    $result = $conn->query($sql);
                
                    if ($result == TRUE) {
                
                        echo "New record created successfully.";
                
                    }else{
                
                        echo "Error:". $sql . "<br>". $conn->error;
                
                    }
                }
            }

            header("Location: receiving-list.php");
            exit();
        
            $conn->close();
        }
    ?>
    </body>
</html>

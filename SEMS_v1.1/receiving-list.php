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
            <a class="navbar-brand ps-3" href="index.html"> S-EMS</a>
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
        <!-- Start side nav bar -->
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
                    <div class="container-fluid">
                        <h1 class="mt-4 text-white">Inventory</h1>
                            <!-- Start small bg card -->
                            <ol class="breadcrumb mb-4">
                                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                <li class="breadcrumb-item active">Inventory</li>
                            </ol>
                            <!-- Start big bg card -->
                            <div class="card">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <b>Inventory List</b>
                                        <!-- <a href="add-receiving.php" class="col-md-2 float-right btn btn-primary btn-sm " id="new_receiving"><i class="fa fa-plus"></i> New Receiving</a> -->
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <th class="text-center">#</th>
                                                <th class="text-center">Operator ID</th>
                                                <th class="text-center">Part Number</th>
                                                <th class="text-center">Quantity</th>
                                                <th class="text-center">Receive Date</th>
                                                <th class="text-center">Expiry Date</th>
                                                <th class="text-center">Action</th>
                                            </thead>
                                            <tbody>
                                            <?php 
                                                // populate each row of html table with data from table `inventory` 
                                                $i = 1;
                                                $current_date = date('Y-m-d');
                                                $receiving = $conn->query("SELECT * FROM inventory ORDER BY expiry_date ASC");
                                                while($row=$receiving->fetch_assoc()):
                                            ?>
                                                <!-- Check current date approaching expiry date -->
                                                <tr style="<?php 
                                                                $warning_date = date('Y-m-d', strtotime('-1 month', strtotime($row['expiry_date'])));
                                                                if ($row['expiry_date'] <= $current_date) echo 'background-color: #ff0000;';
                                                                else if($warning_date <= $current_date) echo 'background-color: #ffa31a;';?>"
                                                                >

                                                    <td class="text-center"><?php echo $i++ ?></td>
                                                    <td class=""><?php echo $row['operator_id'] ?></td>
                                                    <td class=""><?php echo $row['part_no'] ?></td>
                                                    <td class=""><?php echo $row['qty'] ?></td>
                                                    <td class=""><?php echo date("M/Y",strtotime($row['receive_date'])) ?></td>
                                                    <td class=""><?php echo date("M/Y",strtotime($row['expiry_date'])) ?></td>
                                                    
                                                    <td class="text-center">

                                                    <button id="actionDrop" type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                        Action
                                                    </button>
                                                        <!-- Button that bring data of specific row by id to other file -->
                                                        <ul class="dropdown-menu" aria-labelledby="actionDrop">
                                                            <li><a class="dropdown-item" href="update-receiving.php?id=<?php echo $row['id'] ?>">Edit</a></li>
                                                            <li><a class="dropdown-item" href="hold.php?id=<?php echo $row['id'] ?>">Hold part</a></li>
                                                        </ul>
                                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                            Delete
                                                        </button>
                                                    
                                                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLabel">Warning</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>

                                                                    <div class="modal-body">
                                                                        Are you sure that you want to permanently remove this item?
                                                                    </div>
                                                                    
                                                                    <div class="modal-footer">
                                                                        <a class="btn btn-danger" href="delete.php?id=<?php echo $row['id'] ?>">Yes</a>
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                    </div> 
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endwhile; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                    </div>
                </main>
            </div>
        </div>
    </body>
</html>

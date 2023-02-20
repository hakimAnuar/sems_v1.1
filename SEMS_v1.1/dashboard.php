<?php
include 'header.php';
include 'db_connect.php';
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
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        </head>
    <body class="sb-nav-fixed" style="background-color: #142739;">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="dashboard.php">S-EMS</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            
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
                        <h1 class="mt-4 text-white">Supply</h1>
                        <!-- <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol> -->
                        <div class="row justify-content-center">
                            <div class="row">
                                <!-- Start table -->
                                <div class="container-fluid">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <b>Priority List: </b>
                                                        <input type="text" name="" id="myInput" onkeyup="filterTable()" placeholder="Filter part number">
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                        <table id="priority_list" class="table table-bordered tablesorter">
                                                        <!-- <table class="table table-bordered tablesorter" style="border: black;"> -->
                                                            <thead>
                                                                <tr>
                                                                    <th class="header text-center">#</th>
                                                                    <th class="header text-center">Action</th>
                                                                    <th class="header text-center">Expiry Date</th>
                                                                    <th class="header text-center">Part Number</th>
                                                                    <th class="header text-center">Desc</th>
                                                                    <th class="header text-center">Quantity</th>
                                                                </tr>    
                                                            </thead>
                                                            <tbody>
                                                            <?php 
                                                                $i = 1;
                                                                date_default_timezone_set('Asia/Kuala_Lumpur');
                                                                $current_date = date('Y-m-d');
                                                                // $receiving = $conn->query("SELECT * FROM inventory ORDER BY expiry_date ASC ");
                                                                $receiving = $conn->query("SELECT inventory.*, part_list.part_desc 
                                                                                        FROM inventory JOIN part_list ON inventory.part_no = part_list.part_no
                                                                                        ORDER BY expiry_date ASC");
                                                                while($row=$receiving->fetch_assoc()):
                                                            ?>
                                                                <tr style="<?php 
                                                                    $warning_date = date('Y-m-d', strtotime('-1 month', strtotime($row['expiry_date'])));
                                                                    if ($row['expiry_date'] <= $current_date) echo 'background-color: #ff0000;';
                                                                    else if($warning_date <= $current_date) echo 'background-color: #ffa31a;';?>"
                                                                >
                                                                    <td class="text-center"><?php echo $i++ ?></td>
                                                                    <td class="text-center"><a class="btn btn-primary" href="doSupply.php?id=<?php echo $row['id'] ?>">Supply</a></td>
                                                                    <td class="text-center"><?php echo date("d/M/Y",strtotime($row['expiry_date'])) ?></td>
                                                                    <td class="text-center"><?php echo $row['part_no'] ?></td>
                                                                    <td class="text-center"><?php echo $row['part_desc'] ?></td>
                                                                    <td class="text-center"><?php echo $row['qty'] ?></td>
                                                                </tr>
                                                            <?php endwhile; ?>
                                                            </tbody>
                                                        </table>
                                                        </div>
                                                    </div>
                                                </div>

                                                    <script>
                                                        function filterTable() {
                                                            var input, filter, table, tr, td, i, txtValue;
                                                            input = document.getElementById("myInput");
                                                            filter = input.value.toUpperCase('part_no');
                                                            table = document.getElementById("priority_list")
                                                            tr = document.getElementsByTagName("tr");

                                                            for (i = 0; i < tr.length; i++){
                                                                td = tr[i].getElementsByTagName("td")[3];
                                                                if(td){
                                                                    txtValue = td.textContent || td.innerText;
                                                                    if (txtValue.indexOf(filter) > -1) {
                                                                        tr[i].style.display = "";
                                                                    } else {
                                                                        tr[i].style.display = "none";
                                                                    }
                                                                }
                                                            }

                                                        }
                                                    </script>

                                                    <script>
                                                        $(document).ready(function () {
                                                            $("#priority_list").tablesorter();
                                                        });
                                                    </script>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>

                <!-- footer -->
                <footer class="py-4  mt-auto" style="background-color: #142739;">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted text-white">Copyright &copy; ihml_plskm 2022</div>
                            
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </body>
</html>

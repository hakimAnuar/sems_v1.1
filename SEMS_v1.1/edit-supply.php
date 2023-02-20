<?php

include 'db_connect.php';
include 'header.php';

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $new_qty = $_POST['new_qty'];

    // Get the OG qty from the supply_list table
    $sql = "SELECT qty FROM supply_list WHERE id = $id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $OG_qty = $row['qty'];

    // Get the avl(available) qty from the inventory table
    $sql = "SELECT qty FROM inventory WHERE id = $id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $avl_qty = $row['qty'];

    $qty_diff = $new_qty - $OG_qty;

    // Check if new_qty > OG_qty
    if ($new_qty > $OG_qty) {
        // Check for sufficient qty available in inventory table
        if ($qty_diff <= $avl_qty) {
            // Update supply_list table
            $sql = "UPDATE supply_list SET qty = $new_qty WHERE id = $id";
            $conn->query($sql);

            // Update inventory table
            $sql = "UPDATE inventory SET qty = qty - $qty_diff WHERE id = $id";
            $conn->query($sql);

        } else {
            echo "<script>alert('Error: Insufficient qty available in inventory')</script>";
        }

    } elseif ($new_qty < $OG_qty) {
        if ($qty_diff <= $OG_qty) {
            $sql = "UPDATE supply_list SET qty = $new_qty WHERE id = $id";
            $conn->query($sql);

            $sql = "UPDATE inventory SET qty = qty + $qty_diff WHERE id = $id";
            $conn->query($sql);

        } else {
            echo "<script>alert('Error: Insufficient qty available in supply')</script>";
        }

    }

    header("Location: supply-list.php");
    exit();
    
    $conn->close();
 
}


$id = $_GET['id'];
$result = $conn->query("SELECT * FROM `supply_list` WHERE `id` = '$id'");

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "Error: Record not found";
    exit;
}

?>

<!-- ---------------------------------------------------------------------- -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SEMS</title>
</head>
<body>
    <h2>Hold Part Update Form</h2>

    <form action="" method="post">
        <fieldset>
            <legend>Hold Part information:</legend>
            <input type="hidden" name="id" value="<?php echo $id; ?>">


            QTY:<br>
            <input type="number" id="new_qty" name="new_qty" value="<?php echo $row['qty']; ?>">
            <br>

            <input type="submit" value="Update" name="update">

        </fieldset>
    </form>
</body>
</html>
<?php

include('../db_connection/connection_costumer.php'); // Fixed path to the include file

// Query the database
$sql = mysqli_query($conn, "SELECT * FROM mast_cust");
$contactQuery = mysqli_query($conn, "SELECT * FROM mast_cust_dtl WHERE CUST_REFN = '".$value['CUST_NDEX']."'");

// Check if the query was successful
if (!$sql) {
    echo json_encode(['error' => 'Query failed: ' . mysqli_error($conn)]);
    exit;
}

// Fetch all rows from the result set
$data = [];
while ($row = mysqli_fetch_assoc($sql)) {
    $data[] = $row;
}

// Close the database connection
$conn->close();

// Encode the data as JSON and output it
echo json_encode($data);
// var_dump($data);

?>

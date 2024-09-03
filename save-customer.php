<?php
function generateRandomString($length = 10) {
    $characters = '0123456789';
    $charactersLength = strlen($characters);
    $randomString = '';

    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }

    return $randomString;
}

// Include the database connection file
include('../db_connection/connection_costumer.php');

// Ensure POST data is set
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	// if ($_POST["id"]=='') {
 //    	$CUST_NDEX = isset($_POST["id"]) ? $_POST["id"] : '';
	// }
    // Sanitize POST data
    $CUST_STAT = 0;
    $CUST_TERM = isset($_POST["terms_days"]) ? $_POST["terms_days"] : '';
    $CUST_CODE = isset($_POST["customer_code"]) ? $_POST["customer_code"] : '';
    $CUST_VCOD = '';
    $CUST_NAME = isset($_POST["customer_name"]) ? $_POST["customer_name"] : '';
    $CUST_ADDR = isset($_POST['address']) ? $_POST['address'] : '';
    $CUST_SLMN = isset($_POST["salesman"]) ? $_POST["salesman"] : '';
    $CUST_TINO = isset($_POST["tin"]) ? $_POST["tin"] : '';
    $CUST_STYL = isset($_POST["business_style"]) ? $_POST["business_style"] : '';
    $CUST_TYPE = isset($_POST["address_type"]) ? $_POST["address_type"] : '';
    $CUST_VAT = isset($_POST["vat_type"]) ? $_POST["vat_type"] : '';
    $CUST_LGCY = '';
    $CUST_NOTE = '';
    $CUST_CRTD = '';
    $CUST_ENDR = '';
    $CUST_UPDT = '';
    $CUST_MDFY = '';
    $CUST_PRSN = isset($_POST['contact_person']) ? $_POST['contact_person'] : '';
    $CUST_DSGN = isset($_POST['designation']) ? $_POST['designation'] : '';
    $CUST_TELN = isset($_POST['telephone_no']) ? $_POST['telephone_no'] : '';
    $CUST_FAXN = isset($_POST['fax_no']) ? $_POST['fax_no'] : '';
    $CUST_CELN = isset($_POST['cellphone_no']) ? $_POST['cellphone_no'] : '';
    $CUST_EMAIL = isset($_POST['email']) ? $_POST['email'] : '';

    $mast_cust_id = generateRandomString(40);
    $mast_cust_addr_id = generateRandomString(40);
    $mast_cust_dtl_id = generateRandomString(40);

    // Prepare and execute SQL queries using prepared statements
    $stmt = $conn->prepare("INSERT INTO mast_cust (CUST_NDEX, CUST_STAT, CUST_TERM, CUST_CODE, CUST_VCOD, CUST_NAME, CUST_ADDR, CUST_SLMN, CUST_TINO, CUST_STYL, CUST_TYPE, CUST_VAT, CUST_LGCY, CUST_NOTE, CUST_CRTD) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('sisssssssssssss', $mast_cust_id, $CUST_STAT, $CUST_TERM, $CUST_CODE, $CUST_VCOD, $CUST_NAME, $CUST_ADDR, $CUST_SLMN, $CUST_TINO, $CUST_STYL, $CUST_TYPE, $CUST_VAT, $CUST_LGCY, $CUST_NOTE, $CUST_CRTD);

    if (!$stmt->execute()) {
        echo "Error inserting into mast_cust: " . $stmt->error;
    }

    $stmt = $conn->prepare("INSERT INTO mast_cust_dtl (CUST_NDEX, CUST_REFN, CUST_PRSN, CUST_DSGN, CUST_TELN, CUST_FAXN, CUST_CELN, CUST_EMAIL) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('ssssssss', $mast_cust_dtl_id, $mast_cust_id, $CUST_PRSN, $CUST_DSGN, $CUST_TELN, $CUST_FAXN, $CUST_CELN, $CUST_EMAIL);

    if (!$stmt->execute()) {
        echo "Error inserting into mast_cust_dtl: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

    // echo json_encode(['success' => true]);
    echo json_encode(true);
} else {
    // echo json_encode(['error' => 'Invalid request method']);
    echo json_encode(false);
}
?>

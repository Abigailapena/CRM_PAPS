<?php
session_start();
if (empty($_SESSION['login_user'])) {
    header("location:logout.php");
}
else{

    include('header.php');
    include('..\db_connection\connection_costumer.php');
    $sql= mysqli_query($conn,"SELECT * FROM mast_cust");
 

?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Customer <a class="btn btn-success btn-sm" href="#"  data-toggle="modal" data-target=".bs-example-modal-lg" style="float: right;"><i class="mdi mdi-account-plus"></i> Add</a></h5>
                <div id="customer_tbl">
                    <div class="table-responsive">
                        <table id="zero_config" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">CODE</th>
                                    <th class="text-center">NAME</th>
                                    <th class="text-center">ADDRESS</th>
                                    <th class="text-center">TIN Number</th>
                                    <th class="text-center">Business Style</th>
                                    <th class="text-center">VAT Type</th>
                                    <th class="text-center">Salesman</th>
                                    <th class="text-center">Contact Person</th>
                                    <th class="text-center">Designation</th>
                                    <th class="text-center">Tel Number</th>
                                    <th class="text-center">Fax Number</th>
                                    <th class="text-center">Cell Number</th>
                                    <th class="text-center">Email</th>
                                    <th class="text-center">Action</th>
                                </tr class="text-center">
                            </thead>
                            <tbody>
                                <?php foreach ($sql as $key => $value) {
                                    // Fetch additional contact details
                                    $contactQuery = mysqli_query($conn, "SELECT * FROM mast_cust_dtl WHERE CUST_REFN = '".$value['CUST_NDEX']."'");
                                    
                                    if ($contactQuery && mysqli_num_rows($contactQuery) > 0) {
                                        $contact = mysqli_fetch_assoc($contactQuery);
                                    } else {
                                        // Initialize with empty values if no contact details are found
                                        $contact = [
                                            'CUST_PRSN' => '',
                                            'CUST_DSGN' => '',
                                            'CUST_TELN' => '',
                                            'CUST_FAXN' => '',
                                            'CUST_CELN' => '',
                                            'CUST_EMAIL' => ''
                                        ];
                                    }
                                ?>
                                <tr>
                                    <td><?= htmlspecialchars($value['CUST_CODE']) ?></td>
                                    <td><?= htmlspecialchars($value['CUST_NAME']) ?></td>
                                    <td><?= htmlspecialchars($value['CUST_ADDR']) ?></td>
                                    <td><?= htmlspecialchars($value['CUST_TINO']) ?></td>
                                    <td><?= htmlspecialchars($value['CUST_STYL']) ?></td>
                                    <td><?= htmlspecialchars($value['CUST_TYPE']) ?></td>
                                    <td><?= htmlspecialchars($value['CUST_SLMN']) ?></td>
                                    <td><?= htmlspecialchars($contact['CUST_PRSN']) ?></td>
                                    <td><?= htmlspecialchars($contact['CUST_DSGN']) ?></td>
                                    <td><?= htmlspecialchars($contact['CUST_TELN']) ?></td>
                                    <td><?= htmlspecialchars($contact['CUST_FAXN']) ?></td>
                                    <td><?= htmlspecialchars($contact['CUST_CELN']) ?></td>
                                    <td><?= htmlspecialchars($contact['CUST_EMAIL']) ?></td>
                                    <td><button class="btn btn-success btn-xs" onclick="UpdateCustomer('<?=$value['CUST_NDEX']?>')"><i class="fas fa-pencil-alt"></i></button> <button class="btn btn-danger btn-xs" onclick="DeleteCustomer('<?=$value['CUST_NDEX']?>')"><i class="fas fa-trash-alt"></i></button></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Add Customer</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <div class="input-group mb-3">
                        <label class="control-label col-form-label">Customer Code: </label>
                            <input type="text" id="cust_code" class="form-control" name="Customer[CUST_CODE]" required placeholder="Customer Code" maxlength="3" style="text-transform: uppercase; pointer-events: none;">
                            <span class="input-group-text"><a href="#" onclick="GenerateCode()" style="text-decoration: none;"><i class="mdi mdi-check"></i></a></span>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-9">
                        <div class="form-group">
                            <label class="control-label col-form-label">Customer Name:</label>
                            <input type="text" id="cust_name" class="form-control" name="Customer[CUST_NAME]" required placeholder="Customer Name">
                        </div>
                    </div>
                    <br>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label class="control-label col-form-label">TIN Number: <small class="text-muted">999-999-999</small></label>
                            <input type="text" id="tin" class="form-control tin-inputmask" name="Customer[tin]" required placeholder="TIN Number">
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label class="control-label col-form-label">Salesman:</label>
                            <input type="text" class="form-control" id="salesman" name="Customer[CUST_TYPE]" required placeholder="Salesman">
                        </div>
                    </div>
                    <br>
                    <div class="col-sm-12 col-md-4">
                        <div class="form-group">
                            <label class="control-label col-form-label">Business Style:</label>
                                <input type="text" id="business_style" class="form-control" name="Customer[email]" required placeholder="Business Style">
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <div class="form-group">
                            <label class="control-label col-form-label">VAT Type:</label>
                            <select class="form-control" id="vat_type" name="Customer[CUST_TYPE]" required placeholder="VAT Type">
                                <option disabled selected>Select one..</option> 
                                <option>Non-VAT Registered</option>
                                <option>VAT Registered</option>
                                <option>DR Only</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <div class="form-group">
                            <label class="control-label col-form-label">Terms (Days):</label>
                                <input type="number" id="terms_days" class="form-control" name="Customer[terms_days]" min="1" required placeholder="Term (Days)">
                        </div>
                    </div>
                </div>

                <br>
                    <h5 class="card-title ">Address Information</h5>
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-form-label">Address Type:</label>
                                    <select class="form-control" id="address_type" name="Customer[CUST_TYPE]" required placeholder="Address Type">
                                        <option disabled selected>Select one..</option> 
                                        <option>Main Address</option>
                                        <option>Office Address</option>
                                        <option>Shipping Address</option>
                                        <option>Other Address</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-form-label">Address:</label>
                                    <input type="text" id="address" class="form-control" name="Customer[CUST_ADDR]" required placeholder="Customer Address">
                                </div>
                            </div>
                        </div>
                <br>
                    <h5 class="card-title ">Contact Information</h5>
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-form-label">Contact Person:</label>
                                    <input type="text" id="contact_person" class="form-control" name="Customer[contact_person]" required placeholder="Contact Person">
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-form-label">Email address: </label>
                                    <div class="controls">
                                        <input type="text" name="email" id="email" class="form-control email-inputmask" name="Customer[email]" required data-validation-required-message="This field is required">
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label class="control-label col-form-label">Designation:</label>
                                    <input type="text" id="designation" class="form-control" name="Customer[designation]" required placeholder="Designation">
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label class="control-label col-form-label">Tel. No.: <small class="text-muted">1234-5678</small></label>
                                    <input type="text" id="telephone_no" class="form-control tel-inputmask" name="Customer[telephone_no]" required placeholder="Tel. No.">
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label class="control-label col-form-label">Fax No.: <small class="text-muted">1-234-5678</small></label>
                                    <input type="text" id="fax_no" class="form-control fax-inputmask" name="Customer[fax_no]" required placeholder="Fax No.">
                              </div>
                            </div>

                            <div class="col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label class="control-label col-form-label">Cell No.: <small class="text-muted">(0999)-123-4567</small></label>
                                    <input type="text" id="cellphone_no" class="form-control phone-inputmask" name="Customer[cellphone_no]" required placeholder="Cell No.">
                                </div>
                            </div>
                        </div>
                </div>
            <div class="modal-footer">
                <a href="#" onclick="SaveCustomerInfo()" class="btn btn-success waves-effect text-left" >Save</a>
                <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Cancel</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


<?php
include('footer.php');
}
?>
<script>
function SaveCustomerInfo() {
    // Collect data from form fields
    var data = {
        id: $('#id').val(),
        customer_code: $('#cust_code').val(),
        customer_name: $('#cust_name').val(),
        tin: $('#tin').val(),
        salesman: $('#salesman').val(),
        business_style: $('#business_style').val(),
        vat_type: $('#vat_type').val(),
        terms_days: $('#terms_days').val(),
        address_type: $('#address_type').val(),
        address: $('#address').val(),
        contact_person: $('#contact_person').val(),
        email: $('#email').val(),
        designation: $('#designation').val(),
        telephone_no: $('#telephone_no').val(),
        fax_no: $('#fax_no').val(),
        cellphone_no: $('#cellphone_no').val()
    };

    $.ajax({
        url: 'save-customer.php',
        type: 'post',
        data: data,
        success: function(response) {
            if (response.trim() === "true") {
                swal("Success!", "Your data was saved", "success");
                setTimeout(function(){
                    location.reload();
                }, 3000); // 3000 milliseconds = 3 seconds
                // Refresh the customer table
                // $.ajax({
                //     url: 'refresh-customer.php',
                //     type: 'post',
                //     dataType: 'json',
                //     success: function(datatable) {
                //         console.log(datatable);
                //         var htmltag = '<div class="table-responsive"><table id="zero_config" class="table table-striped table-bordered">' +
                //             '<thead><tr>' +
                //             '<th>CODE</th>' +
                //             '<th class="text-center">NAME</th>' +
                //             '<th class="text-center">ADDRESS</th>' +
                //             '<th class="text-center">TIN Number</th>' +
                //             '<th class="text-center">Business Style</th>' +
                //             '<th class="text-center">VAT Type</th>' +
                //             '<th class="text-center">Contact Person</th>' +
                //             '<th class="text-center">Designation</th>' +
                //             '<th class="text-center">Tel Number</th>' +
                //             '<th class="text-center">Fax Number</th>' +
                //             '<th class="text-center">Cell Number</th>' +
                //             '<th class="text-center">Email</th>' +
                //             '</t class="text-center"r></thead><tbody>';

                //         $.each(datatable, function(index, value) {
                //             htmltag += '<tr>' +
                //                 '<td>' + value['CUST_CODE'] + '</td>' +
                //                 '<td>' + value['CUST_NAME'] + '</td>' +
                //                 '<td>' + value['CUST_ADDR'] + '</td>' +
                //                 '<td>' + value['CUST_TINO'] + '</td>' +
                //                 '<td>' + value['CUST_STYL'] + '</td>' +
                //                 '<td>' + value['CUST_TYPE'] + '</td>' +
                //                 '<td>' + value['CUST_SLMN'] + '</td>' +
                //                 '<td>' + value['CUST_DESG'] + '</td>' +
                //                 '<td>' + value['CUST_TEL'] + '</td>' +
                //                 '<td>' + value['CUST_FAX'] + '</td>' +
                //                 '<td>' + value['CUST_CELL'] + '</td>' +
                //                 '<td>' + value['CUST_EMAIL'] + '</td>' +
                //                 '</tr>';
                //         });

                //         htmltag += '</tbody></table></div>';
                //         $('#customer_tbl').html(htmltag); // Replace existing content
                //     },
                //     error: function(xhr, status, error) {
                //         console.error('AJAX Error: ' + status + ' - ' + error);
                //     }
                // });

                // Close modal or perform other UI updates
                $('.close').click();
            } else {
                swal("Failed", "Sorry, a problem occurred while saving", "error");
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error: ' + status + ' - ' + error);
            swal("Failed", "Sorry, a problem occurred while saving", "error");
        }
    });
}


function randomString(length, chars) {
    var result = '';
    for (var i = length; i > 0; --i) result += chars[Math.floor(Math.random() * chars.length)];
    return result;
}
function GenerateCode(){
    var code = randomString(3, 'ABCDEFGHIJKLMNOPQRSTUVWXYZ');
    $('#cust_code').val(code);
}
</script>
<?php 
session_start();
include('header.php');
include 'Invoice.php';
$invoice = new Invoice();
$invoice->checkLoggedIn();
?>
<title>Invoice System</title>
<script src="js/invoice.js"></script>
<link href="css/style.css" rel="stylesheet">
<?php include('container.php');?>
	<div class="container">		
	  <marquee behavior="scroll" direction="left" scrollamount="12" loop="infinite"><img src="https://www.modicare.com/preLoginImage/Common/Logo.png" alt="" class="img-fluid my-3"></marquee>
    

	  <?php include('menu.php');?>			  
      <table id="data-table" class="table table-condensed table-bordered table-dark">
        <thead>
          <tr>
            <th>Invoice No.</th>
            <th>Customer Name</th>
            <th>Create Date</th>
            <th>Total</th>
            <th>Payment Mode</th>
            <th>Mail</th>
            <th>Download</th>
            <th>Print</th>
            <th>Edit</th>
            <th>Delete</th>
          </tr>
        </thead>
        <?php		
	    	$invoiceList = $invoice->getInvoiceList();
        $order_id=0;
        foreach($invoiceList as $invoiceDetails){
          $order_id=$order_id+1;

			$invoiceDate = date("j-F-y, H:i:s", strtotime($invoiceDetails["order_date"]));
            echo '
              <tr class="text-center">
                <td>'.$order_id.'</td>
                <td class="text-uppercase">'.$invoiceDetails["order_receiver_name"].'</td>
                <td>'.$invoiceDate.'</td>
                <td>Rs '.number_format($invoiceDetails["order_total_after_tax"],2).'</td>
                <td>'.$invoiceDetails["p_mode"].'</td>
                <td><a href="mail.php?invoice_id='.$invoiceDetails["order_id"].'" title="Invoice Email"><button class="btn btn-primary btn-sm"><i class="fa fa-envelope"></i></button></a></td>
                <td><a href="download.php?invoice_id='.$invoiceDetails["order_id"].'" title="Download Invoice"><button class="btn btn-primary btn-sm"><i class="fa fa-download"></i></button></a></td>
                <td><a href="print_invoice.php?invoice_id='.$invoiceDetails["order_id"].'" title="Print Invoice"><button class="btn btn-primary btn-sm"><i class="fa fa-print"></i></button></a></td>
                <td><a href="edit_invoice.php?update_id='.$invoiceDetails["order_id"].'"  title="Edit Invoice"><button class="btn btn-success btn-sm"><i class="fa fa-edit"></i></button></a></td>
                <td><a href="delete-invoice.php?order_id='.$invoiceDetails['order_id'].'" title="Delete Invoice"><button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button></a></td>
              </tr>
            ';
        }       
        ?>
      </table>	
</div>	
<?php include('footer.php');?>
<script>
 $("#data-table").DataTable({
      "responsive": true,
      "lengthChange": true,
      "autoWidth": true,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#data-table_wrapper .col-md-6:eq(0)');
</script>
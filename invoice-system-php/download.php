<?php
session_start();
include 'Invoice.php';

$invoice = new Invoice();
$invoice->checkLoggedIn();
if(!empty($_GET['invoice_id']) && $_GET['invoice_id']) {
	echo $_GET['invoice_id'];
	$invoiceValues = $invoice->getInvoice($_GET['invoice_id']);		
	$invoiceItems = $invoice->getInvoiceItems($_GET['invoice_id']);		
}
$invoiceDate = date("l-j-F-y H:i:s A", strtotime($invoiceValues['order_date']));
$output1='<img src="https://www.modicare.com/preLoginImage/Common/Logo.png" style="margin-bottom:15px" width="20%">';
$output = '';
$output .= '<table width="100%" border="1" cellpadding="5" cellspacing="0" style="margin-bottom:15px" >
	<tr>
	<td colspan="2" align="center" style="font-size:18px"><b>MODICARE DISTRIBUTION POINT</b></td>
	</tr>
	<tr>
	<td colspan="2" align="center" style="font-size:18px"><b>Plot no. 1 Harman Nagar, Behind Baba Ram Lal Nagar, Firozpur, Punjab 152002
	</b></td>
	</tr>
	<tr>
	<td colspan="2" align="center" style="font-size:18px"><b>9417055333,7973627978</b></td>
	</tr>
	<tr>
	<td colspan="2">
	<table width="100%" cellpadding="5">
	<tr>
	<td width="65%">
	To,<br />
	<b>RECEIVER (BILL TO)</b><br />
	Name : <b>'.$invoiceValues['order_receiver_name'].'</b><br /> 
	Billing Address : '.$invoiceValues['order_receiver_address'].'<br />
	</td>
	<td width="35%">         
	Invoice No. : VDAB6000'.$invoiceValues['order_id'].'<br />
	Invoice Date : '.$invoiceDate.'<br />
	</td>
	</tr>
	</table>
	<br />
	<table width="100%" border="1" cellpadding="5" cellspacing="0">
	<tr>
	<th align="left">Sr No.</th>
	<th align="left">Item Code</th>
	<th align="left">Item Name</th>
	<th align="left">Quantity</th>
	<th align="left">Price</th>
	<th align="left">Actual Amt.</th> 
	</tr>';
$count = 0;
$order_id=0;   
foreach($invoiceItems as $invoiceItem){
	$count++;
	$output .= '
	<tr>
	<td align="left">'.$count.'</td>
	<td align="left">'.$invoiceItem["item_code"].'</td>
	<td align="left">'.$invoiceItem["item_name"].'</td>
	<td align="left">'.$invoiceItem["order_item_quantity"].'</td>
		<td align="left"> <b>'.number_format($invoiceItem["order_item_price"]).'.00</b></td>
	<td align="left"><b>'.number_format($invoiceItem["order_item_final_amount"]).'.00</b></td>   
	</tr>';
}
$output .= '
	<tr>
	<td align="right" colspan="5"><b>Sub Total</b></td>
	<td align="left"><b>'.number_format($invoiceValues['order_total_before_tax'],2).'</b></td>
	</tr>
	
	<tr>
	<td align="right" colspan="5"><b>Total:</b> </td>
	<td align="left">'.number_format($invoiceValues['order_total_after_tax'],2).'</td>
	</tr>
	<tr>
	<td align="right" colspan="5"><b>Amount Paid:</b></td>
	<td align="left">'.number_format($invoiceValues['order_amount_paid'],2).'</td>
	</tr>
	<tr>
	<td align="right" colspan="5"><b>Amount Due:</b></td>
	<td align="left">'.number_format($invoiceValues['order_total_amount_due'],2).'</td>
	</tr>';
$output .= '
	</table>
	</td>
	</tr>
	</table>';
// create pdf of invoice	
$invoiceFileName = 'Invoice_'.$invoiceValues['order_receiver_name'].'.pdf';
require_once 'dompdf/src/Autoloader.php';
Dompdf\Autoloader::register();
use Dompdf\Dompdf;

$dompdf = new Dompdf();
$options = $dompdf->getOptions();
$options->set(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true]);
$dompdf->setOptions($options);

$dompdf->loadHtml(html_entity_decode($output1. $output));
$dompdf->setPaper('A4', 'POTRAIT');
$dompdf->render();
$dompdf->stream($invoiceFileName, array("Attachment" => true));
?>   
   
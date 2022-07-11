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
	  <h2 class="title mt-5">Mail Send Using PHP Mailer</h2>
    <form action="send.php" method="post" enctype="multipart/form-data" onsubmit="myfunction()">
      <div class="row">

          <div class="col-6">
              
              <div class="form-group">
                  <label for="to">TO</label>
                  <input type="email" class="form-control" name="email">
                </div>
            </div>
            <div class="col-6">
              
              <div class="form-group">
                  <label for="Subject">Subject</label>
                  <input type="text" class="form-control" name="subject">
                </div>
            </div>

      </div>
      <div class="row">
        <div class="col-sm-6">
          <textarea name="msg" id="" cols="10" rows="10" class="form-control" placeholder="Enter Something"></textarea>

        </div>
        <div class="col-sm-6">
          <input type="file" name="attachment" id="" class="form-control">

        </div>
      </div>
      <div class="my-3">

      </div>
            
            <button class="btn btn-primary w-25 btn-sm " type="submit" name="send" value="Send">Send</button>
            </form>
            <script>
function myfunction(){
  swal({
  title: "Your Email Has Been Sent!",
  text: "Great Job !",
  icon: "success",
});
}

            </script>
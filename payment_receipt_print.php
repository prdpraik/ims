<?php
session_start(); // Use session variable on this page. This function must put on the top of page.
if(!isset($_SESSION['username']) || $_SESSION['usertype'] !='admin'){ // if session variable "username" does not exist.
header("location:indexx.php?msg=Please%20login%20to%20access%20admin%20area%20!"); // Re-direct to indexx.php
}
else
{
	include_once "db/db.php";
	error_reporting (E_ALL ^ E_NOTICE);
	if(isset($_GET['sid']))
	{
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Sales Print</title>
    <link rel="icon" href="Knight/favicon.png" type="image/png">

    <style type="text/css" media="print">
.hide{display:none}

</style>
<script type="text/javascript">
function printpage() {
document.getElementById('printButton').style.visibility="hidden";
window.print();
document.getElementById('printButton').style.visibility="visible";  
}
</script>
</head>

<body>
<input name="print" type="button" value="Print" id="printButton" onClick="printpage()">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" valign="top">
	
	<table width="595"  cellspacing="0" cellpadding="0" id="bordertable"  border="1">
      <tr>
        <td align="center"><strong>Payment Receipt <br />
        </strong>
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="67%" align="left" valign="top">&nbsp;&nbsp;&nbsp;Date: <?php
			  $sid=$_GET['sid'];
			$line = $db->queryUniqueObject("SELECT * FROM transactions WHERE id='$sid' ");
			
			$mysqldate=$line->date;

 		$phpdate = strtotime( $mysqldate );

 		$phpdate = date("d/m/Y",$phpdate);
		echo $phpdate;
			  ?> <br />
                <br />
                <strong><br />
                &nbsp;&nbsp;&nbsp;Receipt No: <?php echo $line->receiptid;
				
				 ?> </strong><br /></td>
              <td width="33%"> UK Electronics LTD<br />
                Address:Dhaka, Mirpur-2<br />
                Phone:01740014503</td>
            </tr>
          </table></td>
      </tr>
      <tr>
        <td height="90" align="left" valign="top"><br />
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="5%" align="left" valign="top"><strong>&nbsp;&nbsp;TO:</strong></td>
              <td width="95%" align="left" valign="top"><br />
              <?php 
				echo $line->customer;
				$cname=$line->customer_name;
				
				$line2 = $db->queryUniqueObject("SELECT * FROM customer_details WHERE customer_name='$cname' ");
				
				echo $line2->customer_address;
				?>
				<br />
				<?php
			//	echo "Contact1:".$line2->customer_contact1."<br>";
			//	echo "Contact1:".$line2->customer_contact2."<br>";
					
				
				?></td>
            </tr>
          </table></td>
      </tr>
      <tr>
        <td align="right"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="33%" align="left" valign="top"> </td>
            <td width="67%" align="left"><br />
			<br />
              <strong>&nbsp;&nbsp;Paid Amount :&nbsp;&nbsp;<?php echo $line->payment; ?><br />
              &nbsp;&nbsp;Due Balance &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo $line->balance; ?><br />
              &nbsp;&nbsp;Due Date&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;: 
			  
			  <?php 
			  $bal=$line->balance;
			  if( $bal!= 0) {
			  
			  $mysqldate=$line->due;

 		$phpdate = strtotime( $mysqldate );

 		$phpdate = date("d/m/Y",$phpdate);
		echo $phpdate;
		}
		else
		echo "NONE";
		?> <br />
              </strong>
              <br />
             <br />              &nbsp;&nbsp;&nbsp;&nbsp;</td>
          </tr>
          <tr>
            <td height="100" align="left" valign="top">&nbsp;</td>
            <td height="100" align="right" valign="bottom">Signature&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td align="center" bgcolor="#CCCCCC">Thank you for Business with Us </td>
      </tr>
    </table></td>
  </tr>
</table>


</body>
</html>
<?php
}
else "Error in processing printing the Payment receipt";
}
?>
<?php

//Some variables
$prelink = '../../';
session_start();

//Redirections
if (isset($_GET['home'])) {

    header('Location: . ');
    exit();

  }
if (isset($_GET['tents_and_seatings'])) {

header('Location:' . $prelink . 'tents_and_seatings/');
exit();

}
if (isset($_GET['venues'])) {

header('Location:' . $prelink . 'venues/');
exit();

}
if (isset($_GET['djs'])) {

header('Location:' . $prelink . 'djs/');
exit();
	
}
if (isset($_GET['photography'])) {

header('Location:' . $prelink . 'photography/');
exit();
		
}
if (isset($_GET['sign_in'])) {

	header('Location:' . $prelink . 'sign_in/');
	exit();
			
	}
if (isset($_GET['sign_up'])) {

	header('Location:' . $prelink . 'sign_up/');
	exit();
				
}
if (isset($_GET['offer_service'])) {

	header('Location:' . $prelink . 'vendors/');
	exit();
				
}

include $prelink . "includes/frontend_header.php"

?>

<div class="vanes_container containerMargin">
        <div class="vanes_vendor_container">
            <div class="vanes_vendor_title">
                <h2>Confirm Payment</h2>
            </div>
            <div class="not_registered">
                <form action="stk_pay.php" method="POST">
                <div class="formGroup_container_signin">
                <div class="form_group">
                    Phone Number:<br>
                    <input type="number" name="phone" placeholder="0711011011" required/><br>
                    Amount to Pay:<br>
                    <input type="number" name="amount" required/><br>
                    <input type="submit" value="Check Out" name="Confirm" />
                </div>
                </div>
                </form>
                <p><strong>Your order will be confirmed once payment is processed</strong> 
                </p>
            </div>
        </div>
</div>

<?php include $prelink . "includes/frontend_footer.php"; ?>
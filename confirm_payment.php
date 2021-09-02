<?php
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

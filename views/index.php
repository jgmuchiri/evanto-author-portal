<h3>Evanto Author Portal</h3>
<hr/>
<div class="wrap eap_wrap">
    <div class="row">
        <div class="col-sm-2">
            <ul class="nav nav-pills nav-stacked">
                <li>
                    <a class="btn btn-warning" href="?page=<?php echo $_GET['page']; ?>&tab=verify_purchase">Verify
                        purchase</a>
                </li>
                <li>
                    <a class="btn btn-info" href="?page=<?php echo $_GET['page']; ?>&tab=my_items">My Items</a>
                </li>
                <li>
                    <a class="btn btn-info" href="?page=<?php echo $_GET['page']; ?>&tab=my_orders">My Orders</a>
                </li>
                <li>
                    <a class="btn btn-info" href="?page=<?php echo $_GET['page']; ?>&tab=verified_purchases">Verified
                        Purchases</a>
                </li>
                <li>
                    <a class="btn btn-info" href="?page=<?php echo $_GET['page']; ?>">Settings</a>
                </li>
            </ul>
        </div>
        <div class="col-sm-10">
            <?php
            $tab = '';
            if(isset($_GET['tab']))
                $tab = $_GET['tab'];

            switch ($tab) {
                case 'verify_purchase':
                    include "purchase_verify.php";
                    break;
                case 'verified_purchases';
                    include "verified_purchases.php";
                    break;
                default:
                    include "dashboard.php";
            }
            ?>
        </div>
    </div>
</div>
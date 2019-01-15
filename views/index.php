<h3>Evanto Author Portal</h3>
<hr/>
<div class="wrap eap_wrap">
    <div class="row">
        <div class="col-sm-2">
            <ul class="nav nav-pills nav-stacked">
                <li>
                    <a class="btn btn-primary"
                       href="?page=<?php echo $_GET['page']; ?>">
                        Home</a>
                </li>
                <li>
                    <a class="btn btn-warning"
                       href="?page=<?php echo $_GET['page']; ?>&tab=verify_purchase">
                        Verify Purchase</a>
                </li>

                <li>
                    <a class="btn btn-success"
                       href="?page=<?php echo $_GET['page']; ?>&tab=my_items">
                        My Items</a>
                </li>
                <li>
                    <a class="btn btn-success"
                       href="?page=<?php echo $_GET['page']; ?>&tab=month-sales">
                        Monthly Sales</a>
                </li>
                <li><hr/></li>
                <li>
                    <a class="btn btn-info"
                       href="?page=<?php echo $_GET['page']; ?>&tab=orders">
                        My Orders</a>
                </li>
                <li>
                    <a class="btn btn-info"
                       href="?page=<?php echo $_GET['page']; ?>&tab=verified_purchases">
                        Verified Purchases</a>
                </li>
                <li>
                    <a class="btn btn-info"
                       href="?page=<?php echo $_GET['page']; ?>&tab=collections">
                        My Collections</a>
                </li>
                <li>
                    <a class="btn btn-info"
                       href="?page=<?php echo $_GET['page']; ?>&tab=bookmarks">
                        My Bookmarks</a>
                </li>

                <li><hr/></li>
                <li>
                    <a class="btn btn-default"
                       href="?page=<?php echo $_GET['page']; ?>&tab=browse">
                        Browse</a>
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
                case 'collections':
                    include 'collections.php';
                    break;
                case 'bookmarks':
                    include 'bookmarks.php';
                    break;
                case 'my_items':
                    include 'my_items.php';
                    break;
                case 'orders':
                    include 'orders.php';
                    break;
                case 'month-sales':
                    include 'month-sales.php';
                    break;
                case 'browse':
                    include 'browse.php';
                    break;
                default:
                    include "dashboard.php";
            }
            ?>
        </div>
    </div>
</div>
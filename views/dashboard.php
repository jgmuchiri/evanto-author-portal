<?php
if(isset($_POST['eap_key'])) {
    update_option(EAP_AUTHOR_KEY, htmlspecialchars(trim($_POST['eap_key'])));
    update_option(EAP_USERNAME, htmlspecialchars(trim($_POST['evanto_username'])));
}

if(!empty(get_option(EAP_USERNAME))):
    $userdata = $eap_client->fetchData($eap_client->methods['profile']['details']);
    $user = $userdata->user;

    $badges = $eap_client->fetchData($eap_client->methods['profile']['badges']);
    ?>
    <table class="table">
        <tr>
            <td class="col-sm-3" rowspan="">
                <img class="thumbnail" src="<?php echo $user->image; ?>"/>
            </td>
            <td>

                <h2><?php echo $user->username; ?></h2>
                <?php if(!empty($badges->{'user-badges'})):
                    foreach ($badges->{'user-badges'} as $badge): ?>
                        <img title="<?php echo $badge->label; ?>" src="<?php echo $badge->image; ?>"
                             style="width:20px;margin-right:10px;"/>
                    <?php endforeach;
                endif; ?>
                <br/>
                <p>
                    <strong>Country</strong>: <?php echo $user->country; ?><br/>
                    <strong>Sales</strong>: <?php echo $user->sales; ?> <br/>
                    <strong>Locaton</strong>: <?php echo $user->location; ?><br/>
                    <strong>Followers</strong>: <?php echo $user->followers; ?>
                </p>
            </td>
        </tr>
    </table>
<?php endif; ?>


<div class="panel panel-default">
    <div class="panel-heading">
        <div class="panel-title"><h4>Settings</h4></div>
    </div>
    <form method="post">
        <div class="panel-body">
            <table class="table table-striped">
                <tr>
                    <td>Evanto API:</td>
                    <td>
                        <input
                                placeholder="Enter you Evanto API key"
                                value="<?php echo get_option(EAP_AUTHOR_KEY); ?>"
                                type="text"
                                name="eap_key"
                                required
                                class="form-control"/>
                    </td>
                </tr>
                <tr>
                    <td>Username:</td>
                    <td>
                        <input
                                placeholder="Enter your Evanto username"
                                value="<?php echo get_option(EAP_USERNAME); ?>"
                                type="text"
                                name="evanto_username"
                                required
                                class="form-control"/>
                    </td>
                </tr>
            </table>
        </div>
        <div class="panel-footer">
            <button class="btn btn-primary">Save</button>
        </div>
    </form>
</div>

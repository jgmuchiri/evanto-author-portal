<?php
if(isset($_POST['eap_key'])) {
    update_option(EAP_AUTHOR_KEY, htmlspecialchars(trim($_POST['eap_key'])));
}
?>
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
                                placeholder="Enter you Evant API key"
                                value="<?php echo get_option(EAP_AUTHOR_KEY); ?>"
                                type="text" name="eap_key" required class="form-control"/>
                    </td>
                </tr>
            </table>
        </div>
        <div class="panel-footer">
            <button class="btn btn-primary">Save</button>
        </div>
    </form>
</div>
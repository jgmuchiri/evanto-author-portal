function deletePurchases() {
    return  confirm('Are you sure?');
}
(function($) {
    $('.eap-table').DataTable(
        {
            "order": [[ 0, "desc" ]]
        }
    );
})( jQuery );
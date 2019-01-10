$('document').ready( function() {
    var form = $('#verify-envato-purchase');

    $('#verify-envato-purchase').submit(function(e){
        e.preventDefault();

        $.ajax( {
            type: "POST",
            url: form.attr( 'action' ),
            data: form.serialize(),
            success: function( response ) {
                $('#show-result').html(response);
            }
        } );
    } );
} );
function deletePurchases() {
    return  confirm('Are you sure?');
}
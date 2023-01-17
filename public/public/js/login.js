$(document).ready(function () {
    let formact = $('form').attr('action')
    $('input[type="checkbox"]').change(function () {
        let checkedValue = $('input[type="checkbox"]').is(":checked");
        if (checkedValue) {
            $('form').attr('action','/penilaian')
        } else {
            $('form').attr('action',formact)
        }
    })
})

function showQrcode() {
    $('#qr').modal('show');
}

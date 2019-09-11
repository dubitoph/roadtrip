jQuery(document).ready(function() {

    $('#vat_abbreviation').on('change', e => {

        $('#vat_state').val($('#vat_abbreviation option:selected').text());

    });

});
$(function() {


    $('#type, #threshold, #free_amount').change(function() {
        var type = $('#type').val();
        var threshold = $('#threshold').val();
        var freeAmount = $('#free_amount').val();

        if (type === 'quantity') {
            $('#free_amount_field').hide();
            $('#free_amount').val(0);
            $('#remarks').text('From unit 1 to ' + threshold +
                ' is free, more than that will be charges');
        } else if (type === 'order_units') {

            $('#free_amount_field').show();
            $('#remarks').text('From 1 unit to ' + threshold + ', will free additional ' +
                freeAmount + ' unit');
        }
    });

    $("#customer_name").autocomplete({

        source: function(request, response) {
            $.ajax({
                url: 'http://127.0.0.1:8000/admin/customers/search',
                data: {
                    term: request.term,
                    product_id: $('input[name="product_id"]').val()
                },
                success: function(data) {

                    response(data);
                }
            });
        },
        minLength: 2,
        select: function(event, ui) {
            // Do something when a customer is selected
            $('#user_id').val(ui.item.id);
            $('#additional_fields').show();
        }
    });
});

<script type="text/javascript">
var commodity_type_value, data;
(function($) {
    "use strict";

    acc_init_currency();
    appValidateForm($('#payment-entry-form'), {
        payment_date: 'required',
        number: 'required',
    });

    <?php if(isset($payment_entry->details)){ ?>
    data = <?php echo json_encode($payment_entry->details); ?>
    <?php }else{ ?>
    data = [{
            "account": "",
            "debit": "", 
            "description": ""
        },
        {
            "account": "",
            "debit": "", 
            "description": ""
        },
        {
            "account": "",
            "debit": "", 
            "description": ""
        },
        {
            "account": "",
            "debit": "", 
            "description": ""
        },
        {
            "account": "",
            "debit": "", 
            "description": ""
        },
        {
            "account": "",
            "debit": "", 
            "description": ""
        },
        {
            "account": "",
            "debit": "", 
            "description": ""
        },
        {
            "account": "",
            "debit": "", 
            "description": ""
        },
        {
            "account": "",
            "debit": "", 
            "description": ""
        },
        {
            "account": "",
            "debit": "", 
            "description": ""
        },
        {
            "account": "",
            "debit": "", 
            "description": ""
        },
        {
            "account": "",
            "debit": "", 
            "description": ""
        },
        {
            "account": "",
            "debit": "", 
            "description": ""
        },
        {
            "account": "",
            "debit": "", 
            "description": ""
        },
        {
            "account": "",
            "debit": "", 
            "description": ""
        },
        {
            "account": "",
            "debit": "", 
            "description": ""
        },
        {
            "account": "",
            "debit": "", 
            "description": ""
        },
        {
            "account": "",
            "debit": "", 
            "description": ""
        },
        {
            "account": "",
            "debit": "", 
            "description": ""
        },
        {
            "account": "",
            "debit": "", 
            "description": ""
        },
    ];
    <?php } ?>

    var hotElement1 = document.querySelector('#payment_entry_container');

    var commodity_type = new Handsontable(hotElement1, {
        contextMenu: true,
        manualRowMove: true,
        autoWrapRow: true,
        rowHeights: 30,
        stretchH: 'all',
        defaultRowHeight: 100,
        minRows: 10,
        licenseKey: 'non-commercial-and-evaluation',
        rowHeaders: true,
        autoColumnSize: {
            samplingRatio: 23
        },
        filters: true,
        manualRowResize: true,
        manualColumnResize: true,
        columnHeaderHeight: 40,
        colWidths: [200, 100, 300],
        rowHeights: 30,
        rowHeaderWidth: [44],
        columns: [{
                data: 'account',
                renderer: customDropdownRenderer,
                editor: "chosen",
                chosenOptions: {
                    data: <?php echo json_encode($account_to_select); ?>
                }
            },
            {
                type: 'numeric',
                data: 'debit',
                numericFormat: {
                    pattern: '0,0.00',
                },
            }, 
            {
                type: 'text',
                data: 'description',
            },

        ],
        colHeaders: [
            '<?php echo _l('acc_account'); ?>',
            '<?php echo _l('amount'); ?>',
            '<?php echo _l('description'); ?>'
        ],
        data: data,
        afterChange: (changes) => {
            if (changes != null) {
                var payment_entry = JSON.parse(JSON.stringify(commodity_type_value.getData()));
                var total_debit = 0;

                $.each(payment_entry, function(index, value) {
                    if (value[0] != '') {
                        if (value[1] != '' && value[1] != null) {
                            total_debit += parseFloat(value[1]);
                        }
                    }
                });

                $('.total_debit').html(format_money(total_debit));
            }
        }
    });
    commodity_type_value = commodity_type;

    $('.payment-entry-form-submiter').on('click', function() {
        $('input[name="payment_entry"]').val(JSON.stringify(commodity_type_value.getData()));
        var payment_entry = JSON.parse($('input[name="payment_entry"]').val());
        var total_debit = 0;
        $.each(payment_entry, function(index, value) {
            if (value[0] != '') {
                if (value[1] != '' && value[1] != null) {
                    total_debit += parseFloat(value[1]);
                }
            }
        });

        // if (total_debit.toFixed(2) == total_credit.toFixed(2)) {
            if (total_debit > 0) {
                $('input[name="amount"]').val(total_debit.toFixed(2));
                $('#payment-entry-form').submit();
            } else {
                alert('<?php echo _l('you must fill out at least one detail lines'); ?>');
            }
        // } else {
            // alert('<?php echo _l('please_balance_debits_and_credits'); ?>');
        // }
    });
})(jQuery);

function customDropdownRenderer(instance, td, row, col, prop, value, cellProperties) {
    "use strict";

    var selectedId;
    var optionsList = cellProperties.chosenOptions.data;

    if (typeof optionsList === "undefined" || typeof optionsList.length === "undefined" || !optionsList.length) {
        Handsontable.cellTypes.text.renderer(instance, td, row, col, prop, value, cellProperties);
        return td;
    }

    var values = (value + "").split("|");
    value = [];
    for (var index = 0; index < optionsList.length; index++) {

        if (values.indexOf(optionsList[index].id + "") > -1) {
            selectedId = optionsList[index].id;
            value.push(optionsList[index].label);
        }
    }
    value = value.join(", ");

    Handsontable.cellTypes.text.renderer(instance, td, row, col, prop, value, cellProperties);
    return td;
}

function calculate_amount_total() {
    "use strict";
    var payment_entry = JSON.parse(JSON.stringify(commodity_type_value.getData()));
    var total_debit = 0,
        total_credit = 0;
    $.each(payment_entry, function(index, value) {
        if (value[1] != '') {
            total_debit += parseFloat(value[1]);
        }
        if (value[2] != '') {
            total_credit += parseFloat(value[2]);
        }
    });

    $('.total_debit').html(format_money(total_debit));
    $('.total_credit').html(format_money(total_credit));
}

// Set the currency for accounting
function acc_init_currency() {
    "use strict";

    var selectedCurrencyId = <?php echo html_entity_decode($currency->id); ?>;

    requestGetJSON('misc/get_currency/' + selectedCurrencyId)
        .done(function(currency) {
            // Used for formatting money
            accounting.settings.currency.decimal = currency.decimal_separator;
            accounting.settings.currency.thousand = currency.thousand_separator;
            accounting.settings.currency.symbol = currency.symbol;
            accounting.settings.currency.format = currency.placement == 'after' ? '%v %s' : '%s%v';
        });
}




$(document).on("change" , "select[name='mode_of_payment']" ,function() {
   var val = $(this).val();
    if(val == "Cash"){
        $('select[name="modes_accounts"] option').each(function() {
            if ($(this).attr('data-value') == '10101') {
                $(this).show();
            } else if ($(this).attr('data-value') != undefined) {
                $(this).hide();
            }
        });
    }else{
        $('select[name="modes_accounts"] option').each(function() {
            if ($(this).attr('data-value') == '10102') {
                $(this).show();
            } else if ($(this).attr('data-value') != undefined) {
                $(this).hide();
            }
        });
    }
    $('select[name="modes_accounts"]').selectpicker('refresh');
    $('select[name="modes_accounts"]').val('').change();
});

</script>
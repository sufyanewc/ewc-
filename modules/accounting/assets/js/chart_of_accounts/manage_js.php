<script type="text/javascript">
var list_account_type_details, list_third_level, fnServerParams;

(function($) {
    "use strict";

    appValidateForm($('#account-form'), {
        account_type_id: 'required',
        account_detail_type_id: 'required',
        name: 'required',
    }, account_form_handler);
    
    appValidateForm($('#update-account-form'), {
        account_type_id: 'required',
        account_detail_type_id: 'required',
        name: 'required',
    }, account_update_form_handler);


    fnServerParams = {
        "ft_account": '[name="ft_account"]',
        "ft_search": '[name="ft_search"]',
    };

    $(document).on('change', 'select[name="parent_account"]', function() {
        $('.child_account_div').removeClass('hide');
        $('.sub_child_account_div').addClass('hide');
        let val = $(this).val();

        $('select[name="child_accounts"] option').each(function() {
            if ($(this).attr('data-value') === val) {
                $(this).show();
            } else if ($(this).attr('data-value') != undefined) {
                $(this).hide();
            }
        });
        $('select[name="child_accounts"]').selectpicker('refresh');
        $('select[name="child_accounts"]').val('').change();
    });




    $(document).on('change', 'select[name="child_accounts"]', function() {

        let val = $(this).val();
        if (val != "") {
            $('.sub_child_account_div').removeClass('hide');
            let val = $(this).val();
            $('select[name="sub_child_accounts"] option').each(function() {
                if ($(this).attr('data-value') === val) {
                    $(this).show();
                } else if ($(this).attr('data-value') != undefined) {
                    $(this).hide();
                }
            });
            $('select[name="sub_child_accounts"]').selectpicker('refresh');
            $('select[name="sub_child_accounts"]').val('').change();

        }
    });






    
    $(document).on('change', 'select[name="edit_parent_account"]', function() {
        $('.edit_child_account_div').removeClass('hide');
        $('.edit_sub_child_account_div').addClass('hide');
        let val = $(this).val();

        $('select[name="edit_child_accounts"] option').each(function() {
            if ($(this).attr('data-value') === val) {
                $(this).show();
            } else if ($(this).attr('data-value') != undefined) {
                $(this).hide();
            }
        });
        $('select[name="edit_child_accounts"]').selectpicker('refresh');
        $('select[name="edit_child_accounts"]').change();
    });




    $(document).on('change', 'select[name="edit_child_accounts"]', function() {

        let val = $(this).val();
        if (val != "") {
            $('.edit_sub_child_account_div').removeClass('hide');
            let val = $(this).val();
            $('select[name="edit_sub_child_accounts"] option').each(function() {
                if ($(this).attr('data-value') === val) {
                    $(this).show();
                } else if ($(this).attr('data-value') != undefined) {
                    $(this).hide();
                }
            });
            $('select[name="edit_sub_child_accounts"]').selectpicker('refresh');
            $('select[name="edit_sub_child_accounts"]').change();

        }
    });









    $('#filter_submit').on('click', function() {
        init_account_table();
    });


    list_account_type_details = <?php echo json_encode($detail_types); ?>;
    list_third_level = <?php echo json_encode($accounts_level); ?>;

    $('.add-new-account').on('click', function() {
        if (($('select[name="account_type_id"]').val() <= 10 || $('select[name="account_type_id"]').val() ==
                16) && $('select[name="account_type_id"]').val() != 1 && $('select[name="account_type_id"]')
            .val() != 6) {
            $('#div_balance').removeClass('hide');
        } else {
            $('#div_balance').addClass('hide');
        }

        $('#account-modal').find('button[type="submit"]').prop('disabled', false);

        // $('select[name="parent_account"]').val('').change();

        $('input[name="name"]').val('');
        $('input[name="balance"]').val('');
        $('input[name="balance_as_of"]').val('');

        tinyMCE.activeEditor.setContent('');
        $('textarea[name="description"]').val('');
        $('input[name="id"]').val('');
        $('#account-modal').modal('show');
    });

    var html = '';
    var note = 0;
    $.each(list_account_type_details, function(index, value) {
        if (value.account_type_id == $('select[name="account_type_id"]').val()) {
            if (note == 0) {
                $('#detail_type_note').val(value.note);
                note = 1;
            }
            html += '<option value="' + value.id + '">' + value.name + '</option>';
        }
    });

    $('select[name="account_detail_type_id"]').html(html);
    $('select[name="account_detail_type_id"]').selectpicker('refresh');

    var html1 = '';
    var note = 0;
    $.each(list_third_level, function(index, value) {
        if (value.account_type_id_type == $('select[name="account_detail_type_id"]').val()) {
            if (note == 0) {
                $('.parent_account_note').val(value.note);
                note = 1;
            }
            html1 += '<option value="' + value.id + '">' + value.name + '</option>';
        }
    });

    $('select[name="account_third_level"]').html(html1);
    $('select[name="account_third_level"]').selectpicker('refresh');



    $.each(list_account_type_details, function(index, value) {
        if (value.id == $('select[name="account_detail_type_id"]').val()) {
            $('.detail_type_note').html(value.note);
        }
    });

    init_account_table();

    $('select[name="account_type_id"]').on('change', function() {

        if (($(this).val() <= 10 || $(this).val() == 16) && $(this).val() != 1 && $(this).val() != 6 && $(
                'input[name="id"]').val() == '') {
            $('#div_balance').removeClass('hide');
        } else {
            $('#div_balance').addClass('hide');
        }

        var html = '';
        var note = 0;
        $.each(list_account_type_details, function(index, value) {
            if (value.account_type_id == $('select[name="account_type_id"]').val()) {
                if (note == 0) {
                    $('#detail_type_note').val(value.note);
                    note = 1;
                }
                html += '<option value="' + value.id + '">' + value.name + '</option>';
            }
        });

        $('select[name="account_detail_type_id"]').html(html);
        $('select[name="account_detail_type_id"]').selectpicker('refresh');

        var html1 = '';
        var note1 = 0;
        $.each(list_third_level, function(index, value) {
            if (value.account_type_id_type == $('select[name="account_detail_type_id"]').val()) {
                if (note == 0) {
                    $('#parent_account_note').val(value.note1);
                    note = 1;
                }
                html1 += '<option value="' + value.id + '">' + value.name + '</option>';
            }
        });

        $('select[name="account_third_level"]').html(html1);
        $('select[name="account_third_level"]').selectpicker('refresh');



        $.each(list_account_type_details, function(index, value) {
            if (value.id == $('select[name="account_detail_type_id"]').val()) {
                $('.detail_type_note').html(value.note);
            }
        });
    });

    $('select[name="account_detail_type_id"]').on('change', function() {
        $.each(list_account_type_details, function(index, value) {
            if (value.id == $('select[name="account_detail_type_id"]').val()) {
                $('.detail_type_note').html(value.note);
            }
        });


        var html1 = '';
        var note1 = 0;
        $.each(list_third_level, function(index, value) {
            if (value.account_type_id_type == $('select[name="account_detail_type_id"]').val()) {
                if (note == 0) {
                    $('.parent_account_note').val(value.note1);
                    note = 1;
                }
                html1 += '<option value="' + value.id + '">' + value.name + '</option>';
            }
        });

        $('select[name="account_third_level"]').html(html1);
        $('select[name="account_third_level"]').selectpicker('refresh');
    });

    $("input[data-type='currency']").on({
        keyup: function() {
            formatCurrency($(this));
        },
        blur: function() {
            formatCurrency($(this), "blur");
        }
    });

    $('input[name="mass_activate"]').on('change', function() {
        if ($('#mass_activate').is(':checked') == true) {
            $('#mass_delete').prop("checked", false);
            $('#mass_deactivate').prop("checked", false);
        }
    });

    $('input[name="mass_deactivate"]').on('change', function() {
        if ($('#mass_deactivate').is(':checked') == true) {
            $('#mass_delete').prop("checked", false);
            $('#mass_activate').prop("checked", false);
        }
    });

    $('input[name="mass_delete"]').on('change', function() {
        if ($('#mass_delete').is(':checked') == true) {
            $('#mass_activate').prop("checked", false);
            $('#mass_deactivate').prop("checked", false);
        }
    });

})(jQuery);

function edit_account(id) {
    "use strict";
    $('#edit-account-modal').find('button[type="submit"]').prop('disabled', false);

    requestGetJSON(admin_url + 'accounting/get_data_account/' + id).done(function(response) {
        $('#edit-account-modal').modal('show');


        if (response.HeadLevel == 4) {
            $('select[name="edit_sub_child_accounts"]').val(response.PHeadCode).change();
            $('.edit_sub_child_account_div').removeClass('hide');
        }else{
            $('select[name="edit_child_accounts"]').val(response.PHeadCode).change();
        }

        $('select[name="edit_child_accounts"]').val(response.PHeadCode2).change();
        $('select[name="edit_parent_account"]').val(response.PHeadCode3).change();


        $('input[name="number"]').val(response.number);
        $('input[name="edit_name"]').val(response.name);
        $('input[name="id"]').val(id);
        $('input[name="edit_balance"]').val(response.balance);
        $('input[name="edit_balance_as_of"]').val(response.balance_as_of);

        if (response.description != null) {
            tinyMCE.activeEditor.setContent(response.description);
        } else {
            tinyMCE.activeEditor.setContent('');
        }
        $('textarea[name="edit_description"]').val(response.description);
        console.log(response);

        if ((response.account_type_id <= 10 || response.account_type_id == 16) && response.account_type_id !=
            1 && response.account_type_id != 6) {
            //$('input[name="update_balance"]').val(0);
            $('#div_balance').removeClass('hide');
        } else {
            //$('input[name="update_balance"]').val(1);
            $('#div_balance').addClass('hide');
        }
    });
}

function account_form_handler(form) {
    "use strict";
    $('#account-modal').find('button[type="submit"]').prop('disabled', true);
    tinyMCE.triggerSave();

    var formURL = form.action;
    var formData = new FormData($(form)[0]);

    $.ajax({
        type: $(form).attr('method'),
        data: formData,
        mimeType: $(form).attr('enctype'),
        contentType: false,
        cache: false,
        processData: false,
        url: formURL
    }).done(function(response) {
        response = JSON.parse(response);
        if (response.success === true || response.success == 'true' || $.isNumeric(response.success)) {
            alert_float('success', response.message);
            setTimeout(function() {
                document.location.reload()
            }, 2000);

            init_account_table();
        } else {
            alert_float('danger', response.message);
        }
        $('#account-modal').modal('hide');
    }).fail(function(error) {
        alert_float('danger', JSON.parse(error.mesage));
    });

    return false;
}


function account_update_form_handler(form) {
    "use strict";
    $('#update-account-modal').find('button[type="submit"]').prop('disabled', true);
    tinyMCE.triggerSave();

    var formURL = form.action;
    var formData = new FormData($(form)[0]);

    $.ajax({
        type: $(form).attr('method'),
        data: formData,
        mimeType: $(form).attr('enctype'),
        contentType: false,
        cache: false,
        processData: false,
        url: formURL
    }).done(function(response) {
        response = JSON.parse(response);
        if (response.success === true || response.success == 'true' || $.isNumeric(response.success)) {
            alert_float('success', response.message);
            setTimeout(function() {
                document.location.reload()
            }, 2000);

            init_account_table();
        } else {
            alert_float('danger', response.message);
        }
        $('#update-account-modal').modal('hide');
    }).fail(function(error) {
        alert_float('danger', JSON.parse(error.mesage));
    });

    return false;
}




function formatNumber(n) {
    "use strict";
    // format number 1000000 to 1,234,567
    return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function formatCurrency(input, blur) {
    "use strict";
    // appends $ to value, validates decimal side
    // and puts cursor back in right position.

    // get input value
    var input_val = input.val();

    // don't validate empty input
    if (input_val === "") {
        return;
    }

    // original length
    var original_len = input_val.length;

    // initial caret position
    var caret_pos = input.prop("selectionStart");

    // check for decimal
    if (input_val.indexOf(".") >= 0) {

        // get position of first decimal
        // this prevents multiple decimals from
        // being entered
        var decimal_pos = input_val.indexOf(".");
        var minus = input_val.substring(0, 1);
        if (minus != '-') {
            minus = '';
        }

        // split number by decimal point
        var left_side = input_val.substring(0, decimal_pos);
        var right_side = input_val.substring(decimal_pos);
        // add commas to left side of number
        left_side = formatNumber(left_side);

        // validate right side
        right_side = formatNumber(right_side);

        // Limit decimal to only 2 digits
        right_side = right_side.substring(0, 2);

        // join number by .
        input_val = minus + left_side + "." + right_side;

    } else {
        // no decimal entered
        // add commas to number
        // remove all non-digits
        var minus = input_val.substring(0, 1);
        if (minus != '-') {
            minus = '';
        }
        input_val = formatNumber(input_val);
        input_val = minus + input_val;

    }

    // send updated string to input
    input.val(input_val);

    // put caret back in the right position
    var updated_len = input_val.length;
    caret_pos = updated_len - original_len + caret_pos;
    //input[0].setSelectionRange(caret_pos, caret_pos);
}

function init_account_table() {
    "use strict";

    if ($.fn.DataTable.isDataTable('.table-accounts')) {
        $('.table-accounts').DataTable().destroy();
    }
    initDataTable('.table-accounts', admin_url + 'accounting/accounts_table', [0], [0, 1, 2, 3, 4, 5, 6, 7, 8],
        fnServerParams, []);
    $('.dataTables_filter').addClass('hide');
}

// journal entry bulk actions action
function bulk_action(event) {
    "use strict";
    if (confirm_delete()) {
        var ids = [],
            data = {};
        data.mass_delete = $('#mass_delete').prop('checked');
        data.mass_activate = $('#mass_activate').prop('checked');
        data.mass_deactivate = $('#mass_deactivate').prop('checked');

        var rows = $($('#accounts_bulk_actions').attr('data-table')).find('tbody tr');

        $.each(rows, function() {
            var checkbox = $($(this).find('td').eq(0)).find('input');
            if (checkbox.prop('checked') === true) {
                ids.push(checkbox.val());
            }
        });
        data.ids = ids;

        $(event).addClass('disabled');
        setTimeout(function() {
            $.post(admin_url + 'accounting/accounts_bulk_action', data).done(function() {
                window.location.reload();
            });
        }, 200);
    }
}
</script>
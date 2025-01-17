<?php init_head();?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="panel_s">
                <div class="panel-body">
                    <?php $arrAtt = array();
                    $arrAtt['data-type']='currency';
                    ?>
                    <?php echo form_open_multipart($this->uri->uri_string(),array('id'=>'received-entry-form','autocomplete'=>'off')); ?>
                    <h4 class="no-margin font-bold">Received Voucher Entry</h4>
                    <hr />
                    <div class="row">
                        <div class="col-md-6">
                            <?php $value = (isset($received_entry->received_date) ? _d($received_entry->received_date) : _d(date('Y-m-d'))); ?>
                            <?php echo render_date_input('received_date','Received Date',$value); ?>
                        </div>
                        <div class="col-md-6">
                            <?php $value = (isset($received_entry->VNo) ? $received_entry->VNo : $voucher_no); ?>
                            <?php echo render_input('VNo','Voucher No',$value,'text' ,[ "readonly" =>"readonly" ]); ?>
                        </div>
                    </div>
                    <div class="row">
                       

                        <div class="col-md-6">
                            <?php $value = (isset($received_entry->reference_no) ? $received_entry->reference_no : null); ?>
                            <?php echo render_input('reference_no','Reference No',$value,'text'); ?>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-select">
                                <label class="bold"> <small class="req text-danger">* </small>mode Of payment</label>
                                <select class="selectpicker mode_of_payment" required name="mode_of_payment"
                                    data-width="100%">
                                    <option value=""></option>
                                    <option value="Cash"
                                        <?php echo ((isset($received_entry->mode_of_payment) && $received_entry->mode_of_payment == 'Cash' ) ? 'Selected' : null); ?>>
                                        Cash</option>
                                    <option value="Bank"
                                        <?php echo ((isset($received_entry->mode_of_payment) && $received_entry->mode_of_payment == 'Bank' ) ? 'Selected' : null); ?>>
                                        Bank</option>
                                </select>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="bold" for="modes_accounts"><small class="req text-danger">* </small>
                                Accounts</label>
                            <select class="selectpicker" required name="modes_accounts" id="modes_accounts"
                                data-width="100%">
                                <option value=""></option>
                                <?php 
                                    if (isset($modes_accounts)) {
                                        foreach ($modes_accounts as $key => $value) {
                                            $HeadCode = $value['HeadCode'] ; 
                                            $PHeadCode = $value['PHeadCode'] ; 
                                            $name = $value['name'] ; 
                                            $selected = ((isset($received_entry->modes_accounts) && $received_entry->modes_accounts == $value['HeadCode'] ) ? 'Selected' : null); 
                                            echo '<option value="'.$HeadCode.'" data-value="'.$PHeadCode.'" '.$selected.' >'.$name .' - ' .$HeadCode .' </option>' ; 
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                    </div>

                    <?php
                    if(isset($invoice_id)){
                    ?>
                      <br>
                        <div class="row">
                            <div class="col-md-6">
                                <?php $value = (isset($invoice_total) ? $invoice_total : null); ?>
                                <?php echo render_input('invoice_total','invoice Total',$value,'text' , ['disabled' =>'disabled']); ?>
                            </div>
                            <div class="col-md-6">
                                <?php $value = (isset($invoice_paid) ? $invoice_paid : null); ?>
                                <?php echo render_input('invoice_paid','invoice paid',$value,'text' , ['disabled' =>'disabled']); ?>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                    <br>
                    <br>
                    <div id="received_entry_container"></div>
                    <div class="col-md-8 col-md-offset-4">
                        <table class="table text-right">
                            <tbody>
                                <tr>
                                    <td></td>
                                    <td class="text-right bold"><?php echo _l('amount'); ?></td>
                                </tr>
                                <tr>
                                    <td><span class="bold"><?php echo _l('invoice_total'); ?> :</span>
                                    </td>
                                    <td class="total_debit">
                                        <?php $value = (isset($received_entry) ? $received_entry->amount : 0); ?>
                                        <?php echo app_format_money($value, $currency->name); ?>
                                    </td>

                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <?php echo form_hidden('received_entry'); ?>
                    <?php echo form_hidden('amount'); ?>
                    <div class="row">
                        <div class="col-md-12">
                            <p class="bold"><?php echo _l('dt_expense_description'); ?></p>
                            <?php $value = (isset($received_entry) ? $received_entry->description : ''); ?>
                            <?php echo render_textarea('description','',$value,array(),array(),'','tinymce'); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="modal-footer">
                                <button type="button"
                                    class="btn btn-info received-entry-form-submiter"><?php echo _l('submit'); ?></button>
                            </div>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>
</body>

</html>
<?php require 'modules/accounting/assets/js/received_entry/received_entry_js.php';?>
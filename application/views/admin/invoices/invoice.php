<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
	<div class="content">
		<div class="row">
			<?php
			echo form_open($this->uri->uri_string(),array('id'=>'invoice-form','class'=>'_transaction_form invoice-form'));
			if(isset($invoice)){
				echo form_hidden('isedit');
			}
			?>
			<div class="col-md-12">
				<?php $this->load->view('admin/invoices/invoice_template'); ?>
			</div>
			<?php echo form_close(); ?>
			<?php $this->load->view('admin/invoice_items/item'); ?>
		</div>
	</div>
</div>
<?php init_tail(); ?>


<script>
	$("#conversionrate").keyup(function(){
      var conversionrate = $("#conversionrate").val();
      var total = $('input[name="total"]').val();
      
      var totalconverted = conversionrate * total;
      $('.Coversionrate').html('PKR ' + totalconverted + '.00');
    });
	
	$(function(){
		validate_invoice_form();
	    init_currency();
	    init_ajax_project_search_by_customer_id();
	    init_ajax_search('items','#item_select.ajax-search',undefined,admin_url+'items/search');
	});
</script>
</body>
</html>
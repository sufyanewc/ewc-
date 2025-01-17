<?php defined('BASEPATH') or exit('No direct script access allowed');

$table_data = array(
  _l('invoice_dt_table_heading_number'),
  _l('invoice_dt_table_heading_amount'),
  array(
    'name'=>_l('invoice_estimate_year'),
    'th_attrs'=>array('class'=>'not_visible')
  ),
  _l('invoice_dt_table_heading_date'),
  array(
    'name'=>_l('invoice_dt_table_heading_client'),
    'th_attrs'=>array('class'=>(isset($client) ? 'not_visible' : ''))
  ),
  'Phone Number',
  _l('project'),
  _l('Received'),
  _l('Due Amounts'),
  _l('invoice_dt_table_heading_status'));
  
$custom_fields = get_custom_fields('invoice',array('show_on_table'=>1));

foreach($custom_fields as $field){
  array_push($table_data,$field['name']);
}
$table_data = hooks()->apply_filters('invoices_table_columns', $table_data);
render_datatable($table_data, (isset($class) ? $class : 'invoices'));
?>
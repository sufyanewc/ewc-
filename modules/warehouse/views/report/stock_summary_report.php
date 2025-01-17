  <div class="col-md-12">
     <?php echo form_open_multipart(admin_url('warehouse/stock_summary_report_pdf'), array('id'=>'print_report')); ?>
<div class="row">
    <!-- <div class="col-md-12 "> -->
        <div class=" col-md-3">
          <div class="form-group">
          <label><?php echo _l('warehouse_name') ?></label>
          <select name="warehouse_filter[]" id="warehouse_filter" class="selectpicker" multiple="true" data-live-search="true" data-width="100%" data-none-selected-text="" data-actions-box="true">

              <?php foreach($warehouse_filter as $warehouse) { ?>
                <option value="<?php echo html_entity_decode($warehouse['warehouse_id']); ?>"><?php echo html_entity_decode($warehouse['warehouse_name']); ?></option>
                <?php } ?>
            </select>
            </div>
        </div>

        <div class=" col-md-3 ">
          <?php $this->load->view('warehouse/item_include/item_select', ['select_name' => 'commodity_filter[]', 'id_name' => 'commodity_filter', 'multiple' => false,  'label_name' => 'commodity']); ?>
        </div>

      <div class="col-md-2">
        <?php echo render_date_input('from_date','from_date',date('Y-m-d',strtotime('-7 day',strtotime(date('Y-m-d'))))); ?>
      </div>
      <div class="col-md-2">
        <?php echo render_date_input('to_date','to_date',date('Y-m-d')); ?>
      </div>
      <div class="col-md-1 button-pdf-margin-top">
        <div class="form-group">
          <div class="btn-group">
           <a href="#" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-file-pdf-o"></i><?php if(is_mobile()){echo ' PDF';} ?> <span class="caret"></span></a>
           <ul class="dropdown-menu dropdown-menu-right">
              <li class="hidden-xs"><a href="?output_type=I" target="_blank" onclick="stock_submit(this); return false;"><?php echo _l('download_pdf'); ?></a></li>
             
           </ul>
           </div>
         </div>
      </div>
      <div class="col-md-1" >
        <a href="#" onclick="get_data_stock_summary_report(); return false;" class="btn btn-info button-pdf-margin-top" ><?php echo _l('_filter'); ?></a>
      </div>

    <!-- </div> -->
    </div>

    <?php echo form_close(); ?>
  </div>
<hr class="hr-panel-heading" />
  <div class="col-md-12" id="report">
      <div class="panel panel-info col-md-12 panel-padding">
      
        <div class="panel-body" id="stock_s_report">
            <p><h3 class="bold text-center"><?php echo mb_strtoupper(_l('stock_summary_report')); ?></h3></p>

            <div class="col-md-12">
              <div class="table-responsive">
             <table class="table table-bordered">
              <tbody>
               <tr>
                 <th class="text-center">CATEGORY</th>
                 <th class="text-center">SUB CATEGORY</th>
                 <th class="text-center">SKU CODE</th>
                 <th class="text-center">NAME</th>
                 <th class="text-center">FEET</th>
                 <th class="text-center">METER</th>
                 <th class="text-center">Quantity</th>
                 <th class="text-center">Tag Price</th>
                 <th class="text-center">Purchase Price</th>
                </tr>
                

                <tr>
                  <td>.....</td>
                  <td>.....</td>
                  <td>.....</td>
                  <td>.....</td>
                  <td>.....</td>
                  <td>.....</td>
                  <td>.....</td>
                  <td>.....</td>
                  <td>.....</td>
               
                </tr>
                
                <tr>
                 <th class="text-center">CATEGORY</th>
                 <th class="text-center">SUB CATEGORY</th>
                 <th class="text-center">SKU CODE</th>
                 <th class="text-center">NAME</th>
                 <th class="text-center">FEET</th>
                 <th class="text-center">METER</th>
                 <th class="text-center">Quantity</th>
                 <th class="text-center">Tag Price</th>
                 <th class="text-center">Purchase Price</th>
                </tr>
              </tbody>
            </table>
          </div>
          </div>

           

            <br>
              

            <br>
            <br>
            <br>
            <br>

        </div>
      </div>
  </div>

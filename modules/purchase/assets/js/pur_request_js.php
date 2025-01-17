<script>
(function($) {
"use strict";  

appValidateForm($('#add_edit_pur_request-form'),{pur_rq_code:'required', pur_rq_name:'required', department:'required'});
<?php if(isset($pur_request)){
 ?>
var dataObject = <?php echo html_entity_decode($pur_request_detail); ?>;
var hotElement = document.querySelector('#example');
    var hotElementContainer = hotElement.parentNode;
    var hotSettings = {
      data: dataObject,
      columns: [
        {
          data: 'prd_id',
          type: 'numeric',
      
        },
        {
          data: 'pur_request',
          type: 'numeric',
      
        },
        {
          data: 'item_code',
          renderer: customDropdownRenderer,
          editor: "chosen",
          width: 150,
          chosenOptions: {
              data: <?php echo json_encode($items); ?>
          }
        },
        {
          data: 'unit_id',
          renderer: customDropdownRenderer,
          editor: "chosen",
          width: 150,
          chosenOptions: {
              data: <?php echo json_encode($units); ?>
          },
          readOnly: true
     
        },
        
        {
          data: 'size',
          width: 150,
          type: 'numeric',
        },
        
        
        {
          data: 'unit_price',
          type: 'numeric',
          numericFormat: {
            pattern: '0,0'
          },
          
        },
        {
          data: 'quantity',
          type: 'numeric',
      
        },
        {
          data: 'into_money',
          type: 'numeric',
          numericFormat: {
            pattern: '0,0'
          },
          readOnly: true
        },
        {
          data: 'inventory_quantity',
          type: 'numeric',
          readOnly: true
        },
      
      ],
      licenseKey: 'non-commercial-and-evaluation',
    //  stretchH: 'all',
    //  width: '100%',
    //  autoWrapRow: true,
      rowHeights: 30,
      columnHeaderHeight: 40,
      minRows: 10,
      maxRows: 22,
      rowHeaders: true,
      
      colHeaders: [
        '<?php echo ''; ?>',
        '<?php echo ''; ?>',
        '<?php echo _l('items'); ?>',
        '<?php echo _l('unit'); ?>',
        'Size',
        '<?php echo _l('unit_price'); ?>',
        '<?php echo _l('quantity'); ?>',
        '<?php echo _l('total'); ?>',
        '<?php echo _l('inventory_quantity'); ?>'
        
      ],
       columnSorting: {
        indicator: true
      },
      autoColumnSize: {
        samplingRatio: 23
      },
      dropdownMenu: true,
      mergeCells: true,
      contextMenu: true,
      manualRowMove: true,
      manualColumnMove: true,
      multiColumnSorting: {
        indicator: true
      },
      hiddenColumns: {
        columns: [0,1,7],
        indicators: true
      },
      filters: true,
      manualRowResize: true,
      manualColumnResize: true
    };


var hot = new Handsontable(hotElement, hotSettings);
hot.addHook('afterChange', function(changes, src) {
    changes.forEach(([row, prop, oldValue, newValue]) => {
      if(prop == 'item_code'){
        $.post(admin_url + 'purchase/items_change/'+newValue).done(function(response){
          response = JSON.parse(response);

          hot.setDataAtCell(row,3, response.value.unit_id);
          hot.setDataAtCell(row,4, response.value.purchase_price);
          hot.setDataAtCell(row,6, response.value.purchase_price*hot.getDataAtCell(row,5));
          hot.setDataAtCell(row,7, response.value.inventory);
        });

      }else if(prop == 'quantity'){
        hot.setDataAtCell(row,6, newValue*hot.getDataAtCell(row,4));
      }else if(prop == 'unit_price'){
        hot.setDataAtCell(row,6, newValue*hot.getDataAtCell(row,5));
      }

    });
  });
$('.save_detail').on('click', function() {
  $('input[name="request_detail"]').val(JSON.stringify(hot.getData()));   
});
<?php }else{ ?>
  var dataObject = [
      
    ];
  var hotElement = document.querySelector('#example');
    var hotElementContainer = hotElement.parentNode;
    var hotSettings = {
      data: dataObject,
      columns: [
        {
          data: 'item_code',
          renderer: customDropdownRenderer,
          editor: "chosen",
          width: 150,
          chosenOptions: {
              data: <?php echo json_encode($items); ?>
          }
        },
        {
          data: 'unit_id',
          renderer: customDropdownRenderer,
          editor: "chosen",
          width: 150,
          chosenOptions: {
              data: <?php echo json_encode($units); ?>
          },
          readOnly: true
     
        },
        
        {
          data: 'size',
          width: 150,
          type: 'numeric',
        },
        
        {
          data: 'unit_price',
          type: 'numeric',
          numericFormat: {
            pattern: '0,0'
          },
          
        },
        {
          data: 'quantity',
          type: 'numeric',
      
        },
        {
          data: 'into_money',
          type: 'numeric',
          numericFormat: {
            pattern: '0,0'
          },
          readOnly: true
        },
        {
          data: 'inventory_quantity',
          type: 'numeric',
          readOnly: true
        },
      
      ],
      licenseKey: 'non-commercial-and-evaluation',
    //  stretchH: 'all',
      width: '100%',
    //  autoWrapRow: true,
      rowHeights: 30,
      columnHeaderHeight: 40,
      minRows: 10,
      maxRows: 22,
      rowHeaders: true,
      
      colHeaders: [
        '<?php echo _l('items'); ?>',
        '<?php echo _l('unit'); ?>',
        'Size',
        '<?php echo _l('unit_price'); ?>',
        '<?php echo _l('quantity'); ?>',
        '<?php echo _l('total'); ?>',
        '<?php echo _l('inventory_quantity'); ?>'
        
      ],
       columnSorting: {
        indicator: true
      },
      autoColumnSize: {
        samplingRatio: 23
      },
      dropdownMenu: true,
      mergeCells: true,
      contextMenu: true,
      manualRowMove: true,
      manualColumnMove: true,
      multiColumnSorting: {
        indicator: true
      },
      hiddenColumns: {
      //  columns: [5],
        indicators: true
      },
      filters: true,
      manualRowResize: true,
      manualColumnResize: true
    };


var hot = new Handsontable(hotElement, hotSettings);
hot.addHook('afterChange', function(changes, src) {
    changes.forEach(([row, prop, oldValue, newValue]) => {
      if(prop == 'item_code'){
        $.post(admin_url + 'purchase/items_change/'+newValue).done(function(response){
          response = JSON.parse(response);

          hot.setDataAtCell(row,1, response.value.unit_id);
          hot.setDataAtCell(row,3, response.value.purchase_price);
          hot.setDataAtCell(row,5, response.value.purchase_price*hot.getDataAtCell(row,4));
          hot.setDataAtCell(row,6, response.value.inventory);
        });

      }else if(prop == 'quantity'){
        hot.setDataAtCell(row,5, newValue*hot.getDataAtCell(row,3));
      }else if(prop == 'unit_price'){
        hot.setDataAtCell(row,5, newValue*hot.getDataAtCell(row,4));
      }

    });
  });
$('.save_detail').on('click', function() {
  $('input[name="request_detail"]').val(JSON.stringify(hot.getData()));   
});
<?php } ?>
})(jQuery);    

function customDropdownRenderer(instance, td, row, col, prop, value, cellProperties) {
  "use strict";  
  var selectedId;
  var optionsList = cellProperties.chosenOptions.data;
  
  if(typeof optionsList === "undefined" || typeof optionsList.length === "undefined" || !optionsList.length) {
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
</script>
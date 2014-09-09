jQuery(document).ready(function(){    
    RxOptionPage();
});


function RxOptionPage(){

    initColors();
    function initColors(){   
        /*  
        jQuery('#generalCol').ColorPicker({
            onSubmit: function(hsb, hex, rgb, el) {
                jQuery(el).val(hex);
                jQuery(el).ColorPickerHide();
            },
            onBeforeShow: function () {
                jQuery(this).ColorPickerSetColor(this.value);
            }            
        }).bind('keyup', function(){
            jQuery(this).ColorPickerSetColor(this.value);
        });
        */

    jQuery('#generalCol').colpick({
      layout:'hex',
      submit:0,
      colorScheme:'dark',
      color: jQuery('#generalCol').val(),
      onChange:function(hsb,hex,rgb,el,bySetColor) {
        jQuery(el).css('border-color','#'+hex);
        // Fill the text box just if the color was set using the picker, and not the colpickSetColor function.
        if(!bySetColor) jQuery(el).val(hex);
      }
    }).keyup(function(){
      jQuery(this).colpickSetColor(this.value);
    }); 

        jQuery('#resetRxColorsBTN').click(function(e){
            e.preventDefault();
            jQuery('#generalCol').val('1abb9f');         
        });        
    }


    
}

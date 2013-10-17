jQuery(document).ready(function(){    
    RxOptionPage();
});


function RxOptionPage(){

    initColors();
    function initColors(){     
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
        jQuery('#resetRxColorsBTN').click(function(e){
            e.preventDefault();
            jQuery('#generalCol').val('1abb9f');         
        });        
    }


    
}

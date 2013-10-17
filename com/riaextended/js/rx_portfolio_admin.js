jQuery(document).ready(function(){    
    rx_portfolio_admin = new RxPortfolioAdmin();
});

function RxPortfolioAdmin(){                    
    
   var post_meta = jQuery('#featured_images_rx_portfolio').attr('data-post_meta');
   initSortableFeaturedImages();
   function initSortableFeaturedImages(){
       jQuery("#featuredImagesUI").sortable({
            placeholder: "ui-state-highlight",
            stop: function( event, ui ){     
            }
        });
        jQuery("#featuredImagesUI").disableSelection(); 
        jQuery("#featuredImagesUI").children().each(function(indx){
            thumbsHoverAction(jQuery(this).find('.featuredThumbOverlay'));
            jQuery(this).find('.thumbOverlayRemove').click(function(e){
                e.preventDefault();
                if(confirm('Are you sure you want to remove this image?')){
                    jQuery(this).parent().parent().parent().remove();                    
                    checkChildrens();  
                }                                
            });
        });       
   }
   
   
   function checkChildrens(){       
       var dummyData = '<input id="dummyFeaturedImagesDATA" type="hidden" name="'+post_meta+'[featuredImages]" value="" />';
       var children = jQuery("#featuredImagesUI").children();   
       if(children.length==0){
           removeDummyFeaturedData();
           jQuery(dummyData).appendTo(jQuery('#featuresThumbsContainer'));
       }else{
           removeDummyFeaturedData();
       }
   } 
   
   function removeDummyFeaturedData(){
       try{
           jQuery('#dummyFeaturedImagesDATA').remove();
       }catch(e){}
   }     

    
   //add featured images
   handleFeaturedImagesUpload();
   function handleFeaturedImagesUpload(){
       jQuery('#removeAllFeaturedImagesBTN').click(function(e){
           e.preventDefault();
           try{
               var children = jQuery("#featuredImagesUI").children();               
               if(children.length==0){
                   alert('There are no featured images');
                   return;
               }
               if(confirm('Are you sure you want to remove all images?')){
                   jQuery("#featuredImagesUI").empty();
                   checkChildrens();
               }
           }catch(e){}
       });
       jQuery('#addFeaturedImagesBTN').click(function(e){
              e.preventDefault();
              var send_attachment_bkp = wp.media.editor.send.attachment;
                    var frame = wp.media({
                        title: "Select Images",
                        multiple: true,
                        library: { type: 'image' },
                        button : { text : 'add image' }
                    });
                    
                    frame.on('close',function() {                        
                        var selection = frame.state().get('selection');
                        selection.each(function(attachment) {                               
                               var iconUrl = 'http://placehold.it/150x150';
                               if(attachment.attributes.sizes.thumbnail!=undefined){
                                   iconUrl = (attachment.attributes.sizes.thumbnail.url!='')?attachment.attributes.sizes.thumbnail.url:iconUrl;
                               }                              
                               featuredImageHTML = '<li class="ui-state-default"><div class="thumbBoxImage">';
                               featuredImageHTML += '<div class="featuredThumb"><img src="'+iconUrl+'" /></div>';
                               featuredImageHTML += '<input type="hidden" name="'+post_meta+'[featuredImages][]" value="'+attachment.id+'" />';
                               featuredImageHTML += '<div class="featuredThumbOverlay">';
                               featuredImageHTML +='<div class="thumbOverlayMove"></div>';
                               featuredImageHTML +='<div class="thumbOverlayRemove"></div>';
                               featuredImageHTML +='</div>';
                               featuredImageHTML += '</div></li>';
                               var featuredImageJq = jQuery(featuredImageHTML);
                               featuredImageJq.appendTo("#featuredImagesUI");
                               jQuery("#featuredImagesUI").sortable("refresh"); 
                               
                               checkChildrens(); 
                               
                               thumbsHoverAction(featuredImageJq.find('.featuredThumbOverlay'));
                               featuredImageJq.find('.thumbOverlayRemove').click(function(e){
                                    e.preventDefault();
                                    if(confirm('Are you sure you want to remove this image?')){
                                        jQuery(this).parent().parent().parent().remove();
                                        checkChildrens();   
                                    }
                               });                                       
                        });
                         wp.media.editor.send.attachment = send_attachment_bkp;
                    });                                  
                            
                    frame.open();
             return false;            
       });
   }   
   
   
   function thumbsHoverAction(el){
       el.css('opacity', 0);       
       el.hover(function(e){
           TweenMax.to(jQuery(this), .2, {css:{opacity:1}, ease:Power4.EaseIn});
       }, function(e){
           TweenMax.to(jQuery(this), .2, {css:{opacity:0}, ease:Power4.EaseIn});
       });
   }
       
          
}




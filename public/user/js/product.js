getProductList();
refreshCart();
function getProductList(){
	jQuery.ajax({
		url : jQuery('body').data('url')+'/product-list',
        method : 'get',
        dataType : 'json',
        success : function(response){
        	if(response.status){
            	jQuery('.product-list').html(jQuery.parseHTML(response.view));
            }
        }
    });
}
function refreshCart(){
    jQuery.ajax({
        url : jQuery('body').data('url')+'/refresh-cart',
        method : 'get',
        dataType : 'json',
        success : function(response){
            if(response.status){
                jQuery('.cart-items').html(jQuery.parseHTML(response.view));
                jQuery('.cart-total').html('$'+response.total);
                jQuery('.cart-count').html(response.item_count);
                if(response.item_count == 0){
                    jQuery('.cart-total-div').css('display','none');
                }else{
                    jQuery('.cart-total-div').css('display','block');
                }
            }
        }
    });
}
jQuery(document).ready(function(){
    //update cart (add,update,delete)
    jQuery(document).on('click','.update-cart',function(e){
        var ele = jQuery(this);
        jQuery.ajax({
            url : jQuery('body').data('url')+'/update-cart',
            method : 'post',
            dataType : 'json',
            data : {
                product : jQuery(this).data('pst'),
                quantity : jQuery(this).data('qty')
            },
            success : function(response){
                if(ele.hasClass('add-to-cart')){
                    //ele.parent('.update-cart-div').css('display','none');
                    //ele.parent('.update-cart-div').siblings('.counter-div').css('display','block');
                }
                refreshCart();
            }
        });
        e.preventDefault();
    });

    //store address
    jQuery(document).on('submit','.user-address',function(e){
        jQuery.ajax({
            url : jQuery(this).attr('action'),
            method : 'post',
            dataType : 'json',
            data : jQuery(this).serialize(),
            success : function(response){
                jQuery('#addAddress').modal('toggle');
                jQuery('#reviewCart').modal('toggle');
            }
        });
        e.preventDefault();
    });

    jQuery(document).on('click','.change-address',function(e){
        jQuery('#reviewCart').modal('hide');
        jQuery('#addAddress').modal('show');
        e.preventDefault();
    });

    //counter to increase decrease quantity
    function increaseValue() {
        var value = parseInt(jQuery('.number').val(), 10);
        value = isNaN(value) ? 0 : value;
        value++;
        jQuery('.number').val(value);
    }

    function decreaseValue() {
        var value = parseInt(jQuery('.number').val(), 10);
        value = isNaN(value) ? 0 : value;
        value < 1 ? value = 1 : '';
        value--;
        jQuery('.number').val(value);
    }

    //place order
    jQuery(document).on('click','.place-order',function(e){
        jQuery.ajax({
            url : jQuery('body').data('url')+'/place-order',
            method : 'post',
            dataType : 'json',
            data : {
                sct : jQuery(this).data('sct'),
                pay : jQuery("input[name='pay']:checked").val()
            },
            success : function(response){
                jQuery('#reviewCart').modal('hide');
                refreshCart();
            }
        });
        e.preventDefault();
    });
});
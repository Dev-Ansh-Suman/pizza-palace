getProductList();
refreshCart();
getOrderList();
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
                jQuery('.cart-total-euro').html('€'+response.total_euro);
                jQuery('.cart-count').html(response.item_count);
                if(response.item_count == 0){
                    jQuery('.cart-total-div').css('display','none');
                }else{
                    jQuery('.cart-total-div').css('display','block');
                }
                setGetCurrency(0);
            }
        }
    });
}
function getOrderList(){
    jQuery.ajax({
        url : jQuery('body').data('url')+'/order-list',
        method : 'get',
        dataType : 'json',
        success : function(response){
            if(response.status){
                jQuery('.order-list').html(jQuery.parseHTML(response.view));
            }
        }
    });
}
function getOrder(token){
    jQuery.ajax({
        url : jQuery('body').data('url')+'/order/token',
        method : 'get',
        dataType : 'json',
        success : function(response){
            if(response.status){
                jQuery('.order-detail').html(jQuery.parseHTML(response.view));
            }
        }
    });
}
function setGetCurrency(curr=0){
    jQuery.ajax({
        url : jQuery('body').data('url')+'/get-currency',
        method : 'post',
        dataType : 'json',
        data : {
            curr : curr
        },
        success : function(response){
            if(response.currency == 1){
                jQuery('.euro-price').css('display','none');
                jQuery('.usd-price').css('display','inline-block');
                jQuery("#usd").prop('checked','checked');
            }else{
                jQuery('.usd-price').css('display','none');
                jQuery('.euro-price').css('display','inline-block');
                jQuery("#euro").prop('checked','checked');
            }
        }
    });
}
function addToCart(ele,qty,pst){
    jQuery.ajax({
        url : jQuery('body').data('url')+'/update-cart',
        method : 'post',
        dataType : 'json',
        data : {
            product : pst,
            quantity : qty
        },
        success : function(response){
            if(ele.hasClass('add-to-cart')){
                ele.parent('.update-cart-div').css('display','none');
                ele.parent('.update-cart-div').siblings('.counter-div').css('display','block');
            }
            refreshCart();
        }
    });
}
jQuery(document).ready(function(){
    //update cart (add,update,delete)
    jQuery(document).on('click','.update-cart',function(e){
        var ele = jQuery(this);
        var pst = ele.data('pst');
        var qty = ele.data('qty');
        addToCart(ele,qty,pst);
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
    jQuery(document).on('click','.value-button',function(){
        var ele = jQuery(this).siblings('.number');
        var value = parseInt(ele.val(), 10);
        value = isNaN(value) ? 1 : value;
        if(jQuery(this).hasClass('decrease')){
            if(value > 0){
                value--;
            }
        }else if(jQuery(this).hasClass('increase')){
            value++;
        }
        var ele = jQuery(this).siblings('.number');
        ele.val(value);
        ele.data('qty',value);
        var pst =  ele.data('pst');
        addToCart(ele,value,pst);
    });

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

    //currency change functionality
    jQuery(document).on('change','.currency-switch',function(){
        var curr = 1;
        if(jQuery('#usd').is(":checked")){
            jQuery('.euro-price').css('display','none');
            jQuery('.usd-price').css('display','block');
            curr = 1;
        }else{
            jQuery('.usd-price').css('display','none');
            jQuery('.euro-price').css('display','block');
            curr = 2;
        }
        setGetCurrency(curr);
    });
});
$(document).ready(function(){
    //
});
								
function buyItem(id, im){
    $.get('/cart/add/' + id + '/',function (response){
        $("header .info").html(response);
        
        var cart = $('a.cart');
        var image = $(im).find('img:visible');
        
        if(cart.length && image.length){
            image.clone().css({
                'position' : 'absolute', 
                'z-index' : '5000',
                'top': image.offset().top,
                'left': image.offset().left,
                'width': image.width(),
                'opacity': 0.7
            }).appendTo($('body')).animate({
                opacity: 0.1,  
                top: cart.offset().top, 
                left: cart.offset().left,
                width: 50 
             }, 700, function() {  
                $(this).remove();  
            });
        }
    });
}

function incItem($incLink){
    shiftItem($incLink, +1);
}

function decItem($decLink){
    shiftItem($decLink, -1);
}

function shiftItem($shiftLink, shift){
    var $row = $shiftLink.parents('tr:first');
    var $qntInput = $row.find('input[name^=quantity]');
    var $priceInput = $row.find('input[name^=price]');
    var qnt = parseInt($qntInput.val());
    var price = parseInt($priceInput.val());
    var $costCell = $row.find('td.cost');
    
    qnt = qnt + shift;
    
    if (qnt > 0) {
        $qntInput.val(qnt);
        $costCell.html(formatRouble(price * qnt));
        
        updateCart();
    }
}

function updateCart(){
    var totalQnt = 0; var totalSum = 0;
    $('#cart').find('input[name^=quantity]').each(function(){
        var $qntInput = $(this);
        var $priceInput = $qntInput.parent().find('input[name^=price]');
        var qnt = parseInt($qntInput.val());
        var price = parseInt($priceInput.val());
        totalQnt += qnt;
        totalSum += qnt * price;
    });
    
    var $totalRow = $('#cart').find('tr:last');
    var $totalQntCell = $totalRow.find('td.quantity');
    var $totalSumCell = $totalRow.find('td.cost');
    $totalQntCell.html(totalQnt);
    $totalSumCell.html(formatRouble(totalSum));
    
    $('#cart').ajaxSubmit(function(response){
        $("header .info").html(response);
    });
}

function formatRouble(sum){
    return Intl.NumberFormat().format(sum) + ' <span class="rouble">Р</span>';
}


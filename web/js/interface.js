$(document).ready(function(){
    //
});
								
function buyItem(link){
    $.get(link.attr('href'),function (response){
        $(".cart").parent().html(response);
    });
    return false;
}

function incItem($incLink){
    shiftItem($incLink, +1);
}

function decItem($decLink){
    shiftItem($decLink, -1);
}

function shiftItem($shiftLink, shift){
    var $row = $shiftLink.parents('tr:first');
    var $qntInput = $row.find('input[name^=cart]');
    var $priceInput = $row.find('input[name^=price]');
    var qnt = parseInt($qntInput.val());
    var price = parseInt($priceInput.val());
    var $costCell = $row.find('td.cost p');
    
    qnt = qnt + shift;
    
    if (qnt > 0) {
        $qntInput.val(qnt);
        $costCell.html(price * qnt);
        
        updateCart();
    }
}

function updateCart(){
    var totalQnt = 0; var totalSum = 0;
    $('#cart').find('input[name^=cart]').each(function(){
        var $qntInput = $(this);
        var $priceInput = $qntInput.parent().find('input[name^=price]');
        var qnt = parseInt($qntInput.val());
        var price = parseInt($priceInput.val());
        totalQnt += qnt;
        totalSum += qnt * price;
    });
    
    var $totalRow = $('#cart').find('tr:last');
    var $totalSumCell = $totalRow.find('td.cost b');
    $totalSumCell.html(totalSum + ' p.');
    
    $('#cart').ajaxSubmit(function(response){
        $(".cart").parent().html(response);
    });
}



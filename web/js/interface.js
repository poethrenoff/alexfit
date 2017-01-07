$(document).ready(function(){
    //
});
								
function buyItem($buyLink){
    $.get($buyLink.attr('href'),function (response){
        $(".cart").parent().html(response);
    });
    return false;
}

function incItem($incLink){
    $.get($incLink.attr('href'),function (response){
        $(".cart").parent().html(response);
    });
    return shiftItem($incLink, +1);
}

function decItem($decLink){
    $.get($decLink.attr('href'),function (response){
        $(".cart").parent().html(response);
    });
    return shiftItem($decLink, -1);
}

function shiftItem($shiftLink, shift){
    var $row = $shiftLink.parents('tr:first');
    var $qntCell = $row.find('td.quantity p');
    var $priceCell = $row.find('td.price p');
    var qnt = parseInt($qntCell.html());
    var price = parseInt($priceCell.html());
    var $costCell = $row.find('td.cost p');
    
    qnt = qnt + shift;
    
    if (qnt > 0) {
        $qntCell.html(qnt);
        $costCell.html(price * qnt);
        
        updateCart();
    }
    return false;
}

function updateCart(){
    var totalQnt = 0; var totalSum = 0;
    $('#cart').find('td.quantity').each(function(){
        var $qntCell = $(this).find('p')
        var $priceCell = $(this).parent().find('td.price p');
        var qnt = parseInt($qntCell.html());
        var price = parseInt($priceCell.html());
        totalQnt += qnt;
        totalSum += qnt * price;
    });
    
    var $totalRow = $('#cart').find('tr:last');
    var $totalSumCell = $totalRow.find('td.cost b');
    $totalSumCell.html(totalSum + ' p.');
}



$('body').on('click',".btn-danger",function(){

    return confirm("Are you sure you want to refuse this booking request ?");

});

$('body').on('click',".btn-primary",function(){

    return confirm("Are you sure you want to accept this booking request ?");

});

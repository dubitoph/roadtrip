$('body').on('click',".btn-danger",function(){

    if($(this).hasClass('deleteRating'))
    {

        return confirm("Are you sure you want to delete this rating? ?");

    }
    else
    {

        return confirm("Are you sure you want to delete this response? ?");

    }

});

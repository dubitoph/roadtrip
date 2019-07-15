jQuery( document ).ready( function( $ ) {

    $('.threadDiv').on('click', function(e) {

        var threadId = $(this).attr('id');        
        var id = threadId.substr(threadId.indexOf("_") + 1);
        
        $('#mailsDiv_' +  id).toggle();

    });

    (function($) {

        $.each(['show', 'hide'], function(i, ev) {

            var el = $.fn[ev];

            $.fn[ev] = function() {

                this.trigger(ev);
                return el.apply(this, arguments);
            };

        });

    })(jQuery);
    
    //
    $('.mailDiv').on('show', function() {
        
        var threadId = $(this).attr('id');        
        var id = threadId.substr(threadId.indexOf("_") + 1);
        
        if ($('#notReadDiv_' + id).data('notread') != '0') 
        {          

            $.ajax(
        
            {
        
                url: $('#ajaxUrlDiv').data('url'),
                method: 'POST',
                data: {
                        'threadId': id   
                    },
                dataType: 'json',                 
                success: function(response) 
                        {  
        
                        console.log(response);
                        $('#notReadDiv_' + id).data('url', '0');
                        $('#notReadSpan_' + id).html('0 not read)</span>');
                        
                        },  
                error : function(response) 
                        {  
        
                        console.log('Error from Ajax call');
                        
                        }, 
        
            });
          
        }

    });
    
    $('.mailDiv').on('hide', function() {

        console.log($(this).attr('id') + ' is hidden');

    });

});
import { deletePhoto } from '../app';

jQuery(document).ready(function() {

    //Adding a photo
    $('#add_photo_link').on('click', function(e) {

        e.preventDefault();
        addPhotoForm();

    });

    
    //Removing a photo
    $('body').on('click', '.btn-danger', function(e) {

        e.preventDefault();
        deletePhoto($(this));
    
    });

    //Prevent multiple photos from being checked as the main photo
    $('body').on('click', 'input[type="checkbox"]', function()
    {
    
        if ($(this).is(':checked')) 
        {
    
            $('input[type="checkbox"]').not($(this)).prop('checked',false);
                
        }
        
    }); 

    //Showing uploaded photos
    $([document]).on( 'change', 'input[type="file"]', function() {

        showPhoto($(this));
        
    }); 

});

function addPhotoForm() 
{
    // Get the ul that holds the collection of photos
    var $collectionHolderPhotos = $('ul.photos');

    // Count the current form inputs we have (e.g. 2), use that as the new
    // Index when inserting a new item (e.g. 2)
    $collectionHolderPhotos.data('index' , $collectionHolderPhotos.find(':input').length);
    
    // Get the data-prototype
    var prototype = $collectionHolderPhotos.data('prototype');

    // Get the new index
    var index = $collectionHolderPhotos.data('index');

    var newForm = prototype ;
    // You need this only if you didn't set 'label' => false in your photos field in AdvertType
    // Replace '__name__label__' in the prototype's HTML to
    // instead be a number based on how many items we have
    // newForm = newForm.replace(/__name__label__/g, index);

    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    newForm = newForm.replace(/__name__/g , index);

    // increase the index with one for the next item
    $collectionHolderPhotos.data('index', index + 1);

    var idLi = "li_photo_" + (index - 1);

    // Displaying the form in an li, after the lastest li
    var $newFormLi = $("<li id='" + idLi + "'></li>");

    $newFormLi.append(newForm);
    $newFormLi.append('<a href="#" class="btn btn-danger btn-dynamically-created">Remove this photo</a>');
    $collectionHolderPhotos.append($newFormLi);
    
    //Assigning main photo on the first photo
    if(index == 0) 
    {
    
        $('#photos_advert_photos_0_mainPhoto').prop('checked', true);

    }

} 

function showPhoto($element) 
{

    //If they are many changes about the photo choice, previous canvas removing
    var $canvas = $element.siblings('canvas');
    
    if ($canvas.length) 
    {

        $canvas.remove();

    }

    //Showing uploaded photos
    var file = $element;
    var reader = new FileReader;

    reader.onload = function(event) {

        var img = new Image();

        img.onload = function() {

            var ratio = img.width / img.height;
            var width = 100;
            var height = Math.round(width / ratio);
            var $canvas = $('<canvas></canvas>').attr({ width: width, height: height });

            file.after($canvas);

            var context = $canvas[0].getContext('2d');

            context.drawImage(img, 0, 0, width, height);

        };

        img.src = event.target.result;
    };

    reader.readAsDataURL(file[0].files[0]);

}
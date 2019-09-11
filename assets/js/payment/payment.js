var stripeResponse = document.getElementById('stripe-response');          
var stripe = Stripe(document.getElementById('stripe_public_key').value);
var elements = stripe.elements();

// Custom styling can be passed to options when creating an Element.
var style = {
                base: {
                        // Add the base input styles here.
                        fontSize: '16px',
                        color: "#32325d",
                      }
            }
;

// Create an instance of the card Element.
var cardElements = elements.create('card', {style: style});

// Add an instance of the card Element into the `card-element` <div>.
cardElements.mount('#card-element');

cardElements.addEventListener('change', function(event) 
{
  var displayError = document.getElementById('card-errors');

  if (event.error) 
  {

    displayError.textContent = event.error.message;

  } 
  else 
  {

    displayError.textContent = '';

  }

});

// Create a token or display an error when the form is submitted.
var form = document.getElementById('payment-form');

form.addEventListener('submit', function(event) 
{
  event.preventDefault();

  stripe.createToken(cardElements).then(function(result) 
  {

    if (result.error) 
    {

      // Inform the customer that there was an error.
      var errorElement = document.getElementById('card-errors');

      errorElement.textContent = result.error.message;

    } 
    else 
    {

      // Send the token to your server.
      stripeTokenHandler(result.token);

    }

  });

});

function stripeTokenHandler(token) 
{

  // Insert the token ID into the form so it gets submitted to the server
  var form = document.getElementById('payment-form');
  var hiddenInput = document.createElement('input');

  hiddenInput.setAttribute('type', 'hidden');
  hiddenInput.setAttribute('name', 'stripeToken');
  hiddenInput.setAttribute('value', token.id);
  form.appendChild(hiddenInput);

  // Submit the form
  form.submit();

}
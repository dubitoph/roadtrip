var requiredAction = document.getElementById('stripe_required_action').value;
var stripe = Stripe(document.getElementById('stripe_public_key').value);
var stripeResponse = document.getElementById('stripe-response'); 

// New payment action
if (requiredAction == 0) 
{
         
  var elements = stripe.elements();
  var cardButton = document.getElementById('card-button');
  var cardholderName = document.getElementById('holder-name');
  var form = document.getElementById('payment-form');
  var paymentMethod = document.getElementById('stripe_payment_method');

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

    if (event.error) 
    {

      stripeResponse.textContent = event.error.message;

    } 
    else 
    {

      stripeResponse.textContent = '';

    }

  });

  cardButton.addEventListener('click', function(ev) 
  {

    ev.preventDefault();

    cardButton.disabled = true;
    
    stripe.createPaymentMethod('card', cardElements, {

        billing_details: {

                            name: cardholderName.value,

                        },

    }).then(function(result) {
      
      if (result.error) 
      {

        // Inform the customer that there was an error.
        var errorElement = document.getElementById('card-errors');

        errorElement.textContent = result.error.message;
        cardButton.disabled = false;

      } 
      else 
      {

        paymentMethod.value = result.paymentMethod.id;
        form.submit();

      }

    });
    
  });
}
// Additional action required
else
{

  var paymentIntentId = document.getElementById('stripe_client_secret').value;

  cardButton.disabled = true;
  
  stripe.handleCardPayment(paymentIntentId).then(function(result) {

    if (result.error) 
    {

      stripeResponse.textContent = result.error.message;

    } 
    else 
    {

      stripeResponse.textContent = 'The payment has succeeded.';

      var redirectUrl = document.getElementById('redirection_path').value;

      window.location.replace(redirectUrl);

    }

  });

}
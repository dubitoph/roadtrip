var stripeResponse = document.getElementById('stripe-response');          
var stripe = Stripe(document.getElementById('stripe_public_key').value);
var elements = stripe.elements();

// Custom styling can be passed to options when creating an Element.
var style = {
                base: {
                        // Add your base input styles here. For example:
                        fontSize: '16px',
                        color: "#32325d",
                      }
            }
;

// Create an instance of the card Element.
var cardElements = elements.create('card', {style: style});

// Add an instance of the card Element into the `card-element` <div>.
cardElements.mount('#card-element');

var cardholderName = document.getElementById('holder-name');
var cardholderEmail = document.getElementById('holder-email');
var cardButton = document.getElementById('card-button');
var clientSecret = cardButton.dataset.client;

cardButton.addEventListener('click', function(ev) {
            
    // Disable button so user can't reclick
    cardButton.disabled = true;

    stripe.handleCardPayment(
        clientSecret, cardElements, {
                                        payment_method_data: {

                                                                billing_details: { 
                                                                                    name: cardholderName.value,
                                                                                    email: cardholderEmail.value
                                                                                            
                                                                                 }

                                                             }
                                    }
                            ).then(function(result) {
                                                        if (result.error) 
                                                        {

                                                            stripeResponse.textContent = result.error.message;
                                                            // Re-enable button
                                                            cardButton.disabled = true;
                                                            console.log(result.error);

                                                        } 
                                                        else 
                                                        {

                                                            // The payment has succeeded. Display a success message.
                                                            stripeResponse.textContent = "Paiement effectué avec succès!";
                                                            console.log(result);

                                                        }
                                                    }
                                  )
    ;

});
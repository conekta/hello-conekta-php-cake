<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript" src="https://conektaapi.s3.amazonaws.com/v0.3.0/js/conekta.js"></script>
<script type="text/javascript">
  // Conekta Public Key
  Conekta.setPublishableKey('1tv5yJp3xnVZ7eK67m4h');
  // ...
  var conektaSuccessResponseHandler = function(response) {
	var $form = $('#card-form');

    var token_id = response.id;
    // Inserta el token_id dentro del formulario para que sea enviado al servidor
    $form.append($('<input type="hidden" name="conektaTokenId" />').val(token_id));
    // y manda el formulario a tu servidor
    $form.get(0).submit();
  };
  var conektaErrorResponseHandler = function(response) {
		var $form = $('#card-form');
		// Show the errors on the form
		$form.find('.card-errors').text(response.message);
		$form.find('button').prop('disabled', false);
  };
  
  jQuery(function($) {
	  $('#card-form').submit(function(event) {
		var $form = $(this);

		// Inhabilita el botón submit para prevenir múltiples clics
		$form.find('button').prop('disabled', true);

		Conekta.token.create($form, conektaSuccessResponseHandler, conektaErrorResponseHandler);

		// Prevenir que la información del formulario sea mandado a tu servidor
		return false;
	  });
  });
</script>
<form action="process_payment" method="POST" id="card-form"> 
  <span class="card-errors"></span>
  <input type="hidden" name="isSubscription" value="<?php echo $_POST['is_subscription'] ?>"/>
  <input type="hidden" name="planId" value="<?php echo $_POST['plan_id'] ?>"/>
  <div class="form-row">
    <label>
      <span>Product price</span>
      <input type="text" size="20" name="productPrice" value="<?php echo $_POST['price'] ?>"/>
    </label>
  </div>
  <div class="form-row">
    <label>
      <span>Product Description</span>
      <input type="text" size="20" name="productDescription" value="<?php echo $_POST['description'] ?>"/>
    </label>
  </div>
  <div class="form-row">
    <label>
      <span>Cardholder name</span>
      <input type="text" size="20" data-conekta="card[name]" value="Mauricio Murga"/>
    </label>
  </div>
  <div class="form-row">
    <label>
      <span>CC number</span>
      <input type="text" size="20" data-conekta="card[number]" value="4242424242424242"/>
    </label>
  </div>
  <div class="form-row">
    <label>
      <span>CVC</span>
	  <input type="text" size="4" data-conekta="card[cvc]" value="123"/>
    </label>
  </div>
  <div class="form-row">
    <label>
      <span>Expiry Date (MM/AAAA)</span>
      <input type="text" size="2" data-conekta="card[exp_month]" value="12"/>
    </label>
    <span>/</span>
    <input type="text" size="4" data-conekta="card[exp_year]" value="2016"/>
  </div>
  <button type="submit">Submit Order</button>
</form>

<?php echo $this->Html->link(
    'Back',
    array('controller' => 'products', 'action' => 'index')
); ?>

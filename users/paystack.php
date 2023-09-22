<!--<form id="paymentForm">
  <div class="form-group">
    <label for="email">Email Address</label>
    <input type="email" id="email-address" required />
  </div>
  <div class="form-group">
    <label for="amount">Amount</label>
    <input type="tel" id="amount" required />
  </div>
  <div class="form-group">
    <label for="first-name">First Name</label>
    <input type="text" id="first-name" />
  </div>
  <div class="form-group">
    <label for="last-name">Last Name</label>
    <input type="text" id="last-name" />
  </div>
  <div class="form-submit">
    <button type="submit" onclick="payWithPaystack()"> Pay </button>
  </div>
</form>
<script src="https://js.paystack.co/v1/inline.js"></script>
<script>
							  function payWithPaystack(e) {
								  e.preventDefault();
								  let handler = PaystackPop.setup({
									key: 'sk_test_e31b342c71a1f7993759e29ba115519c05866968', // Replace with your public key
									email: document.getElementById("email-address").value,
									amount: document.getElementById("amount").value * 100,
									//firstname: document.getElementById("first-name").value,
									//lastname: document.getElementById("first-name").value,
									ref: ''+Math.floor((Math.random() * 1000000000) + 1), // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
									// label: "Optional string that replaces customer email"
									onClose: function(){
									  alert('Window closed.');
									},
									callback: function(response){
									  let message = 'Payment complete! Reference: ' + response.reference;
									  alert(message);
									}
								  });
								  handler.openIframe();
								}
							</script>-->
<form>
  <script src="https://js.paystack.co/v1/inline.js"></script>
  <button type="button" onclick="payWithPaystack()"> Pay </button> 
</form>

<script>
  function payWithPaystack(){
    var handler = PaystackPop.setup({
      key: 'pk_live_18871cca91b9d3051c849daa0f9a5e079c8bca21',
      email: 'customer@email.com',
      amount: 10000,
      ref: ''+Math.floor((Math.random() * 1000000000) + 1), // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
      metadata: {
         custom_fields: [
            {
                display_name: "Mobile Number",
                variable_name: "mobile_number",
                value: "+2348012345678"
            }
         ]
      },
      callback: function(response){
          alert('success. transaction ref is ' + response.reference);
      },
      onClose: function(){
          alert('window closed');
      }
    });
    handler.openIframe();
  }
</script>

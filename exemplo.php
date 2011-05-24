<html>
	<head>
		<title>Code Sample PayPal Brasil: Express Checkout</title>
		<style type="text/css">
			#ec-button {
				cursor: pointer;
				margin-right: 7px;
			}
		</style>
	</head>
	<body>
		<form id="checkout" action="checkout.php" method="post">
			<span>Total</span><span>R$ 100.00</span><br />
			<img id="ec-button" src="https://www.paypal.com/pt_BR/i/btn/btn_xpressCheckout.gif" onclick="checkout.submit();" />
		</form>
	</body>
</html>
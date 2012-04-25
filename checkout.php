<?php
$total = 100.00; //Total do carrinho do cliente

$nvp = array(
	'PAYMENTREQUEST_0_AMT'				=> $total,
	'PAYMENTREQUEST_0_CURRENCYCODE'		 => 'BRL',
	'PAYMENTREQUEST_0_PAYMENTACTION'	 => 'Sale',
	'RETURNURL'							=> 'http://127.0.0.1/paypal/retorno.php',
	'CANCELURL'							=> 'http://127.0.0.1/paypal/cancelamento.php',
	'METHOD'							=> 'SetExpressCheckout',
	'VERSION'							=> '84',
	'PWD'								=> 'xxxx',
	'USER'								=> 'vendedor@dominio.com',
	'SIGNATURE'							=> 'ASSINATURA'
);

$curl = curl_init();

curl_setopt( $curl , CURLOPT_URL , 'https://api-3t.sandbox.paypal.com/nvp' );
curl_setopt( $curl , CURLOPT_SSL_VERIFYPEER , false );
curl_setopt( $curl , CURLOPT_RETURNTRANSFER , 1 );
curl_setopt( $curl , CURLOPT_POST , 1 );
curl_setopt( $curl , CURLOPT_POSTFIELDS , http_build_query( $nvp ) );

$response = urldecode( curl_exec( $curl ) );

curl_close( $curl );

$responseNvp = array();

if ( preg_match_all( '/(?<name>[^\=]+)\=(?<value>[^&]+)&?/' , $response , $matches ) ) {
	foreach ( $matches[ 'name' ] as $offset => $name ) {
		$responseNvp[ $name ] = $matches[ 'value' ][ $offset ];
	}
}

if ( isset( $responseNvp[ 'ACK' ] ) && $responseNvp[ 'ACK' ] == 'Success' ) {
	$paypalURL = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
	$query = array(
		'cmd'	=> '_express-checkout',
		'token'	=> $responseNvp[ 'TOKEN' ]
	);

	header( 'Location: ' . $paypalURL . '?' . http_build_query( $query ) );
} else {
	echo 'Falha na transação';
}
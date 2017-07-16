<?php
try {

		$params = array(
			'api_key'	  => '64bad7313d2b7a36e7c51623370707e4',// Flickr API Key
			'method'	  => 'flickr.photosets.getPhotos',// Flickr Get Photo API
			'photoset_id' => '72157683560890963',// PhotoSet Id
			'extras'	  => 'original_format',
			'format'	  => 'php_serial'
		);

		$arrmixEncodedParams = array();

		foreach( $params as $strKey => $strValue ) { 
			$arrmixEncodedParams[] = urlencode( $strKey ) . '=' . urlencode( $strValue ); 
		}	

		$timeout = 5;

		$resource = curl_init();
		curl_setopt( $resource, CURLOPT_URL, 'https://api.flickr.com/services/rest/?' . implode( '&', $arrmixEncodedParams ) );
		curl_setopt( $resource, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $resource, CURLOPT_CONNECTTIMEOUT, $timeout );
		curl_setopt( $resource, CURLOPT_SSL_VERIFYPEER, FALSE );
		$arrmixData = curl_exec( $resource );
		curl_close( $resource );

		$arrmixContents = unserialize( $arrmixData );
		
		echo '<pre>';
		var_dump( $arrmixContents );
	 
		//$arrmixImageData = $arrmixContents['photoset']['photo'][0]; 
		//$strImageUrl = 'farm' . $arrmixImageData['farm'] . '.static.flickr.com--' . $arrmixImageData['server'] . '--' . $arrmixImageData['id'] . '_' . $arrmixImageData['secret'];

} catch( Exception $objException ) {
	print_r( $objException->getMessage() );	
}
?>
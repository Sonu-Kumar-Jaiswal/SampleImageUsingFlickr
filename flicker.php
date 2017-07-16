<?php
try {

		$params = array(
			'api_key'	  => '64bad7313d2b7a36e7c51623370707e4',// Flickr API Key
			'method'	  => 'flickr.photos.search',// Flickr Get Recent Photo API
			'photoset_id' => '72157683560890963',// PhotoSet Id
			'user_id'	  => '150988295@N08',
			'extras'	  => 'date_upload',
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
		
		if( false == is_array( $arrmixContents ) ) {
			echo 'No Image Found on Flickr, Please upload any to check this functionlaity.';
			return ;
		}
		
		$arrmixRecentImageData = [];
		
		foreach( $arrmixContents['photos']['photo'] as $arrmixContent ) {
			$strUploadedDate = date( 'Y-m-d h:i:s', $arrmixContent['dateupload'] );

			if( true == is_array( $arrmixRecentImageData ) ) {
				$strDate = key( $arrmixRecentImageData );
				
				if( $strUploadedDate > $strDate ) {
					unset( $arrmixRecentImageData );
					$arrmixRecentImageData[$strUploadedDate] = $arrmixContent;
				}				
			} else {
				$arrmixRecentImageData[$strUploadedDate] = $arrmixContent;
			}	
		}
	 
		$arrmixImageData = current( $arrmixRecentImageData ); 
		$strImageUrl = 'farm' . $arrmixImageData['farm'] . '.static.flickr.com--' . $arrmixImageData['server'] . '--' . $arrmixImageData['id'] . '_' . $arrmixImageData['secret'];

} catch( Exception $objException ) {
	print_r( $objException->getMessage() );	
}
?>

<!DOCTYPE html>
<html lang="en-US">
	<head>
		<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.6/angular.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.6/angular-route.js"></script>
		<script src="app.js"></script>
		<title>Flickr Image</title>
	</head>

	<body >
		<div><p>Click on below Image Link to see the preview</p></div>
		<div ng-app = "flickrApp" class = "container">
			<li><a href = "#MediumView/<?php echo $strImageUrl; ?>"> Medium(Default) View</a></li>
			<li><a href = "#ThumbnailView/<?php echo $strImageUrl; ?>"> Thumbnail View</a></li>
			<li><a href = "#SmallView/<?php echo $strImageUrl; ?>"> Small View</a></li>			

			<div ng-view></div>
		</div>
	</body>
</html>
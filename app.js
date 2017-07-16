( function() {
   'use strict';
		var flickrApp = angular.module( 'flickrApp', [ 'ngRoute' ] );

		flickrApp.config( [ '$routeProvider', function( $routeProvider ) {
			$routeProvider
				.when( '/MediumView/:src', { 
					templateUrl: 'default-view.html',
					controller: 'DefaultController'
				})
				.when( '/ThumbnailView/:src', { 
					templateUrl: 'thumbnail-view.html',
					controller: 'ThumbnailViewController'
				})
			    .when( '/SmallView/:src', { 
					templateUrl: 'small-view.html',
					controller: 'SmallViewController'
				})
			    .otherwise({
					redirectTo: '/MediumView/:src'
				});
		}]);

		flickrApp.controller( 'DefaultController', function( $scope, $routeParams ) {
			$scope.urlPrepend = 'http://';
			$scope.urlAppend  = '_m.jpg'; 
			$scope.message    = $scope.urlPrepend + $routeParams.src.replace( /--/g, '/' )+ $scope.urlAppend;
		});
		
		flickrApp.controller( 'ThumbnailViewController', function( $scope, $routeParams ) {
			$scope.urlPrepend = 'http://';
			$scope.urlAppend  = '_t.jpg'; 
			$scope.message    = $scope.urlPrepend + $routeParams.src.replace( /--/g, '/' ) + $scope.urlAppend;
		});

		flickrApp.controller( 'SmallViewController', function( $scope, $routeParams ) {
			$scope.urlPrepend = 'http://';
			$scope.urlAppend  = '_s.jpg'; 
			$scope.message    = $scope.urlPrepend + $routeParams.src.replace( /--/g, '/' ) + $scope.urlAppend;
		});	  
})();
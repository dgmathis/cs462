<?php

class V1 extends API {
	
	public function store_last_checkin() {
		
		$_POST['checkin'] = '{"id":"513f4813e4b038e8d0c334a7","createdAt":1363101715,"type":"checkin","timeZone":"America\\/Denver","timeZoneOffset":-360,"user":{"id":"33717155","firstName":"David","lastName":"Mathis","gender":"male","relationship":"self","photo":"https:\\/\\/is1.4sqi.net\\/userpix_thumbs\\/3IOBPHJWYELQJUYR.jpg","tips":{"count":0},"lists":{"groups":[{"type":"created","count":1,"items":[]}]},"homeCity":"Provo, UT","bio":"","contact":{"email":"dmathis@sfcn.org","facebook":"1791901495"}},"venue":{"id":"4f910ad0e4b06552021eb3fa","name":"BYU - MARB","contact":{},"location":{"lat":40.246856432441376,"lng":-111.64892267835995,"postalCode":"84606","city":"Provo","state":"UT","country":"United States","cc":"US"},"canonicalUrl":"https:\\/\\/foursquare.com\\/v\\/byu--marb\\/4f910ad0e4b06552021eb3fa","categories":[{"id":"4bf58dd8d48988d198941735","name":"College Academic Building","pluralName":"College Academic Buildings","shortName":"Academic Building","icon":"https:\\/\\/foursquare.com\\/img\\/categories\\/education\\/default.png","parents":["College & University"],"primary":true}],"verified":false,"stats":{"checkinsCount":29,"usersCount":9,"tipCount":1},"likes":{"count":0,"groups":[]},"beenHere":{"count":0}}}';
		
		$checkin = json_decode($_POST['checkin'], true);

		$results['code'] = 1;
		$results['message'] = 'Success';
		
		$lat = $checkin['venue']['location']['lat'];
		$lng = $checkin['venue']['location']['lng'];
		
		$results['lat'] = $lat;
		$results['lng'] = $lng;
		
		$settingsModel = $this->getModel('Settings');
		
		$settingsModel->setValue('last_checkin_lat', $lat);
		$settingsModel->setValue('last_checkin_lng', $lng);
		
		print(json_encode($results));
		die();
	}
	
	
}

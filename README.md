# UbiComProject Server #

This is the backend for the [UbiComProject](https://github.com/hurik/UbiComProject).

## Database
The database needs only one table with two fields. One for the number and one for the GoogleCloudMessaging registration ID. The number field is used as primary key.

	CREATE TABLE IF NOT EXISTS `users` (
	  `number` varchar(20) NOT NULL,
	  `gcm` text NOT NULL
	) ENGINE=MyISAM DEFAULT CHARSET=utf8;
	
	--
	-- Indexes for table `users`
	--
	ALTER TABLE `users`
	 ADD PRIMARY KEY (`number`);

## Files

### config.php
The database connection variables and the Google Api key is stored in this file.


### db_connect.php
A classfile to connect to the database.


### register.php
The RegisterActivity sends the users number and the obtained GoogleCloudMessaging registration ID to the server. The server stores both in the database "users".

#### Parameters
- `number`: The users phone number.
- `gcm`: The GoogleCloudMessaging registration ID. 

Example call: `register.php?number=%2B49XXXXXXXXXXX&gcm=XXXXX-183-chars-long-XXXXXX`

#### Responses 
Responeses Are given in JSON.

##### Sucess
	
- Successfully registered: `{"success":1,"message":"User successfully created or updated."}`

##### Errors
- Database error: `{"success":0,"message":"Database error!"}`
- Mising parameters: `{"success":0,"message":"Required field(s) is missing!"}`


### known_numbers.php
The AllowedNumbersActivity send every number from the Phonebook to the server. The server checks if he knows the number and returns the known numbers as JSON.

#### Parameters
- `numbers`: Numbers seperated with a semicolon.

Example call: `known_numbers.php?numbers=%2B49XXXXXXXXXXX;%2B48XXXXXXXXXXX;`

#### Responses 
Responeses Are given in JSON.

##### Sucess
	
- Successfully checked for known numbers: `{"knownNumbers":[{"number":+49XXXXXXXXXXX"}],"success":1}`

##### Errors
- Database error: `{"success":0,"message":"Database error!"}`
- Mising parameters: `{"success":0,"message":"Required field(s) is missing!"}`


### update_position.php
The LocationService send every two minutes, the new location of the user.

#### Parameters
- `message`: The user number, latitude and logitude seperated with a semicolon.
- `allowed`: The numbers of people, which are allowed to receive the position, also seperated with a semicolon.

Example call: `update_position.php?message=%2B49XXXXXXXXXXX;47.682176;9.158252&allowed=%2B49XXXXXXXXXXX;%2B48XXXXXXXXXXX;`

#### Responses 
Responeses Are given in JSON.

##### Sucess
- Successfully send to the GoogleCloudMessaging service (Response JSON is from the GeoogleCloudMessaging service): `{"multicast_id":XXXXXXXXXXXXXXXXXXX,"success":1,"failure":0,"canonical_ids":0,"results":[{"message_id":"XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX"}]}`

##### Errors
- No allowed numbers: `{"success":0,"message":"No allowed number!"}`
- Database error: `{"success":0,"message":"Database error!"}`
- Mising parameters: `{"success":0,"message":"Required field(s) is missing!"}`


### gcm.php
This classfile has only a static funtion, which send the updated position to the GoogleCloudMessaging service, so that it can push the information to the allowed users.


## Resources ##
- ["How to connect Android with PHP, MySQL" by Ravi Tamada](http://www.androidhive.info/2012/05/how-to-connect-android-with-php-mysql/)
- ["Android Push Notifications using Google Cloud Messaging (GCM), PHP and MySQL" by Ravi Tamada (**ATTENTION: Using an older Google Cloud Messaging API Version! Only the server part is working.**)](http://www.androidhive.info/2012/10/android-push-notifications-using-google-cloud-messaging-gcm-php-and-mysql/)
- ["Google Cloud Messaging GCM for Android and Push Notifications" by Joe](http://javapapers.com/android/google-cloud-messaging-gcm-for-android-and-push-notifications/)
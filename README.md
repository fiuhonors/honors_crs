## Honors CRS

Archive of the old version of the Honors CRS developed with the CakePHP Framework. We will slowly stop working on this 
project and port it over to Laravel Framework.

### To do before production
Make sure to turn off debugging (0 instead of 1 or 2) in the Config file before uploading to the server.

### Hashing passwords (Creating new administrators)

In case we have a new user that we need to add to CRS that is not a student - an administrator, we have to manually put
their login credentials to the database. Username typically is the person's Panther ID and their password must be
hashed or else the authentication would not work. Hash is done by:

	$passwordHasher = new SimplePasswordHasher(array('hashType' => 'sha256'));
	var_dump($passwordHasher->hash("userspassword") . " is the hashed password");
	
Where userspassword is the password that we want the user to have. You can put this in Administrators Controller, on
admin_login() method, which is the method that handles user login so that when we hit honors.fiu.edu/CRS/application/admin,
we can see the hashed string of password on the page.
# FoodShare

FoodShare is a simple web application that allows individuals to add listings of surplus food and other users will be able to see these listings and can contact them via *Instant Chat Feature* . Users can sign up to generate listings.
This project uses PHP, Javascript, HTML, CSS, AJAX requests, Google Maps API and Google reCaptcha API.

## Features 

* App with secure login and sign up options.
* Sign up process with real time indication of usernames availability and a Captcha.
* Users can add type, title, description, image, approximate address(text/Google Maps), pickup time of the listings.
* Users can add a listing to their My Listings page, and can edit, unlist, delete the listings listed by them.
* Users can refine listing results by listing type, distance and more.
* A user’s profile page have the following - Add Listing, My listings, Unlisted listings, User following and followers data.
* A search bar is provided in the home page where the user can search for other users.
* Messaging Feature. Users can message/chat with people who they are following or who are following them.
* Asynchronous Instant Chatting feature. Users can chat with other users instantly (where the user on the other end can receive the messages without refreshing the page).
* Users can view the profile page and recent listings of other users.
* Users can change their email and password.
* Users can delete their account and all the information associated with their account.

----

**Framework used : PHP on Apache**  
**Database 	 : MySQL**  
**Server	 : Apache** 

----

**Connections to database**
* Enter your username and password of mySQL database in connect.php
```html
define ('DB_USER','Your-Username');
```
```html
define ('DB_PASSWORD','Your-Password');
```
```html
define ('DB_NAME','FoodShare');
```
replace the string "Your-Username" and "Your-Password" with your own username and password of mySQL database.

----

**Captcha System**

* The signup/register page uses Google reCaptcha to prevent bot users.
* Go to [this link](https://www.google.com/recaptcha/intro/index.html). Click on *get reCaptcha* button in top right corner.
* Sign in through your Gmail account.(If you are already signed up, then ignore this step).
* In the *Register a new site* box, type in a label(say localhost) and your domain name(say localhost). 
* Click on *Register*.
* You will get two keys, a public key and a private key.
* Copy the private key. Create config.php, in that add the variable privateKey 
```html
$privateKey = "Your-private-key";
```
replace the string "Your-private-key" with your own secret/private key.
* Copy the public key. Open register.php. You will see a line 
```html
<div class="g-recaptcha" data-sitekey="Your-public-key"></div>
```
Paste this public key in the 'data-sitekey' attribute,replacing "Your-public-key".

----

#### How to run :

* Clone/download this repository.
* Copy the folder FoodShare to your localhost directory.
* Start your XAMPP/WAMP or any apache distribution software.
* Start your apache server and mySQL modules.
* Open up your browser. Type http://localhost/FoodShare/ as the URL.
* Click on *welcome.html*

----

## Built With

* [PHP](http://php.net/)
* [Vanilla JS](http://vanilla-js.com/)
* [AJAX](https://developer.mozilla.org/en-US/docs/Web/Guide/AJAX)
* [HTML](https://www.w3.org/html/)
* [CSS](https://www.w3.org/Style/CSS/)
* [Google Maps API](https://cloud.google.com/maps-platform/)
* [reCaptcha API](https://www.google.com/recaptcha/)

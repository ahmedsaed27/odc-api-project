## Hackathon Project

### We want an app that promotes local businesses as well as tourism in each Egyptian Governorate,including reels on locals’ opinions about cafes, restaurants, and other establishment.

## Requirements:

### 1- Basic and JWT Authentication.
### 2- Social Authentication with facebook and google and twitter tokens.
### 3- Database oriented project (feel free to use any type of database).
### 4- REST API
### 5- A secure way to store and display the reels.


## How to use 

### go to config/services.php and set your client_id , client_secret 
### if you dont have you should create one to login with google // here your link to create project
    https://console.cloud.google.com
   
### get your Access token by This link
    https://developers.google.com/oauthplayground
   
### run seeder 'php artisan db:seed' or go to this Uri
    http://127.0.0.1:8000/seed
   
### now you have couple of users 
 user number one -> email => user@gmail.com  , password => password , role => User
 user number two -> email => admin@gmail.com , password => password , role => Admin
### you can login with google by Access token


## Post man docs

### https://documenter.getpostman.com/view/22323709/2s8YYBQRJX







# SM64romhacks

sm64romhacks.com is meant to be a community website for SM64 ROM Hacks. It is written in PHP8.2 and powered by Laravel 11.

Requirements:
- Meeting Laravel 11's Minimum Server Requirements as shown [here](https://laravel.com/docs/11.x/deployment#server-requirements)
- A Webserver whose document root points to /public
- A Database Server (i.e. MySQL)
- A Twitch Client ID and a Twitch Client Secret (for the streams page)
- A Discord Client ID and A Discord Client Secret (for the login)
- A Discord Webhook for the server you want your announcements to be posted in as well as the guild/channel ID (for automatic news posting)
- A Discord Bot Token (for discord events management)
- An SMTP-Server (for emails)

To get started, clone this project with ```git clone https://github.com/MarvJungs/sm64romhacks.git```. After it has cloned, install the javascript and php dependencies via npm and composer:
- ```npm install```
- ```composer install```

To get the required database structure you will need to run Laravels database migrations:
- ```php artisian migrate```
!!! The Migrations assume you have the old Database as a dumb available and imported it accordingly. It also needs the patchfiles to generate the version entries correctly. If you wish to contribute to this project and want to mess around locally, please send an email to info@sm64romhacks.com or send a DM to MarvJungs on Discord. !!!
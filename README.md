## sm64romhacks

sm64romhacks is a community driven website project which aims to provide an archive of patchfiles of modifications of the video game "Super Mario 64" with the end goal to provide some kind of "community hub" with all useful resources available at one spot. These patchfiles are stored as a .bps-fileformat. In order to provide additional files, such as README's, all files are being stored as a .zip-archive file.

### Features

- File Upload: To continously update our file database, files can be uploaded via an online form. Necessary data for the frontend are also being stored.
- Authentication & Authorization: By attaching roles to each registered user, permissions can be taken off very carefully. Standard users need their files to be verified while admins and moderators can upload their files without further verification.
- CRUD Operations: Create, Read, Update, Delete Operations on the different game modifications and its subversions as well as a backend management system to administrate various different data
- News & Events: A collection of community hosted events and newsposts regarding the community (currently unused) can be viewed.
- Tools: We also provide a collection of external hosted tools by different community members.

### Setup

#### Requirements
As per Laravel12 requirements, to run this project you will need a MySQL database, a PHP installation on version 8.2 or higher and NodeJS / npm to compile the JS and CSS assets

#### Steps
1. Clone this repo with ` git clone https://github.com/MarvJungs/sm64romhacks `
2. Import the world database located in ` /database/seeder/data/world.sql ` into your MySQL database.
3. Run  ` php artisan migrate ` to create the database
4. Run ` npm run build ` to compile the JavaScript and CSS assets. 

## Contributing

Thank you for considering contributing to our community driven website!
To contribute, fork this repo, make your changes and submit a Pull Request to be reviewed.

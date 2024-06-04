# CineVerse
Cineverse is a social network for movie, TV series, and entertainment enthusiasts. Share images, videos, polls, and your preferences.<br />
Discover new releases, join discussions, and connect with other fans in the world of entertainment.<br />
<br />

## Autori: 
- Bacchini Lorenzo (lorenzo.bacchini4@studio.unibo.it)
- Mattia Burreli (mattia.burreli@studio.unibo.it)

## Setup for local development:
In Xampp, find the <Directory> tag in the httpd.conf file and write the following lines for configure the local env variables:
```
    SetEnv [CV_SERVERNAME]
    SetEnv [CV_USERNAME]
    SetEnv [CV_PASSWORD]
    SetEnv [CV_DBNAME]
    SetEnv [MailApiKey]
    SetEnv [JWTKEY]
```
After that execute this command:
```
composer install
```
Now you can run your project. 

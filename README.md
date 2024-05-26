# CineVerse
Cineverse is a social network for movie, TV series, and entertainment enthusiasts.Share images, videos, polls, and your preferences.
Discover new releases, join discussions, and connect with other fans in the world of entertainment.
A full description of the project can be found in the "aggiungere".
The look and feel of the website is described in the "aggiungere mockup".
Lastly the color palette used in the website can be viewed in " aggiungere color palette".
## Autori: 
- Bacchini Lorenzo (lorenzo.bacchini4@studio.unibo.it)
- Mattia Burreli (mattia.burreli@studio.unibo.it)

## Test:
For the sake of testing the site a default user has been created with the following credentials:
```
email: test@test.it
password: test1234
```

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

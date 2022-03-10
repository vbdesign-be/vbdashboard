# Instalatie vbdashboard locaal

## stap1: database
    php artisan migrate
    php artisan db:seed

## stap2: teamleader connecteren
    surfen naar https://vbdashboard.test/connect
    Inloggen met de gegevens uit de lastpass.

## stap3: clickup connecteren
    surfen naar https://vbdashbard.test/connectClickup
    inloggen in clickup en workspace connecteren

## stap4: cronjob opzetten
    php artisan schedule:work
    1 a 2 keer laten runnen



# oc_bilemo
Projet 7 du parcour "Développeur d'application-php/symfony" d'OpenClassroom.

<h3>Installation</h3>

Retrieve the project by cloning the directory into your web folder.
Use the "composer install" command to install the project.
Change the "app / config / parameter.yml" file with the information in your database.

<h3>Utilization</h3>

To view resources, the user must register and use an access token:

        - Go to the URI "/users" and send the following information to JSON :
                {
                "name": "your name",
                "mail": "your mail",
                "password": "your password"
                }
        
        - A client will be created to retrieve your access token. Keep a client informations.
        - Go to the URI "/oauth/v2/token" to retrieve your access token by sending the following information as in the example:
                POST /oauth/v2/token HTTP/1.1
                Content-Type: application/x-www-form-urlencoded
                grant_type=password&username=yourmail&password=yourpassword&client_id=yourclientid&secret_client=yourclientsecret
        - Retrieve information from your access token create and keep them in a safe place.
        - Use the access token in the header to retrieve the requested resources as in the example:
                GET /phones HTTP/1.1
                Authorization: Bearer youraccesstoken
                Content-Type: application/json
                
For more information about the resources you can find on the URI "/api/doc".
                


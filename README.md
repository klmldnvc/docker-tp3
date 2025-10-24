TP Docker — Étapes 1, 2 et 3
Objectif du TP Mettre en place une architecture web complète :
* Nginx (serveur HTTP)
* PHP-FPM (exécution du code PHP)
* MariaDB (base de données SQL)
* Conteneurs Docker
* Orchestration via Docker Compose

Structure du projet :
docker-tp3/ etape1/ -> Nginx + PHP (phpinfo) etape2/ -> Nginx + PHP + MariaDB (test CRUD avec test.php) etape3/ -> Même architecture orchestrée avec Docker Compose

Étape 1 — Nginx + PHP-FPM
Commande réseau : docker network create tp3
Lancer PHP-FPM : docker run -d --name script --network tp3 -v $(pwd)/app:/app php:8.2-fpm
Lancer Nginx : docker run -d --name http --network tp3 -p 8080:80 -v $(pwd)/app:/app -v $(pwd)/config/default.conf:/etc/nginx/conf.d/default.conf nginx:latest
Test : ouvrir http://localhost:8080 

Résultat attendu : phpinfo()

Étape 2 — Ajout MariaDB + CRUD
Lancer MariaDB : docker run -d --name data --network tp3 -e MARIADB_RANDOM_ROOT_PASSWORD=yes -e MARIADB_DATABASE=testdb -e MARIADB_USER=app -e MARIADB_PASSWORD=app -v $(pwd)/sql:/docker-entrypoint-initdb.d:ro mariadb:latest
Construire image PHP avec mysqli : docker build -t php-mysqli .
Lancer PHP-FPM avec mysqli : docker run -d --name script --network tp3 -v $(pwd)/app:/app php-mysqli
Relancer Nginx : docker run -d --name http --network tp3 -p 8080:80 -v $(pwd)/app:/app:ro -v $(pwd)/config/default.conf:/etc/nginx/conf.d/default.conf:ro nginx:latest
Test : ouvrir http://localhost:8080/test.php

Résultat attendu : Compteur qui augmente à chaque refresh

Étape 3 — Docker Compose
Depuis le dossier etape3/ :
docker compose up -d --build
Test :

http://localhost:8081/ 

http://localhost:8081/test.php

Résultat attendu : Compteur fonctionne encore, mais lancé via Compose



Klara MLADENOVIC
PGE3 FR

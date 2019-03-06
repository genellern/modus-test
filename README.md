# NHTSA API Implementation

## Project Setup
- Install docker from

-  [![N|Solid](https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ-0MrYiAg8HM5BBELjugGdJL49RalukC84OPlOi8LaBU16MetEVlVtW6W1jpZJS_qlwZA)](https://www.docker.com/products/docker-desktop) 

- Copy `docker-compose.yml.default` to `docker-compose.yml`
- Run ````docker-compose up -d````
- Run ```` docker exec -it modus-php-fpm bash````
- Run ```` composer install````
- Open browser at [http://localhost:8080](http://localhost:8080)
- Set variables in web browser path like: [http://localhost:8080/vehicles/2018/Audi/A3](http://localhost:8080/vehicles/2018/Audi/A3)
- Make POST requests from the console by running: ```curl 'http://localhost:8080/vehicles' -H 'Accept: application/json'  -H 'Content-Type: application/json' --data-binary '{"modelYear":"2015","manufacturer":"Audi", "model": "A3"}' --compressed```
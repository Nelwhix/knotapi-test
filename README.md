# Setup
- start the docker container. php is on port 9000, nginx is on port 8088
you can change the defaults by editing `docker-compose.yaml`
```bash
    docker compose up -d 
```

- install dependencies with
```bash 
    docker compose run composer composer install 
```

- Generate app key with:
```bash 
    docker compose run php php artisan key:generate
```

- copy the `.env.example` with 
```bash 
    cp app/.env.example app/.env
    # then set your environment config
```

- migrate and seed database with:
```bash 
    docker compose run php php artisan migrate --seed 
```

- generate passport client with:
```bash
    docker compose run php php artisan passport:client --personal
```
then save your passport client id and secret in .env

- Docs is on `http://localhost:8088/api/v1/docs`

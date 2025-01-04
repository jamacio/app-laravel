# Laravel Boilerplate Project with AdminLTE

This project is a Laravel boilerplate that includes integration with AdminLTE, an admin panel based on Bootstrap. It provides a ready-to-use structure for developing web applications with a modern and responsive admin panel.

## TODO

Before starting, make sure you have the following requirements installed:

### Install Docker

```sh
sudo apt-get update
sudo apt-get install \
    ca-certificates \
    curl \
    gnupg \
    lsb-release

curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo gpg --dearmor -o /usr/share/keyrings/docker-archive-keyring.gpg

echo \
  "deb [arch=$(dpkg --print-architecture) signed-by=/usr/share/keyrings/docker-archive-keyring.gpg] https://download.docker.com/linux/ubuntu \
  $(lsb_release -cs) stable" | sudo tee /etc/apt/sources.list.d/docker.list > /dev/null

sudo apt-get update
sudo apt-get install docker-ce docker-ce-cli containerd.io
```

### Install Docker Compose

```sh
sudo curl -L "https://github.com/docker/compose/releases/download/1.29.2/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
sudo chmod +x /usr/local/bin/docker-compose
```

### Install Make

```sh
sudo apt-get update
sudo apt-get install make
```

## Step by Step

### 1. Create the .env File

```sh
cp .env.example .env
```

### 2. Bring up the project containers

```sh
make up
```

### 3. Access the container

```sh
make bash
```

### 4. Install project dependencies

```sh
composer install
```

### 5. Generate the Laravel project key

```sh
php artisan key:generate
```

### 6. Migrate the tables

```sh
php artisan migrate
```

### 7. Access the project

[http://localhost:8989](http://localhost:8989)

### Additional Commands

-   Stop the containers:

```sh
make stop
```

-   Take down the containers:

```sh
make down
```

-   Rebuild the containers:

```sh
make build
```

-   Watch the container logs:

```sh
make watch
```

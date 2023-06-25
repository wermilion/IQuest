FROM node:20.3.1-slim as nodejs
WORKDIR /app
COPY front ./
RUN npm install
RUN npm run build

FROM bitnami/nginx:1.25.1-debian-11-r2 as front
WORKDIR /app
COPY --from=nodejs /app/dist ./

FROM unit:php8.2 as back
RUN apt-get update && apt-get install -y git && rm -rf /var/lib/apt/lists/*
COPY --from=composer:2.5.8 /usr/bin/composer /usr/bin/composer
COPY .docker/unit-config.json /docker-entrypoint.d/
WORKDIR /app
COPY back /app/
RUN composer install
RUN chown -R unit:unit /app/

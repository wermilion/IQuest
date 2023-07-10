server {
    listen 8080;

    server_name $DOMAIN;

    return 301 https://$host$request_uri;
}

server {
    server_name  $DOMAIN;
    listen 4443 ssl;

    ssl_certificate /tmp/tls/$DOMAIN.pem;
    ssl_certificate_key /tmp/tls/$DOMAIN-key.pem;

    proxy_set_header Host $host;
    proxy_set_header X-Real-IP $remote_addr;
    proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
    proxy_set_header X-Forwarded-Proto $scheme;
    proxy_set_header X-Forwarded-Host $host:$server_port;

location / {
    proxy_pass http://${CI_PROJECT_NAME}-${CI_ENVIRONMENT_NAME}-front:8080;
    }

location /api {
    proxy_pass http://${CI_PROJECT_NAME}-${CI_ENVIRONMENT_NAME}-back:80;
    }

location /cp {
    proxy_pass http://${CI_PROJECT_NAME}-${CI_ENVIRONMENT_NAME}-back:80;
    }
}
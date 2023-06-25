server {
    listen 8080 default_server;

    server_name _;

    return 301 https://$host$request_uri;
}

server {
    server_name  _;
    listen 4443 ssl default_server;

    ssl_certificate /tmp/tls/crt.pem;
    ssl_certificate_key /tmp/tls/key.pem;

location / {
    proxy_pass http://${CI_PROJECT_NAME}-${CI_ENVIRONMENT_NAME}-front:8080;
    }

location /api/ {
    rewrite ^/api(/.*)$ $1 break;
    proxy_pass http://${CI_PROJECT_NAME}-${CI_ENVIRONMENT_NAME}-back:80;
    }
}
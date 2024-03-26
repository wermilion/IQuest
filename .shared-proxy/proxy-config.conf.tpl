server {
    listen 8080;

    server_name $DOMAIN;

    client_max_body_size 30M;
    proxy_set_header Host $host;
    proxy_set_header X-Real-IP $remote_addr;
    proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
    proxy_set_header X-Forwarded-Proto https;
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
    
location /livewire {
    proxy_pass http://${CI_PROJECT_NAME}-${CI_ENVIRONMENT_NAME}-back:80;
    }
location /storage {
    proxy_pass http://${CI_PROJECT_NAME}-${CI_ENVIRONMENT_NAME}-back:80;
    }
}
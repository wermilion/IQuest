version: "3"
services:
  front:
    image: ${CI_REGISTRY_IMAGE}/front:${CI_COMMIT_TAG}
    container_name: ${CI_PROJECT_NAME}-${CI_ENVIRONMENT_NAME}-front
    networks:
      - ${CI_PROJECT_NAME}-${CI_ENVIRONMENT_NAME}
  back:
    image: ${CI_REGISTRY_IMAGE}/back:${CI_COMMIT_TAG}
    container_name: ${CI_PROJECT_NAME}-${CI_ENVIRONMENT_NAME}-back
    networks:
      - ${CI_PROJECT_NAME}-${CI_ENVIRONMENT_NAME}
    env_file:
    - .env-back
  proxy:
    image: bitnami/nginx:1.25.1-debian-11-r2
    container_name: ${CI_PROJECT_NAME}-${CI_ENVIRONMENT_NAME}-proxy
    ports:
      - 80:8080
      - 443:4443
    volumes:
      - ./tls:/tmp/tls
      - ./proxy-config.conf:/opt/bitnami/nginx/conf/server_blocks/proxy-config.conf
    networks:
      - ${CI_PROJECT_NAME}-${CI_ENVIRONMENT_NAME}

networks:
  ${CI_PROJECT_NAME}-${CI_ENVIRONMENT_NAME}:
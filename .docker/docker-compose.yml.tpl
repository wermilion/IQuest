version: "3"
services:
  front:
    image: ${CI_REGISTRY_IMAGE}/front:${CI_COMMIT_TAG}
    container_name: ${CI_PROJECT_NAME}-${CI_ENVIRONMENT_NAME}-front
    networks:
      - server
  back:
    image: ${CI_REGISTRY_IMAGE}/back:${CI_COMMIT_TAG}
    container_name: ${CI_PROJECT_NAME}-${CI_ENVIRONMENT_NAME}-back
    env_file:
    - env-back
    networks:
      - server
networks:
  server:
    driver: bridge
    ipam:
      config:
        - subnet: 172.20.0.0/16

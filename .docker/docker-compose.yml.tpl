version: "3"
services:
  front:
    image: ${CI_REGISTRY_IMAGE}/front:${CI_COMMIT_TAG}
    container_name: ${CI_PROJECT_NAME}-${CI_ENVIRONMENT_NAME}-front
  networks:
    - server:
      aliases:
        - ${CI_PROJECT_NAME}-${CI_ENVIRONMENT_NAME}-front
  back:
    image: ${CI_REGISTRY_IMAGE}/back:${CI_COMMIT_TAG}
    container_name: ${CI_PROJECT_NAME}-${CI_ENVIRONMENT_NAME}-back
    env_file:
    - env-back
    networks:
      - server:
        aliases:
          - ${CI_PROJECT_NAME}-${CI_ENVIRONMENT_NAME}-back
networks:
  server:
    external: true

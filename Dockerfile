FROM php:8.2-cli-alpine3.18

RUN apk update ; apk add git

WORKDIR /data
COPY backup.php /app/backup.php

ENTRYPOINT ["php","/app/backup.php"]


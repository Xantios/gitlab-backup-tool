FROM php:8.2-cli-alpine3.18

RUN apk update ; apk add git

WORKDIR /app
COPY backup.php /app/backup.php

ENTRYPOINT ["php","/app/backup.php"]

# RUN for repo in $(curl -s --header "PRIVATE-TOKEN: $GITLAB_TOKEN" $GITLAB_HOST/api/v4/groups/sacredheart | jq -r ".projects[].ssh_url_to_repo"); do git clone $repo; done;

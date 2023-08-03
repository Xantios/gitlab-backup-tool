## Create gitlab token

Go to your profile in GitLab (Edit Profile) click on Access Tokens and create a token there with sufficient privileges. 

## Build container

docker build -t gitlab-backups .

## Run container
docker run \
-it \
-e GITLAB_TOKEN="YOUR_SUPER_SECRET_TOKEN_GOES_HERE" \
-e GITLAB_HOST="https://LookMa.imma.git.host.example.com" \
gitlab-backups

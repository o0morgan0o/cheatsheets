# (slug: push) Push

`git remote add origin https://<user>:<access-token>@gitlab.example.com/<user>/<repo>.git`

# (slug: runner) Run a ci job 

Run locally .gitlab-ci.yml
`gitlab-runner exec`
`gitlab-ci-local`

# (slug: job-shell) Basic shell job

`build-job:`
`  stage: build`
`  tags:`
`    # need a runner with this tag`
`    - shell-runner`
`  variables:`

`  before_script:`
`    - echo "Logging to GitLab Container Registry with CI credentials..."`
`    - echo "$CI_REGISTRY"`
`    - echo '<pat>' | docker login  -u $CI_REGISTRY_USER --password-stdin $CI_REGISTRY`
`  script:`
`  - echo "Building the app"`
`  - docker build --pull -t <image>:latest . -f ./prod/Dockerfile`
`  - docker push <image>:latest`


# (slug: job-docker) Basic docker job

`build-job:`
`  stage: build`
`  tags:`
`    - dind-runner`
`  services:`
`    - docker:24.0.5-dind`
`  variables:`
`    IMAGE_TAG: $CI_REGISTRY_IMAGE:$CI_COMMIT_REF_SLUG`

`  before_script:`
`    - echo "Logging to GitLab Container Registry with CI credentials..."`
`    - docker login -u $CI_REGISTRY_USER -p $CI_REGISTRY_PASSWORD $CI_REGISTRY`
`  script:`
`  - echo "Building the app"`
`  - docker build --pull -t $IMAGE_TAG . -f ./prod/Dockerfile`
`  - docker push $IMAGE_TAG`

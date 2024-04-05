FROM uselagoon/php-8.1-cli-drupal:latest

COPY composer.* /app/
RUN COMPOSER_MEMORY_LIMIT=-1 composer install --no-dev
COPY . /app
RUN mkdir -p -v -m775 /app/web/sites/default/files
RUN mkdir -p -v -m775 /app/private

# Explicitly install Chromium on Mac arm64. Otherwise Puppeteer will fail by trying to install the x64 version.
ARG TARGETARCH
RUN if [ $TARGETARCH = "arm64" ] ; then apk add --no-cache chromium ; PUPPETEER_SKIP_CHROMIUM_DOWNLOAD=true ; fi

# Compile themes.
RUN cd /app/web/themes/custom/govt_yukon && npm i && npm run compile && cd -
RUN cd /app/web/themes/custom/govt_yukon_claro && npm i && npm run compile && cd -
RUN cd /app/web/themes/custom/govt_yukon_rms && npm i && npm run compile && cd -

# Define where the Drupal Root is located.
ENV WEBROOT=web

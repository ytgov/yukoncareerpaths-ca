#!/usr/bin/env bash

# Runs several code standards tools, exiting with code 0 only if all of them do.

set -uo pipefail
shopt -s globstar

export WORKDIR="$PWD"
export PHPCS="vendor/squizlabs/php_codesniffer/bin/phpcs"
#export MODULES_DIR="modules/custom"
export THEMES_DIR="themes/custom"
export THEMES_DIR_SASS="themes/custom/govt_yukon/sass/custom"
export THEMES_ADMIN_DIR_SASS="themes/custom/govt_yukon_claro/sass/custom"
export THEMES_RMS_DIR_SASS="themes/custom/govt_yukon_rms/sass/custom"

main() {
  export RESULT=0;

  run-shellcheck
  run-phpcs
  run-readmecheck

  exit "${RESULT}"
}

function run-shellcheck() {
  shellcheck -x scripts/**/*.sh
  RESULT=$(("$RESULT" | $?))
}

function run-phpcs() {
  cd "${WORKDIR}/web" || exit 1
  "${WORKDIR}/${PHPCS}" -n "${THEMES_DIR_SASS}" --standard="${WORKDIR}/phpcs-standard.xml" --runtime-set installed_paths "${WORKDIR}/vendor/drupal/coder/coder_sniffer" --extensions=scss
  RESULT=$(("$RESULT" | $?))
  "${WORKDIR}/${PHPCS}" -n "${THEMES_ADMIN_DIR_SASS}" --standard="${WORKDIR}/phpcs-standard.xml" --runtime-set installed_paths "${WORKDIR}/vendor/drupal/coder/coder_sniffer" --extensions=scss
  RESULT=$(("$RESULT" | $?))
  "${WORKDIR}/${PHPCS}" -n "${THEMES_RMS_DIR_SASS}" --standard="${WORKDIR}/phpcs-standard.xml" --runtime-set installed_paths "${WORKDIR}/vendor/drupal/coder/coder_sniffer" --extensions=scss
  RESULT=$(("$RESULT" | $?))
  "${WORKDIR}/${PHPCS}" -s "${THEMES_DIR}" --standard="${WORKDIR}/phpcs-standard.xml" --runtime-set installed_paths "${WORKDIR}/vendor/drupal/coder/coder_sniffer" --extensions=php,module,inc,install,test,profile,theme,info,txt,md --ignore="(*.css|*/node_modules/*)"
  RESULT=$(("$RESULT" | $?))
  #"${WORKDIR}/${PHPCS}" -s "${MODULES_DIR}" --standard="${WORKDIR}/phpcs-standard.xml" --runtime-set installed_paths "${WORKDIR}/vendor/drupal/coder/coder_sniffer" --extensions=php,module,inc,install,test,profile,js,info,txt,md,yml --ignore="*/src/(Axis|WsdlToPhp)/*"
  #RESULT=$(("$RESULT" | $?))
  cd - >/dev/null || exit 1
}

function run-readmecheck() {
  #readmecheck web/modules/custom
  #RESULT=$(("$RESULT" | $?))
  readmecheck web/themes/custom
  RESULT=$(("$RESULT" | $?))
}

main "$@"

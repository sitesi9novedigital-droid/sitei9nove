#!/usr/bin/env bash
set -euo pipefail
cd "$(dirname "$0")/.."
THEME_ROOT="$PWD"
WP_RUNTIME="${I9_WP_RUNTIME:-/tmp/i9-wordpress}"
if [ ! -f "$WP_RUNTIME/wp-load.php" ]; then
  git clone --depth 1 --branch 6.8.3 https://github.com/WordPress/WordPress.git "$WP_RUNTIME"
fi
exec node node_modules/@wp-playground/cli/cli.js server \
  --wp=6.8.3 \
  --mount-before-install="$WP_RUNTIME:/wordpress" \
  --mount="$THEME_ROOT:/wordpress/wp-content/themes/sitei9nove" \
  --wordpress-install-mode=install-from-existing-files-if-needed \
  --blueprint="$THEME_ROOT/tools/blueprint.json" \
  --port="${PORT:-9400}" --workers=6 --login

#!/usr/bin/env bash
set -euo pipefail
cd "$(dirname "$0")/.."
THEME_ROOT="$PWD/elementor-theme"
WP_RUNTIME="${I9_ELEMENTOR_RUNTIME:-/tmp/i9-elementor-wordpress}"
PLUGIN_ROOT=/tmp/i9-elementor-built/elementor
if [ ! -f "$WP_RUNTIME/wp-load.php" ]; then
  git clone --depth 1 --branch 6.8.3 https://github.com/WordPress/WordPress.git "$WP_RUNTIME"
fi
if [ ! -f "$PLUGIN_ROOT/elementor.php" ]; then
  curl -fsSL https://github.com/elementor/elementor/releases/download/3.34.0/elementor-3.34.0.zip -o /tmp/i9-elementor.zip
  echo 'dea793d51d3f6f5a3e66faf6a22811917c39635e8438f445b130511c895b6fbb  /tmp/i9-elementor.zip' | sha256sum --check
  python3 - <<'PY'
from zipfile import ZipFile
with ZipFile('/tmp/i9-elementor.zip') as z:
    if z.testzip() is not None:
        raise RuntimeError('Arquivo Elementor corrompido')
    z.extractall('/tmp/i9-elementor-built')
PY
fi
if [ "${1:-}" = "--prepare-only" ]; then exit 0; fi
exec node node_modules/@wp-playground/cli/cli.js server \
  --wp=6.8.3 \
  --mount-before-install="$WP_RUNTIME:/wordpress" \
  --mount="$PLUGIN_ROOT:/wordpress/wp-content/plugins/elementor" \
  --mount="$THEME_ROOT:/wordpress/wp-content/themes/i9nove-elementor" \
  --wordpress-install-mode=install-from-existing-files-if-needed \
  --blueprint="$PWD/tools/blueprint-elementor.json" \
  --port="${PORT:-9401}" --workers=6 --login

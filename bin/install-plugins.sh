#!/usr/bin/env bash
# HYDRA Quality & Compliance — Plugin installer
# Run once after cloning: bash bin/install-plugins.sh
# Requires WP-CLI available as `wp`

set -e

echo "Installing HYDRA WordPress plugins..."

wp plugin install kadence-blocks   --activate --allow-root
wp plugin install seo-by-rank-math --activate --allow-root
wp plugin install w3-total-cache   --activate --allow-root
wp plugin install wpforms-lite     --activate --allow-root

echo "All plugins installed."
echo "Next: run wp eval-file wp-content/hydra-service-pages-todo.php --allow-root"

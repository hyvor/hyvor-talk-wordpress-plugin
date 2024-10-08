#!/bin/bash

set -e

# clean up build
rm -rf build

# copy plugin/ to build/trunk/
echo "moving the plugin folder..."
mkdir -p build/trunk/
cp -r plugin/* build/trunk/

# build admin
echo "Building the project..."
rm -rf dist
npm install --prefix admin
npm run build --prefix admin
# copy admin files to plugin
cp -r admin/dist/* build/trunk/static/admin/

# copy assets folder
echo "Copying assets..."
cp -r assets build

# composer install
composer install --no-dev --working-dir=build/trunk/

# optionally, tag
echo "Creating the tag folder..."
VERSION=$(grep -i "Version:" "plugin/hyvor-talk.php" | awk '{print $2}')
mkdir -p build/tags/$VERSION/
cp -r build/trunk/* build/tags/$VERSION/

echo "Build completed!"

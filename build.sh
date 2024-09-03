#!/bin/bash

set -e

rm -rf build

echo "moving the plugin folder..."
mkdir -p build/trunk/
cp -r plugin/* build/trunk/

echo "Building the project..."
cd admin
rm -rf dist
npm run build
cp -r dist/* ../build/trunk/static/admin/

echo "Copying assets..."
cd ..
cp -r assets build

echo "Creating the tag folder..."
if [[ $1 == --tag=* ]]; then
    tag="${1#--tag=}"
    echo "Syncing the directory of the tag: $tag"
    mkdir -p build/tags/$tag/
    cp -r  build/trunk/* build/tags/$tag/
fi

echo "Build completed!"
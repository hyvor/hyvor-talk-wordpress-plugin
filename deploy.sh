#!/bin/bash

set -e

PLUGIN_SLUG="hyvor-talk"  # Change this to your plugin's slug (name)
SVN_REPO="https://plugins.svn.wordpress.org/$PLUGIN_SLUG"
BUILD_DIR="build"  # Directory where your build is located
SVN_DIR="build-svn"  # Temporary directory for SVN checkout
VERSION=$(grep -i "Version:" "$BUILD_DIR/trunk/hyvor-talk.php" | awk '{print $2}')  # Extract plugin version from readme.txt

# Check if the version is set
if [ -z "$VERSION" ]; then
    echo "Error: Could not find version in trunk/hyvor-talk.php"
    exit 1
fi

# Check if $BUILD_DIR exists
if [ ! -d "$BUILD_DIR" ]; then
    echo "Error: Build directory does not exist. Run build.sh first."
    exit 1
fi

# Check if $BUIlD_DIR/tags/$VERSION exists
if [ ! -d "$BUILD_DIR/tags/$VERSION" ]; then
    echo "Error: Tag directory does not exist. Run build.sh first."
    exit 1
fi


echo "Deploying version $VERSION"

# Remove any previous SVN checkout
rm -rf $SVN_DIR

# Checkout the SVN repo
echo "Checking out the SVN repository..."
svn checkout $SVN_REPO $SVN_DIR

# Copy new files to trunk, assets, and tag
echo "Copying new files to trunk..."
rsync -av --delete $BUILD_DIR/trunk/ $SVN_DIR/trunk/
rsync -av --delete $BUILD_DIR/assets/ $SVN_DIR/assets/

echo "Copying new files to tag..."
mkdir -p $SVN_DIR/tags/$VERSION/
rsync -av --delete $BUILD_DIR/tags/$VERSION/ $SVN_DIR/tags/$VERSION/

# Add new files to SVN
echo "Adding new files to SVN..."
cd $SVN_DIR
svn add --force * --auto-props --parents --depth infinity -q

# Commit changes
#


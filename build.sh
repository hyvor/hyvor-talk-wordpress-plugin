#!/bin/bash

set -e

rm -rf dist

echo "Building the project..."
cd admin && bun run build
echo "Build completed."
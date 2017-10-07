#! /bin/sh

if [ 2 -ne $# ]; then
    echo "usage: $0 <project name> <release version>"
    echo "example: $0 drutopia_article 1.0-alpha1"
    exit 2
fi
project=$1
release=$2

echo "Tagging $project."
cd $project;
git checkout 8.x-1.x;
git pull;
git tag 8.x-$release;
echo "Pushing tag to GitLab."
git push origin tag 8.x-$release;
echo "Pushing tag to Github."
git push github tag 8.x-$release;
echo "Pushing tag to drupal.org."
git push drupal tag 8.x-$release;
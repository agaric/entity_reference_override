#! /bin/sh

if [ 1 -ne $# ]; then
    echo "usage: $0 <drupal.org user name>"
    exit 2
fi
user=$1

while read project
do
  git clone git@gitlab.com:drutopia/$project.git
  cd $project
  git remote add drupal $user@git.drupal.org:project/$project.git
  git remote add github git@github.com:drutopia/$project.git
  cd ..
done < drutopia_projects.txt

cd drutopia-infrastructure

while read project
do
  git clone git@gitlab.com:drutopia/$project.git
  cd $project
  git remote add drupal $user@git.drupal.org:project/$project.git
  git remote add github git@github.com:drutopia/$project.git
  cd ../..
done < drutopia_infrastructure_projects.txt

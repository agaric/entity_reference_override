#! /bin/sh

while read project
do
  git clone git@gitlab.com:drutopia/$project.git
  cd $project
  git remote add drupal git@git.drupal.org:project/$project.git
  git remote add github git@github.com:drutopia/$project.git
  cd ..
done < drutopia_projects.txt

mkdir drutopia-infrastructure

while read project
do
  cd drutopia-infrastructure
  git clone git@gitlab.com:drutopia/$project.git
  cd $project
  git remote add drupal git@git.drupal.org:project/$project.git
  git remote add github git@github.com:drutopia/$project.git
  cd ../..
done < drutopia_infrastructure_projects.txt

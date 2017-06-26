#! /bin/sh

while read project
do
  git clone git@gitlab.com:drutopia/$project.git
  cd $project
  git remote add drupal mlncn@git.drupal.org:project/$project.git
  git remote add github git@github.com:drutopia/$project.git
  cd ..
done < drutopia_projects.txt

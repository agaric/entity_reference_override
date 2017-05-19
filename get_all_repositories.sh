#! /bin/sh

while read project
do
  git clone git@gitlab.com:drutopia/$project.git
  cd $project
  git remote add drupal mlncn@git.drupal.org:project/$project.git
  cd ..
done < drutopia_projects.txt

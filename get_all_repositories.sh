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


mkdir findit
cd findit

while read project
do
  git clone git@gitlab.com:find-it-program-locator/$project.git
  cd $project
  git remote add drupal git@git.drupal.org:project/$project.git
  git remote add github git@github.com:drutopia/$project.git
  cd ../
done < ../findit_projects.txt

cd ../


mkdir -p agaric/drupal
cd agaric/drupal

while read project
do
  git clone git@gitlab.com:agaric/drupal/$project.git
  cd $project
  git remote add drupal git@git.drupal.org:project/$project.git
  git remote add github git@github.com:agaric/$project.git
  cd ../
done < ../../agaric_projects.txt

cd ../../

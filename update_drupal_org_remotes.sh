# Temporary measure to update our local repos with Drupal.org's new way: https://www.drupal.org/gitauth 

for i in */.git; do ( echo $i; cd $i/..; git remote set-url drupal git@git.drupal.org:project/${i::-5}.git; ); done

for i in drutopia-infrastructure/*/.git; do ( echo $i; cd $i/..; git remote set-url drupal git@git.drupal.org:project/$i.git; ); done


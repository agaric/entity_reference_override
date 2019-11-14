#! /bin/sh

for i in */.git; do ( echo $i; cd $i/..; git pull; ); done

for i in */.git; do ( echo $i; cd $i/..; git push drupal 8.x-1.x; git push drupal --tags; ); done

for i in */.git; do ( echo $i; cd $i/..; git push github 8.x-1.x; git push github --tags; ); done


for i in drutopia-infrastructure/*/.git; do ( echo $i; cd $i/..; git pull; ); done

for i in drutopia-infrastructure/*/.git; do ( echo $i; cd $i/..; git push drupal master; git push drupal --tags; ); done

for i in drutopia-infrastructure/*/.git; do ( echo $i; cd $i/..; git push github master; git push github --tags; ); done


for i in find-it-program-locator/*/.git; do ( echo $i; cd $i/..; git pull; ); done
for i in find-it-program-locator/*/.git; do ( echo $i; cd $i/..; git push drupal master; git push drupal --tags; ); done
for i in find-it-program-locator/*/.git; do ( echo $i; cd $i/..; git push github master; git push github --tags; ); done


for i in agaric/drupal/*/.git; do ( echo $i; cd $i/..; git pull; ); done
for i in agaric/drupal/*/.git; do ( echo $i; cd $i/..; git push drupal master; git push drupal --tags; ); done
for i in agaric/drupal/*/.git; do ( echo $i; cd $i/..; git push github master; git push github --tags; ); done

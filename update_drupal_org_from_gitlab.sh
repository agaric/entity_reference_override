for i in */.git; do ( echo $i; cd $i/..; git pull; ); done

for i in */.git; do ( echo $i; cd $i/..; git push drupal 8.x-1.x; ); done

for i in */.git; do ( echo $i; cd $i/..; git push github 8.x-1.x; ); done

for i in drutopia-infrastructure/*/.git; do ( echo $i; cd $i/..; git push drupal master; ); done

for i in drutopia-infrastructure/*/.git; do ( echo $i; cd $i/..; git push github master; ); done

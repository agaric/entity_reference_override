# List current release tag for each project

for i in */.git; do ( p=${i::-5}; cd $p; echo "$p:" `git describe --tags --abbrev=0`; ); done

# let's not worry about infrastructure projects for now
# for i in drutopia-infrastructure/*/.git; do ( echo $i; cd $i/..; ... ); done


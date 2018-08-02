# List commits since most recent tag
# As a bonus, it's markdown formatted

for i in */.git; do ( echo "## ${i::-5}"; cd $i/..; git log `git describe --tags --abbrev=0`..HEAD --pretty=format:"%h %s  "; ); done

# let's not worry about infrastructure projects for now
# for i in drutopia-infrastructure/*/.git; do ( echo $i; cd $i/..; ... ); done


Instructions for using this extremely hacky approach to keeping Drutopia
projects Drupal.org mirrors up-to-date:

```
git clone git@gitlab.com:drutopia/hackysync.git
cd hackysync
./get_all_repositories.sh <drupal.org user name>
./update_drupal_org_from_gitlab.sh
```

And thereafter:

```
./update_drupal_org_github_from_gitlab.sh
```

New projects can be added to `drutopia_projects.txt` (the
`get_all_repositories.sh` script is not
smart enough to only try to add new projects, but if you ignore the
errors it should work).

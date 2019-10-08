Instructions for using this extremely hacky approach to keeping Drutopia
projects Drupal.org mirrors up-to-date:

```
git clone git@gitlab.com:drutopia/hackysync.git
cd hackysync
./get_all_repositories.sh
./update_drupal_org_github_from_gitlab.sh
```

And thereafter:

```
git pull
./update_drupal_org_github_from_gitlab.sh
```

New projects can be added to `drutopia_projects.txt` (the
`get_all_repositories.sh` script is not
smart enough to only try to add new projects, but if you ignore the
errors it should work).

Optionally use `./get_all_repositories.sh extra` to also fetch Find It and Agaric projects for synching.

## Tagging

To push a tag to GitLab, Github, and drupal.org use the script
`tag_project_release.sh`. Sample command:

```
./tag_project_release.sh drutopia_article 1.0-alpha1
```

# Techarq Blocks

## Requirements
- Node 16.13.2
- Composer 2.2.9

## Install
- Clone this repository into your plugin's folder.
- Run `npm install` in order to install JS dependencies.
- Run `npm run build` in order to build the scripts.
- Run `composer install` in order to install PHP dependencies.
- For Development environments you should add this line to the wp-config.php file `define( 'WC_PLUGIN_FACTORY_DEVELOPMENT', true );` in order to get the latest version of the plugin, if it's not defined the last update of the plugin will be the stable one setted up into your plugins settings.

## Browser Sync
- Copy the file `.env-webpack` file and rename it as `.env` (DON'T RENAME THE ORIGINAL FILE `.env-webpack`)
- Replace the value of the key `LOCAL_SERVER_URL` with your virtual host.

## Linters
  We've configured a set of linters that'll help you create a more curated and stylish code, based on well known standards. 
  
  ### Standards

  * [Google JavaScript Style Guide](https://google.github.io/styleguide/jsguide.html).
  * [WordPress Coding Standards](https://github.com/WordPress/WordPress-Coding-Standards).
  * [Stylelint + Prettier](https://github.com/prettier/stylelint-config-prettier-scss).

  ### What does these Linters need?

  This Linters will need you to run `npm install` for the JS and SCSS linters, and a `composer install` for the PHP Code Sniffer. 
  
  Both commands should be run from the theme folder (don't worry, if you run them from the root dir, it'll fail).

  Run the npm install from the VSCode console directly (you'll need NodeJS installed).
  
  For the composer command, you can run it from the Site Shell of any LocalWP site you've already have configured.

  ### How to configure Visual Studio Code

  1. Once you've cloned this project, you'll have a `.vscode` folder in the root dir. This folder contains the *settings* and *extensions* recommended for your workspace.
  2. Go to Extensions > Filter by "Recommended" > Install All
  3. When you change the theme name, you'll have to update the theme name in the file `.vscode/settings.json`, for the options:
  ```json
  {
    "phpsab.executablePathCS": "wp-content/themes/<<THEME-NAME>>/vendor/bin/phpcs",
    "phpsab.executablePathCBF": "wp-content/themes/<<THEME-NAME>>/vendor/bin/phpcbf",
  }
  ```
  4. That's it, you're ready to work!

  ### How to run the Linters and Fixers

  To run the linters or fixers manually (yup, every linter comes with a fixer out of the box!) you'll have a few commands pre-configured both in the `package.json` and `composer.json` files.

  The linters installed in this boilerplate are:
  * [PHPCS](https://github.com/squizlabs/PHP_CodeSniffer)
  * [ESLint](https://eslint.org/docs/latest/user-guide/getting-started)
  * [StyleLint](https://stylelint.io/)

  ```
  NOTE: We'll describe a few useful commands. For more advanced configuration or options, please refer to each linter documentation.
  ```

  All commands should be run from within the theme folder.

  **PHPCS**

  From your LocalWP dashboard, open the "Site Shell" and execute this commands

  Scan for issues
  ```
  $ composer run check-cs **/*.php
  ```

  Try to fix the issues (as every other linter, this will try fix simple issues like indentation).
  ```
  $ composer run fix-cs **/*.php
  ```

  **ESLint + StyleLint**

  From the Visual Studio Code Console, run this commands:

  Scan for issues
  ```
  $ npm run lint:js
  $ npm run lint:css
  ```

  Try to fix issues
  ```
  $ npm run fix:js
  $ npm run fix:css
  ```

---

## Repository

* ### How to name your branch:

  {issue-id}-{dev-initials}-[feature, hotfix]-{short-description}

  Example: 75-sp-feature-add-hero-home

* ### How you should describe your commits:

  {issue-id}-[feature, hotfix]: {short description}

  Example: 75-feature: created home hero acf

* ### How you should name the merge request:

  Draft: {title of the issue-task}

  Example: Draft: Resolve "New Issue test"

* ### Pipelines
  We use manual actions pipelines, that allow us to deploy stages from gitlab pull requests.

    Pipeline file => `.gitlab-ci.yml`

## Deploy Process
We have to create releases from gitlab with a brand new tag like this example: `0.1.2`, all numbers support up to number 9.
Then if your release is stable you can set it up from our site [dashboard](https://conicdev.com/wp-admin/post.php?post=2014&action=edit).

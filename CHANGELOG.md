All notable changes will be added here.
-------------------------------------------------------------------------------

### 8.0.0 <2022-07-19>
- Now using PHP8.1 [#1043](https://github.com/elvispt/zeteticelench/pull/1043).
- Fixed issue with login process [#1040](https://github.com/elvispt/zeteticelench/pull/1040).
- Fixed issue with tests failing [#949](https://github.com/elvispt/zeteticelench/pull/949).
- Many dependency updates.

### 7.0.0 <2021-08-05>
- Upgraded to Laravel 8.x [#797](https://github.com/elvispt/zeteticelench/pull/797).
- Set App timezone to "Europe/Lisbon" [#799](https://github.com/elvispt/zeteticelench/pull/799).
- Removed unnecessary SpaController. Now using helper Route::view [#798](https://github.com/elvispt/zeteticelench/pull/798).
- Docker container now uses Node v16 (from v10) [#805](https://github.com/elvispt/zeteticelench/pull/805).

### 6.4.0 <2021-08-01>
- Removed expenses feature since it was not being used.
  - [#795](https://github.com/elvispt/zeteticelench/pull/795).
- Fixed issue with tags selector on edit note view.
  - [#794](https://github.com/elvispt/zeteticelench/pull/794).
- Global update to php and js dependencies.
  - Some of the js packages were updated according to npm recommendations
due to security issues.
  - [#796](https://github.com/elvispt/zeteticelench/pull/796).

### 6.3.0 <2021-07-24>
- Update phpunit schema config to a non-deprecated version.
- Dependency updates.

### 6.2.0 <2021-03-14>
- Fixed issue with CI with github runner failing all tests.
  - [#669](https://github.com/elvispt/zeteticelench/pull/669).
  - Composer now shows the installation logs.
  - Github actions now uses shivammathur/setup-php@2.9.0 be able to set up a
    specific php version on github runner.
  - Updated Composer to v2 (2.0.9). This version now downloads packages in
    parallel making installations much faster.
  - Show dev dependencies installation in log
  - Specify GitHub-hosted runners to ubuntu-18.04
- Fixed issue with login errors messages not appearing when the user was
  entering incorrect credentials, the error messages would not appear
  [#669](https://github.com/elvispt/zeteticelench/pull/669).

### 6.1.0 <2020-08-19>
- Now able to edit and delete expenses
[#610](https://github.com/elvispt/zeteticelench/pull/610).
- Can now change user's password
[#569](https://github.com/elvispt/zeteticelench/pull/569).
- Now using mostly Element.io $notify instead of $message when informing the
user of a success/failure of an action
[#572](https://github.com/elvispt/zeteticelench/issues/572).
- Removed Next Holidays feature
[#584](https://github.com/elvispt/zeteticelench/issues/584).
- Simplified weather widget.
- Fixed issue with tag styling on notes
[#573](https://github.com/elvispt/zeteticelench/issues/573).
- Fixed issue where a tag could not be added when creating a note
[#571](https://github.com/elvispt/zeteticelench/issues/571).
- Fixed issue with login where it would fail requiring the user to refresh
the page.

### 6.0.1 <2020-07-09>
- Show the numeric keypad when the amount field is selected on mobile browsers
[#563](https://github.com/elvispt/zeteticelench/issues/563).
- Use Vue-Router guards to check on user's authentication status.
- Fixed issue with add expense fields showing errors after user successfully
submits an expense.

### 6.0.0 <2020-07-02>
- Now using Vuex on Notes, and Users modules
[#556](https://github.com/elvispt/zeteticelench/issues/556),
[#560](https://github.com/elvispt/zeteticelench/issues/560).
- Added a basic expenses tracker
[#559](https://github.com/elvispt/zeteticelench/issues/559).
- Grouped routes using Vue.js nested routes functionality
[#550](https://github.com/elvispt/zeteticelench/issues/550).
- Fixed issue with some Main Navigation items not highlighting. Simplified
how menu items are highlighted using Vue.js routes functionality.

### 5.0.2 <2020-06-23>
- Fix issue with login where Vue.js does not detect that the inputs were not
being populated when using autocomplete, with a password manager like the
browser's or LastPass or Firefox Lockwise.
[#542](https://github.com/elvispt/zeteticelench/issues/542).
- Added new tests for HackerNewsController and GameDeals library.
[#546](https://github.com/elvispt/zeteticelench/pull/546).

### 5.0.1 <2020-06-19>
- Remove dev user

### 5.0.0 <2020-06-19>
- Now a full Vue.js SPA application.

### 4.3.3 <2020-05-18>
- Fixed issue with translations causing error due to undefined value provided
for translation string.

### 4.3.2 <2020-05-17>
- Now able to use Laravel's lang strings in client side code.
- Added MainNavigation to user's application.
- Improved loader appearance on hn post.
- Updated look of collapse button on hn post.
- All changes can be found at:
[#510](https://github.com/elvispt/zeteticelench/pull/510).

### 4.3.1 <2020-05-16>
- HN Post comments no longer autoupdate. When there were changes on the
comments, the UI would update causing confusion. It now never updates after
first load.
- Collapsed comments are now stored on the user's browser.

### 4.3.0 <2020-05-15>
- Added automated database backups. A scheduled command will dump the db then
upload to dropbox
[#506](https://github.com/elvispt/zeteticelench/pull/506).
- Updated Dockerfile:
  - added mysql-client so that `mysqldump` command becomes available to the
  automated backup.
  - generated image is ready for production.
  - when on dev environment run the `/root/dev.sh` file to enabled xdebug and
  disable opcache.

### 4.2.0 <2020-05-14>
- Comments, on HackerNews, can now be collapsed.
- Show which route is active on MainNavigation.

### 4.1.1 <2020-05-13>
- Fixed issue with Navbar not working with xs screens. This was due to having
removed jQuery, hence the js code for managing the dropdown would not function.
The menu is now a Vue.js component. The user section does not have a navbar
at least until the users section becomes a Vue.js application
[#500](https://github.com/elvispt/zeteticelench/issues/500).

### 4.1.0 <2020-05-12>
- Fixed issue where the list of bookmarked HackerNews posts was being
overwritten after a few seconds by the list of top/best hn posts
[#494](https://github.com/elvispt/zeteticelench/issues/494).
- Added a loader when user clicks the button to bookmark a post (vice-versa)
[#492](https://github.com/elvispt/zeteticelench/issues/492).
- HackerNews posts are now loaded in two batches to allow the user to interact
with the page sooner.
- Unified layout files into a single layout file on the root of the views.
- Removed jQuery and Popper.js dependencies
[#499](https://github.com/elvispt/zeteticelench/issues/499).
- Removed RemoteJobs widget
[#496](https://github.com/elvispt/zeteticelench/issues/496).
- Added diffForHumans as a global Vue.js filter
[#497](https://github.com/elvispt/zeteticelench/issues/497).
- Removed unused views and classes, mostly related to HackerNews app
[#496](https://github.com/elvispt/zeteticelench/issues/496).

### 4.0.0 <2020-05-11>
- Refactor HackerNews section into a Vue.js app.
- All hn posts are obtained by making a call to a Firebase real time
db, that is public. All done client side. Only saved posts are stored
into backend DB.
- Removed hacker_news_items table.
- Removed import logic for hn items.
- All changes in the pull request
[#490](https://github.com/elvispt/zeteticelench/pull/490).

### 3.4.1 <2020-05-07>
- Fixed issue where exception was not being caught when connecting to advice
slip api.

### 3.4.0 <2020-05-07>
- Now able to search by tags on notes search input
[#479](https://github.com/elvispt/zeteticelench/pull/479).
- Textarea on notes create/edit now has a monospaced font (Inconsolata)
[#478](https://github.com/elvispt/zeteticelench/pull/478).
- Added CommonMark Footnote extension
[#478](https://github.com/elvispt/zeteticelench/pull/478).
- Added CommonMark ExternalLinkExtension
[#478](https://github.com/elvispt/zeteticelench/pull/478).
- Removed CommonMark SmartPuncExtension (converts ASCII quotes, dashes, and
ellipses to their Unicode equivalents)
[#478](https://github.com/elvispt/zeteticelench/pull/478).
- Added fallback lines to inspire component. These show up if/when the inspire
API fails for some reason.

### 3.3.0 <2020-05-05>
- Now able to insert two spaces on note textarea when pressing tag
[#471](https://github.com/elvispt/zeteticelench/pull/471).
- Notes page can now output tables due to added support from CommonMark lib
[#470](https://github.com/elvispt/zeteticelench/pull/470).
- Extracted frontend vendor libraries to permit subsequent faster page loads
[#471](https://github.com/elvispt/zeteticelench/pull/471),
[#457](https://github.com/elvispt/zeteticelench/pull/457).
- Reorganized vue.js apps and corresponding components
[#457](https://github.com/elvispt/zeteticelench/pull/457).
- General update to frontend deps.

### 3.2.1 <2020-04-24>
- Fixed issue with date format that was caused by the Laravel v7 update where
the serialization of date fields, in the models, changed it's format
[#453](https://github.com/elvispt/zeteticelench/pull/453).
- Fixed issue with collapse function not working on hacker news comments.

### 3.2.0 <2020-04-24>
- Small screen improvements and bug fixes:
  - Increased base font-size to 16px to help fix a zoom issue on small devices.
  When the user selected an input field the mobile browser would zoom in and
  after that it would not.
  - Added a button to insert code blocks since this is harder on mobile
  keyboards.
  - Tag styling was changed from button style to standard tag style.
  - Added a small version of Algolia logo for xs screens.
  - Gutter is now removed on xs screens to make better use of available screen
  space.
  - [#445](https://github.com/elvispt/zeteticelench/pull/445).
- Updated Laravel to v7.7.1
[#447](https://github.com/elvispt/zeteticelench/pull/447).
- Fixed issue with saving/removing favorite hn posts was not working. This fix
is temporary until the Vue.js refactor is applied to the Hacker News app.
[#448](https://github.com/elvispt/zeteticelench/pull/448).

### 3.1.0 <2020-04-22>
- Added Syntax Highligthing to notes
[#434](https://github.com/elvispt/zeteticelench/pull/434).
- Fixed issue with searching notes when clearing field
[#432](https://github.com/elvispt/zeteticelench/pull/432).
- Replaced most usages of native Fetch with Axios library so that a global
interceptor could be added to check if the user has lost authentication. If
the user has lost it, then it will be automatically redirected to the login
page. [#438](https://github.com/elvispt/zeteticelench/pull/438).
- Removed scripts from the login page since those are unnecessary.

### 3.0.1 <2020-04-20>
- Docker image now used php 7.4 and node v10.

### 3.0.0 <2020-04-20>
- Frontend sections Dashboard and Notes have been rewritten using Vue.js. Each
section is a separate Vue.js application.
  - Removed Tag listing page.
  - Users now create tags on the edit/create note page.
- Added a current weather widget to Dashboard
[#427](https://github.com/elvispt/zeteticelench/pull/427).

### 2.0.1 <2020-04-02>
- Bump laravel/framework from 6.18.0 to 6.18.3
[#382](https://github.com/elvispt/zeteticelench/pull/382)
[#388](https://github.com/elvispt/zeteticelench/pull/388).
- Note that from now on only packages that introduce major changes will be
refered in this changelog, with the exception being the laravel framework that
will always be mentioned.

### 2.0.0 <2020-03-09>
- Remove expenses feature. This feature was not being used and part of the
project goal of having minimal bloat.
[#378](https://github.com/elvispt/zeteticelench/pull/378).
- Free games notifier now includes all sources on /r/GameDeals, instead of just
Epic Games [#380](https://github.com/elvispt/zeteticelench/pull/380).
- General update to php dependencies. This is to prepare update of Laravel to
v7.

### 1.14.1 <2020-03-06>
- Moved hn comment collapse button to right side of screen for use with xs
screens.
- Improved notes listing on xs screens.
- Improve dashboard loading time
[#374](https://github.com/elvispt/zeteticelench/pull/374):
  - Advice splip api requests are now on a Task Schedule.
  - Calendarific api requests are now on a Task Schedule.
  - RemoteJobs listing is now stored to cache.
- Improved note edit sytling screen
[#376](https://github.com/elvispt/zeteticelench/pull/376).
- Bump fideloper/proxy from 4.2.2 to 4.3.0
[#362](https://github.com/elvispt/zeteticelench/pull/362).
- Bump barryvdh/laravel-ide-helper from 2.6.6 to 2.6.7
[#364](https://github.com/elvispt/zeteticelench/pull/364).
- Bump laravel/framework from 6.16.0 to 6.18.0
[#366](https://github.com/elvispt/zeteticelench/pull/366)
[#370](https://github.com/elvispt/zeteticelench/pull/370).
- Bump sentry/sentry-laravel from 1.6.2 to 1.7.0
[#367](https://github.com/elvispt/zeteticelench/pull/367).
- Bump laravel/telescope from 3.0.0 to 3.1.1
[#368](https://github.com/elvispt/zeteticelench/pull/368).
- Bump league/commonmark from 1.3.0 to 1.3.1
[#369](https://github.com/elvispt/zeteticelench/pull/369).
- Bump spatie/laravel-view-models from 1.2.0 to 1.3.0
[#371](https://github.com/elvispt/zeteticelench/pull/371).
- Bump facade/ignition from 1.16.0 to 1.16.1
[#375](https://github.com/elvispt/zeteticelench/pull/375).

### 1.14.0 <2020-02-19>
- Removed unsplash background image feature. Was making the dashboard slow
[#357](https://github.com/elvispt/zeteticelench/issues/357).
- Bump laravel/framework from 6.14.0 to 6.16.0
[#353](https://github.com/elvispt/zeteticelench/pull/353)
[#359](https://github.com/elvispt/zeteticelench/pull/359).
- Bump laravel/telescope from 2.1.5 to 3.0.0
[#354](https://github.com/elvispt/zeteticelench/pull/354)
[#360](https://github.com/elvispt/zeteticelench/pull/360).
- Bump nunomaduro/phpinsights from 1.12.0 to 1.13.0
[#355](https://github.com/elvispt/zeteticelench/pull/355).
- Bump sentry/sentry-laravel from 1.6.1 to 1.6.2
[#356](https://github.com/elvispt/zeteticelench/pull/356).

### 1.13.1 <2020-02-11>
- Fixed issue where free game was not detected properly
[#350](https://github.com/elvispt/zeteticelench/issues/350)

### 1.13.0 <2020-02-11>
- Every friday a script will run to check on reddit/r/GameDeals if there are
new EGS games available. If yes, then an email will be sent.
[#347](https://github.com/elvispt/zeteticelench/issues/347)
[#348](https://github.com/elvispt/zeteticelench/pull/348).
- Fixe issue with tests when using dates.
- Refactor code based on feedback from phpinsights.
- Bump laravel/framework from 6.5.1 to 6.14.0
[#344](https://github.com/elvispt/zeteticelench/pull/344).
- Bump laravel/tinker from 2.1.0 to 2.2.0
[#345](https://github.com/elvispt/zeteticelench/pull/345).
- Bump nunomaduro/larastan from 0.4.3 to 0.5.2
[#343](https://github.com/elvispt/zeteticelench/pull/343)
[#349](https://github.com/elvispt/zeteticelench/pull/349).
- Bump sentry/sentry-laravel from 1.5.0 to 1.6.1
[#337](https://github.com/elvispt/zeteticelench/pull/337).
- Bump algolia/algoliasearch-client-php from 2.5.0 to 2.5.1
[#336](https://github.com/elvispt/zeteticelench/pull/336).
- Bump fzaninotto/faker from 1.9.0 to 1.9.1
[#335](https://github.com/elvispt/zeteticelench/pull/335).
- Bump facade/ignition from 1.12.0 to 1.16.0
[#334](https://github.com/elvispt/zeteticelench/pull/334).
- Bump doctrine/dbal from 2.10.0 to 2.10.1
[#332](https://github.com/elvispt/zeteticelench/pull/332).
- Bump fideloper/proxy from 4.2.1 to 4.2.2
[#330](https://github.com/elvispt/zeteticelench/pull/330).
- Bump league/commonmark from 1.1.1 to 1.3.0
[#328](https://github.com/elvispt/zeteticelench/pull/328)
[#346](https://github.com/elvispt/zeteticelench/pull/346).
- Bump laravel/tinker from 1.0.10 to 2.1.0
[#327](https://github.com/elvispt/zeteticelench/pull/327).
- Bump phpunit/phpunit from 8.4.3 to 8.5.2
[#322](https://github.com/elvispt/zeteticelench/pull/322).
- Bump mockery/mockery from 1.2.4 to 1.3.1
[#318](https://github.com/elvispt/zeteticelench/pull/318).
- Bump guzzlehttp/guzzle from 6.4.1 to 6.5.2
[#316](https://github.com/elvispt/zeteticelench/pull/316).
- Bump laravel/telescope from 2.1 to 2.1.5
[#314](https://github.com/elvispt/zeteticelench/pull/314)
[#338](https://github.com/elvispt/zeteticelench/pull/338)
[#342](https://github.com/elvispt/zeteticelench/pull/342).
- Bump barryvdh/laravel-ide-helper from 2.6.5 to 2.6.6
[#303](https://github.com/elvispt/zeteticelench/pull/303).
- Bump nunomaduro/phpinsights from 1.9.0 to 1.12.0
[#294](https://github.com/elvispt/zeteticelench/pull/294)
[#302](https://github.com/elvispt/zeteticelench/pull/302)
[#341](https://github.com/elvispt/zeteticelench/pull/341).

### 1.12.0 <2019-11-17>
- Filter movements/expenses by dates and tag
[#282](https://github.com/elvispt/zeteticelench/issues/282).
- New docker image with php-7.3.
  - Composer updated to 1.9.1.
  - The base image for php-7.3 uses Debian 10 instead of Debian 9 where the
  nodejs version, in the official package repo, is v10+. For some reason the
  installation for this version does not include npm (maybe instalation bug).
  To force the system to use nodejs v8 we had to include a new file that gives
  priority to the node version for deb.nodesource.com
  [#290](https://github.com/elvispt/zeteticelench/issues/290).
  - PHP scripts now have 256MB of memory. This is because unit/feature tests
  were failing due to insufficient memory
  [#289](https://github.com/elvispt/zeteticelench/issues/289).
- Bump facade/ignition from 1.11.2 to 1.12.0
[#291](https://github.com/elvispt/zeteticelench/pull/291).
- Bump fzaninotto/faker from 1.8.0 to 1.9.0
[#292](https://github.com/elvispt/zeteticelench/pull/292).

### 1.11.0 <2019-11-14>
- Now able to edit a movement
[#279](https://github.com/elvispt/zeteticelench/issues/279).
- Updated `movements` table so that an update would not change the
`amount_date` field automatically.
- Updated feature tests for movements controller.
- Refactored to reduce code duplication.
- Bump laravel/framework from 6.5.0 to 6.5.1
[#283](https://github.com/elvispt/zeteticelench/pull/283).
- Bump sentry/sentry-laravel from 1.4.1 to 1.5.0
[#280](https://github.com/elvispt/zeteticelench/pull/280).
- Bump league/commonmark from 1.1.0 to 1.1.1
[#281](https://github.com/elvispt/zeteticelench/pull/281).
- [Security] Bump symfony/cache from 4.3.6 to 4.3.8
[#284](https://github.com/elvispt/zeteticelench/pull/284).

### 1.10.1 <2019-11-11>
- Fix issue where the staleTags commands was removing expense tags from the
database.
- Sort tag expenses by the highest value
[#277](https://github.com/elvispt/zeteticelench/issues/277).
- Add missing translation for expense creation page
[#276](https://github.com/elvispt/zeteticelench/issues/276).

### 1.10.0 <2019-11-10>
- Movements now have a tag.
  - A total of expenses per tag is now shown on the movements page.
  - Tags now have a type that can either be: `NOTE` or `EXPENSE`.
- Rule ExistsWithUser now accepts other columns to check against, and its
corresponding value.
- Added feature tests for AccountsController and MovementsController.
- Updated several php dependencies to most recent versions.
- Bump phpunit/phpunit from 8.4.2 to 8.4.3
[#270](https://github.com/elvispt/zeteticelench/pull/270).

### 1.9.2 <2019-11-06>
- Now grouping expenses by day.
- Now showin the total amount of expenses by day.
- Now showing the total amount of expenses.
- Fixed issue with the number of queue workers not being correctly identified
on the dashboard [#264](https://github.com/elvispt/zeteticelench/issues/264).
- Fixed issue where the Expenses main menu option is not highlighted when on
the expenses section of the application.
- Bump algolia/algoliasearch-client-php from 2.4.0 to 2.5.0
[#265](https://github.com/elvispt/zeteticelench/pull/265).
- Bump laravel/framework from 6.4.1 to 6.5.0
[#266](https://github.com/elvispt/zeteticelench/pull/266).

### 1.9.1 <2019-11-05>
- User now picks if the movement is a debit or credit. Will automatically set
a negative amount if the user picks debit. The UI selects debit by default.
- Fixed issue with list of movements not being sorted by date_amount
[#261](https://github.com/elvispt/zeteticelench/issues/261).
- Fixed issue where the soft deletes column was set on movements table instead
of the accounts table
[#260](https://github.com/elvispt/zeteticelench/issues/260).

### 1.9.0 <2019-11-04>

- Added new expenses section. User can add expenses to an account.
Note that at this time, the account must be created directly in the database.
- Updated Laravel to v6.4.1
[#248](https://github.com/elvispt/zeteticelench/pull/248).
  - Made a general update to all php dependencies. There are too many to list
    here so please check commits.

### 1.8.3 <2019-09-26>
- Updated frontend assets.

### 1.8.2 <2019-09-26>
- Bump laravel/scout from 7.1.3 to 7.2.1
[#224](https://github.com/elvispt/zeteticelench/pull/224).
- Bump laravel/framework from 6.0.3 to 6.0.4
[#223](https://github.com/elvispt/zeteticelench/pull/223).
- Bump sentry/sentry-laravel from 1.2.1 to 1.3.0
[#222](https://github.com/elvispt/zeteticelench/pull/222). This is an automated
security fix recommended by Github.
- Bump mixin-deep from 1.3.1 to 1.3.2
[#221](https://github.com/elvispt/zeteticelench/pull/221). This is an automated
security fix recommended by Github.
- Bump facade/ignition from 1.6.0 to 1.8.2
[#220](https://github.com/elvispt/zeteticelench/pull/220).
- Bump sentry/sentry-laravel from 1.2.0 to 1.2.1
[#217](https://github.com/elvispt/zeteticelench/pull/217).
- Bump phpunit/phpunit from 8.3.4 to 8.3.5
[#216](https://github.com/elvispt/zeteticelench/pull/216).
- Bump algolia/algoliasearch-client-php from 2.3.0 to 2.4.0
[#213](https://github.com/elvispt/zeteticelench/pull/213).

### 1.8.1 <2019-09-11>
- Refactored some controller logic into actions
[Refactoring to actions ](https://freek.dev/1371-refactoring-to-actions).
- Now using ViewModels to load view data on some endpoints
[spatie/laravel-view-models]()https://github.com/spatie/laravel-view-models).
- Bump laravel/framework from 5.8.35 to 6.0.3
[#207](https://github.com/elvispt/zeteticelench/pull/209) and
[#207](https://github.com/elvispt/zeteticelench/pull/212).

### 1.8.0 <2019-09-08>
- Show remote jobs on Dashboard
[#93](https://github.com/elvispt/zeteticelench/issues/93).
- Fixed issue where jobs list could be null.
[#207](https://github.com/elvispt/zeteticelench/pull/207).
- Removed dev env key from env file./
- Bump nunomaduro/larastan from 0.3.17 to 0.4.0
[#198](https://github.com/elvispt/zeteticelench/pull/198).
- Bump algolia/scout-extended from 1.6.0 to 1.7.0
[#199](https://github.com/elvispt/zeteticelench/pull/199).
- Bump sentry/sentry-laravel from 1.1.0 to 1.2.0
[#201](https://github.com/elvispt/zeteticelench/pull/201).
- Bump fideloper/proxy from 4.2.0 to 4.2.1
[#202](https://github.com/elvispt/zeteticelench/pull/202).
- Bump laravel/framework from 5.8.33 to 5.8.35
[#203](https://github.com/elvispt/zeteticelench/pull/203).
- Bump laravel/telescope from 2.0.6 to 2.1
[#205](https://github.com/elvispt/zeteticelench/pull/205).
- Bump barryvdh/laravel-ide-helper from 2.6.2 to 2.6.5
[#208](https://github.com/elvispt/zeteticelench/pull/208).

### 1.7.6 <2019-08-30>
- Fixed issue where page was being emptied when on some hacker news items. This
issue occurred due to VueJS interpolating HN comments as VueJS expressions.
[#200](https://github.com/elvispt/zeteticelench/issues/200).

### 1.7.5 <2019-08-28>
- Fixed issue when parsing JSON response. When parsing response from advice
slip an invalid JSON was being returned and we were not properly checking if
theJSON is valid.

### 1.7.3 <2019-08-08>
- Fixed issue with bookmarking not working sometimes.

### 1.7.3 <2019-08-01>
- Added Algolia logo on notes page, as required by the community plan.
- Fixed issue with attaching events on page load
[#180](https://github.com/elvispt/zeteticelench/pull/180).
- Bump laravel/scout from 7.1.2 to 7.1.3
[#179](https://github.com/elvispt/zeteticelench/pull/179).
- Bump laravel/framework from 5.8.29 to 5.8.30
[#178](https://github.com/elvispt/zeteticelench/pull/178).
- Bump fideloper/proxy from 4.1.0 to 4.2.0
[#177](https://github.com/elvispt/zeteticelench/pull/177).
- Bump laravel/tinker from 1.0.8 to 1.0.9
[#176](https://github.com/elvispt/zeteticelench/pull/176).

### 1.7.2 <2019-07-23>
- Added production assets to repo, since the server has low memory and is not
capable of building the assets on the server.

### 1.7.1 <2019-07-23>
- The collapsed comments are now stored so that when the user revisits a
hacker news post comments, previously collapsed comments will still be
collapsed [#171](https://github.com/elvispt/zeteticelench/issues/171).
- The number of bookmarked stories is now visible on the menu option
[#169](https://github.com/elvispt/zeteticelench/issues/168).
- Now highlighting moderator name on comments list
[#168](https://github.com/elvispt/zeteticelench/issues/168).
- When the user opens a note, after a search, the searched word will be
highlighted on the notes page. To obtain the highlighted words we had to use
the package "algolia/scout-extended". Requires a reindexing the notes.
[#170](https://github.com/elvispt/zeteticelench/issues/170).
- Use self hosted version of sentry.io client side Js.
- Bump algolia/algoliasearch-client-php from 2.2.6 to 2.3.0
[#167](https://github.com/elvispt/zeteticelench/pull/167).
- Bump lodash from 4.17.11 to 4.17.13 (fixes a security vulnerability)
[#173](https://github.com/elvispt/zeteticelench/pull/173).

### 1.7.0 <2019-07-17>
- Notes are now searchable
[#165](https://github.com/elvispt/zeteticelench/issues/165).
- Bump laravel/framework from 5.8.28 to 5.8.29
[#164](https://github.com/elvispt/zeteticelench/pull/164).
- Bump phpunit/phpunit from 8.2.4 to 8.2.5
[#163](https://github.com/elvispt/zeteticelench/pull/163).

### 1.6.5 <2019-07-15>
- Add Laravel Envoy to automate deployment process
[#160](https://github.com/elvispt/zeteticelench/issues/160).
- Bump laravel/telescope from 2.0.5 to 2.0.6
[#161](https://github.com/elvispt/zeteticelench/pull/161).

### 1.6.4 <2019-07-14>
- List limit increased from 15 to 20.
- Extracted save/remove bookmark into a js module
[#157](https://github.com/elvispt/zeteticelench/issues/157).
- Fixed issue with bookmarking on mobile screens.
- Now using versioning/cache busting for frontend assets.
- Now using sentry.io on client side code.

### 1.6.3 <2019-07-13>
- Fix issue delete note dialog was visible on page load on unsupported browsers
[#156](https://github.com/elvispt/zeteticelench/issues/156).
- Fix issue with add/remove bookmark on story comments page
[#150](https://github.com/elvispt/zeteticelench/issues/150#issuecomment-511109941).
- Fix issue on story comments page where the text of the number of comments
clickable and sends the user to hacker news site to view comments there
[#153](https://github.com/elvispt/zeteticelench/issues/153#issuecomment-511110352).

### 1.6.2 <2019-07-11>
- The page title, when on story comments page, is now the title of the story
[#148](https://github.com/elvispt/zeteticelench/pull/148).
- We now ask for confirmation before deleting a note
[#149](https://github.com/elvispt/zeteticelench/pull/149).
- The text of the number of comments is now clickable and sends the user to
hacker news site to view comments there
[#153](https://github.com/elvispt/zeteticelench/pull/153).
- The list of notes, when filtered by tags, is now consistent with the list of
notes on the note list page
[#145](https://github.com/elvispt/zeteticelench/pull/145).
- We can now bookmark a new story item, on mobile, on the new Hacker news
stories page [#152](https://github.com/elvispt/zeteticelench/pull/152).
- Bookmarking a story is now made using Ajax requests, removing the need for
a page refresh [#150](https://github.com/elvispt/zeteticelench/pull/150).
- Fixed issue with an uncaught Guzzle exception
[#147](https://github.com/elvispt/zeteticelench/pull/147).
- Fixed with test suite failing due to issue with the Telescope package. More
information on issue [#154](https://github.com/elvispt/zeteticelench/pull/154).
- Add inputmode to some html fields so that when on mobile the correct keyboard
is brought up [#151](https://github.com/elvispt/zeteticelench/pull/151).

### 1.6.1 <2019-07-09>
- Change page title according to location
[#140](https://github.com/elvispt/zeteticelench/pull/140).
- Story details no longer clickable when on new Hacker News stories page
[#141](https://github.com/elvispt/zeteticelench/pull/141).
- Submenu now set on users management pages
[#143](https://github.com/elvispt/zeteticelench/pull/143).
- Added submenu on hacker news story details page.
- Card elements now have a shadow set.
[#142](https://github.com/elvispt/zeteticelench/pull/142).
- Fixed issue with Unsplash fallback.

### 1.6 <2019-07-08>
- Bump laravel/framework from 5.8.24 to 5.8.27
[#133](https://github.com/elvispt/zeteticelench/pull/133).
- Bump phpunit/phpunit from 8.2.3 to 8.2.4
[#135](https://github.com/elvispt/zeteticelench/pull/135).
- Bump sentry/sentry-laravel from 1.0.2 to 1.1.0
[#136](https://github.com/elvispt/zeteticelench/pull/136).
- Bump filp/whoops from 2.4.0 to 2.4.1
[#137](https://github.com/elvispt/zeteticelench/pull/137).

### 1.5.4 <2019-07-08>
- Fix issue with server connection failures
[#139](https://github.com/elvispt/zeteticelench/issues/139).
- Make user listing table responsive
[#138](https://github.com/elvispt/zeteticelench/issues/138).

### 1.5.3 <2019-07-02>
 - Fixed issue with view on login pages.

### 1.5.2 <2019-07-02>
- Added a page to show a note, converted from markdown to html.
- Notes now only contain a body and accept markdown.
  - Titles are extracted from the first line of the body.
- Notes section now as a submenu instead of the navbar dropdown.
  - Submenus now use 100% of horizontal space.
- Can now import and bookmark a hacker news story by it's id.

### 1.4 <2019-06-29>
- Show system information on dashboard.
- Advice slip will on also appear on dashboard.
  - On mobile, advice slip will not appear on top nav bar.
- Fix issue that occurred when network connection was down and could not
connect to Unsplash Api.

### 1.3.1 <2019-06-27>
- Reduce the number of elements when on xs-screens.
- Prune application logs automatically logs after 10 days.
- Story can now be bookmarked on the story detail page.
- Hightlight op's username on story details comment listing.

### 1.3 <2019-06-26>
- Top main menu will no longer have a dropdown but instead be moved to a
sub-menu that appears on the hacker new story pages with the the options
Top, Best, New, Bookmarked, Jobs.
- Added Hacker News new stories page.
- Background image, on dashboard, continues to be obtained from Unsplash API
but will now randomly use a word from pre-determined list to search for and
image.

### 1.2 <2019-06-24>
- Now able to bookmark a hacker news story, on a per user basis.

### 1.1 <2019-06-23>
- Updated Laravel framework to v5.8.24.
- Fixed issue with pagination object on xs screens.
- Added a site favicon.
- Added unit and feature tests. Coverage at around 73%.
- Reduced the number of request to import stories Job.

### 1.0
- Added user management.
- Added hacker news top listing.
- Added hacker news best listing.
- Added hacker news jobs listing.
- Added notes + tags.

All notable changes will be added here.
-------------------------------------------------------------------------------

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

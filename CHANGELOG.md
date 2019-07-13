All notable changes will be added here.
-------------------------------------------------------------------------------

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

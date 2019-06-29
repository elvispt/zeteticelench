All notable changes will be added here.
-------------------------------------------------------------------------------

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

(function () {
  const iconBookmarked = "⚫";
  const iconNotBookmarked = "⚪️";

  document.addEventListener('DOMContentLoaded', function () {
    $('.bookmark-story').on('click', function (event) {
      const el = $(this);
      const id = el.data('story-id');
      const isBookmarked = el.data('bookmarked');
      let url = urlAddBm();
      let data = {story_id: id};
      let icon = iconBookmarked;
      let bookmarked = true;

      event.preventDefault();
      if (isBookmarked) {
        url = urlDestroyBm();
        data = Object.assign({}, data, {_method: 'DELETE'});
        icon = iconNotBookmarked;
        bookmarked = false;
      }

      $.ajax({
        method: 'post',
        url,
        data,
      }).done(changeIcon(id, icon, bookmarked));
    });
  });

  const changeIcon = function (id, icon, isBookmarked) {

    return function () {
      updateNBookmarks(isBookmarked ? 1 : -1);
      $(`.bookmark-story[data-story-id="${id}"]`).each(function () {
        const innerEls = $(this);

        innerEls.text(icon);
        innerEls.data('bookmarked', isBookmarked);
      });
    };
  };

  function updateNBookmarks(nToAdd) {
    const $elNBookmarks = $('#bookmark-count');
    const currentNBookmarks = $elNBookmarks.text() * 1;

    $elNBookmarks.text(currentNBookmarks + nToAdd);
  }

  const urlDestroyBm = (function () {
    let _urlDestroyBm;

    return function () {
      if (!_urlDestroyBm) {
        _urlDestroyBm = $('meta[name="route-hackernews-bookmark-destroy"]').attr('content');
      }
      return _urlDestroyBm;
    };
  })();

  const urlAddBm = (function () {
    let _urlAddBm;

    return function () {
      if (!_urlAddBm) {
        _urlAddBm = $('meta[name="route-hackernews-bookmark-destroy"]').attr('content');
      }
      return _urlAddBm;
    };
  })();
})();

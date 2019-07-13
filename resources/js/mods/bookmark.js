(function () {
  const iconBookmarked = "⚫";
  const iconNotBookmarked = "⚪️";

  document.addEventListener('DOMContentLoaded', function () {
    $('.bookmark-story').on('click', function (event) {
      event.preventDefault();
      const el = $(this);
      const id = el.data('story-id');
      const isBookmarked = el.data('bookmarked');
      let url = urlAddBm();
      let data = {story_id: id};
      let done = function () {
        el.text(iconBookmarked);
        el.data('bookmarked', true);
      };

      if (isBookmarked) {
        url = urlDestroyBm();
        data = Object.assign({}, data, {_method: 'DELETE'});
        done = function () {
          el.text(iconNotBookmarked);
          el.data('bookmarked', false);
        };
      }

      $.ajax({
        method: 'post',
        url,
        data,
      }).done(done);
    });
  });

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

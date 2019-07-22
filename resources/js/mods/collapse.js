(function () {

  document.addEventListener('DOMContentLoaded', function () {
    $('.comment a[data-toggle="collapse"]').on('click', function (event) {
      const el = $(this);
      const commentId = el.data('item-id');
      const isCollapsed = el.hasClass('collapsed');
      let url = urlCollapse();
      let data = {commentId: commentId};

      event.preventDefault();
      if (isCollapsed) {
        data = Object.assign({}, data, {_method: 'DELETE'});
      }

      $.ajax({
        method: 'post',
        url,
        data,
      });
      el.closest('.card-body').toggleClass('opacity-5');
    });
  });

  const urlCollapse = (function () {
    let _url;

    return function () {
      if (!_url) {
        _url = $('meta[name="route-hackernews-item-comments-collapse"]')
          .attr('content');
      }
      return _url;
    };
  })();

})();

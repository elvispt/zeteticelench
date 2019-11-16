$(function () {
  $('._js--tags').on('click', function tagClick(event) {
    const tagId = $(this).data('id');
    const $form = $('#_js--movements-filters');

    $form.append(`<input type="hidden" name="tags[]" value="${tagId}">`);

    $form.submit();
  });
});

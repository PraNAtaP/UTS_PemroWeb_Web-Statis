$(document).ready(function () {
  $(".fade-in").animate({ opacity: 1 }, 600);

  $(".code-box").each(function (i) {
    $(this)
      .hide()
      .delay(200 * i)
      .fadeIn(500);
  });
});

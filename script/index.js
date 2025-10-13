$(document).ready(function () {
  $(".fade-in").each(function (i) {
    $(this)
      .delay(200 * i)
      .animate({ opacity: 1 }, 600);
  });
});

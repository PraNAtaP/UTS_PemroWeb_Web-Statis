$(document).ready(function () {
  $(".fade-in").each(function (i) {
    $(this)
      .delay(200 * i)
      .animate({ opacity: 1 }, 600);
  });

  $(".profile-avatar").hover(
    function () {
      $(this).css("transform", "scale(1.1)");
    },
    function () {
      $(this).css("transform", "scale(1)");
    }
  );
});

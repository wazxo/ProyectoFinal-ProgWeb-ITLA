document.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll(".libro-card").forEach(function (card) {
    card.addEventListener("click", function () {
      var link = this.getAttribute("data-link");
      if (link) {
        window.location.href = link;
      }
    });
  });
});

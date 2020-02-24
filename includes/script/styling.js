document.addEventListener(
  "DOMContentLoaded",
  () => {
    const element = document.getElementsByTagName("main");
    const height = element.offsetHeight;
    if (height < screen.height) {
      document.getElementById("footer").classList.add("stickyfoot");
    }
  },
  false
);

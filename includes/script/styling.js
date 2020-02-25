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

window.onload = () => {
  const loginForm = document.getElementById("login");
  loginForm.addEventListener("click", ev => {
    ev.preventDefault();
  });
};

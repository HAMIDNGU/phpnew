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
  const liArray = document.getElementsByTagName("li");
  const signInLi = liArray[1];

  const removeSignIn = () => {
    if (getCookie("u") !== "") {
      signInLi.style.display = "none";
    } else {
      signInLi.style.display = "flex";
    }
  };

  removeSignIn();
  disableIfNotLoggedIn();
};

const disableIfNotLoggedIn = () => {
  const imgSubBtn = document.getElementById("imgSubmit");

  if (imgSubBtn && getCookie("u") !== "") {
    imgSubBtn.disabled = false;
  } else if (imgSubBtn) {
    imgSubBtn.disabled = true;
  }
};

// https://www.w3schools.com/js/js_cookies.asp
const getCookie = cname => {
  const name = cname + "=";
  const decodedCookie = decodeURIComponent(document.cookie);
  const ca = decodedCookie.split(";");
  for (let i = 0; i < ca.length; i++) {
    let c = ca[i];
    while (c.charAt(0) == " ") {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
};

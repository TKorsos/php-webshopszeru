// tooltip
const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

// password megjelenítése, elrejtése, dátum
// #passwordLog és #passBtn helyett .password-log-js és .pass-btn-js elhelyezve modalba
let passInput = document.querySelector('.js-password-log');
let passBtn = document.querySelector('.js-password-btn');
let dateDayArea = document.querySelector('#date-js');
const dayOfWeek = ["vasárnap", "hétfő", "kedd", "szerda", "csütörtök", "péntek", "szombat"];
const monthOfYear = ["január", "február", "március", "június", "július", "augusztus", "szeptember", "október", "november", "december"];

function hideShowPass() {
    if (passInput.getAttribute("type") === "password") {
        passInput.setAttribute("type", "text");
        passBtn.innerHTML = `<i class="bi bi-eye-slash">`;
    }
    else {
        passInput.setAttribute("type", "password");
        passBtn.innerHTML = `<i class="bi bi-eye">`;
    }
}

function dateDay() {
  let date = new Date();
  dateDayArea.innerHTML =  `${dayOfWeek[date.getDay()]}, ${date.getFullYear()}. ${monthOfYear[date.getMonth()]} ${date.getDate()}.`;
  return dateDayArea;
}

function render() {
  passBtn.addEventListener("click", hideShowPass);
  dateDay();
}

render();
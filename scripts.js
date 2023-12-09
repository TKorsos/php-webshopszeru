// tooltip
const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

let passInput = document.querySelector('#passwordLog');
let passBtn = document.querySelector('#passBtn');

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

passBtn.addEventListener("click", hideShowPass);
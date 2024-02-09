const theme = localStorage.getItem("theme")
const loginContainer = document.querySelector(".login-container")
const toggleColorModeBtn = document.querySelector(".toggle-color-mode-btn")

toggleColorModeBtn.addEventListener("click", (e) => {
    if(loginContainer.classList.contains("dark")) {
        loginContainer.classList.remove("dark")
        localStorage.setItem("theme", "white")
    } else {
        loginContainer.classList.add("dark")
        localStorage.setItem("theme", "dark")
    }
})


if (theme == "white") {
    if(loginContainer.classList.contains("dark")) {
        loginContainer.classList.remove("dark")
    }
}

if (theme == "dark") {
    if(!loginContainer.classList.contains("dark")) {
        loginContainer.classList.add("dark")
    }
}
const theme = localStorage.getItem("theme")
const toggleColorModeBtn = document.querySelector(".toggle-color-mode-btn")
const bodyElement = document.querySelector("body")

if (theme == "white") {
    if(bodyElement.classList.contains("dark")) {
        bodyElement.classList.remove("dark")
    }
}

if (theme == "dark") {
    if(!bodyElement.classList.contains("dark")) {
        bodyElement.classList.add("dark")
    }
}

toggleColorModeBtn.addEventListener("click", (e) => {
    if(bodyElement.classList.contains("dark")) {
        bodyElement.classList.remove("dark")
        localStorage.setItem("theme", "white")
    } else {
        bodyElement.classList.add("dark")
        localStorage.setItem("theme", "dark")
    }
})
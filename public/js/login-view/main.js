const theme = localStorage.getItem("theme")
const loginContainer = document.querySelector(".login-container")

console.log(loginContainer)

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
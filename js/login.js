var togglesenha = document.getElementById("togglesenha");
var toggleconfsenha = document.getElementById("toggleconfsenha");

document.getElementById("togglesenha").addEventListener("click", function() {
    var senha = document.getElementById("senha");
    var type = senha.getAttribute("type") === "password" ? "text" : "password";
    senha.setAttribute("type", type);
})

document.getElementById("toggleconfsenha").addEventListener("click", function() {
    var senha = document.getElementById("confsenha");
    var type = senha.getAttribute("type") === "password" ? "text" : "password";
    senha.setAttribute("type", type);
})

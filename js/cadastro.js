function validacao() {
    var senha = document.getElementById("senha").value;
    var confsenha = document.getElementById("confsenha").value;
    
    if (senha !== confsenha) {
            alert("As senhas estão diferentes")
            return false
    }
    else if (confirm("Deseja prosseguir?")) {
            return true
    }
    else { 
        return false
    }
}

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
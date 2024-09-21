function validarSenha() {
	let senha = document.getElementById("senha").value;
	let senhaConf = document.getElementById("confsenha").value;
    
	if (senha === senhaConf)
		return true;

	alert("As senhas estão diferentes");
	return false;
}

function mudarVisibilidade(id) {
	let campo = document.getElementById(id);
	let typeAtual = campo.getAttribute("type");
    	campo.setAttribute("type", (typeAtual === "password" ? "text" : "password"));
}

document.getElementById("togglesenha").addEventListener("click", () => mudarVisibilidade("senha"));
document.getElementById("toggleconfsenha").addEventListener("click", () => mudarVisibilidade("confsenha"));

function mudarVisibilidade(id) {
	let campo = document.getElementById(id);
	let typeAtual = campo.getAttribute("type");
    	campo.setAttribute("type", (typeAtual === "password" ? "text" : "password"));
}

document.getElementById("togglesenha").addEventListener("click", () => mudarVisibilidade("senha"));
document.getElementById("toggleconfsenha").addEventListener("click", () => mudarVisibilidade("confsenha"));

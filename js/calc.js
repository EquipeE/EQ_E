/*
Código extremamente mal-feito e nojento abaixo, aprimorá-lo-ei
posteriormente. Por enquanto, aprecie este belo dragão chinês:
			      ______________                               
                        ,===:'.,            `-._                           
                             `:.`---.__         `-._                       
                              `:.     `--.         `.                     
                                 \.        `.         `.                   
                         (,,(,    \.         `.   ____,-`.,                
                      (,'     `/   \.   ,--.___`.'                         
                  ,  ,'  ,--.  `,   \.;'         `                         
                   `{D, {    \  :    \;                                    
                     V,,'    /  /    //                                    
                     j;;    /  ,' ,-//.    ,---.      ,                    
                     \;'   /  ,' /  _  \  /  _  \   ,'/                    
                           \   `'  / \  `'  / \  `.' /                     
                            `.___,'   `.__,'   `.__,'

*/
const addBtn = document.getElementById('addBtn');
const delBtn = document.getElementById('delBtn');
const trashBtn = document.getElementById('trashBtn');
const aparelhosTbl = document.getElementById('aparelhos-tbl');
const semBateriaCheckbox = document.getElementById('negativo');
const bateriaLabel = document.getElementById('autonomia');
const autonomiaCampo = document.getElementById('positivo');
const ativarAparelhosCheckbox = document.getElementById('ativar-aparelhos');
const valoresPadraoCheckbox = document.getElementById('valores-padrao');
const consumoLabel = document.getElementById('consumo-label');
const consumoCampo = document.getElementById('consumo');
const aparelhosTitulo = document.getElementById('aparelhos-titulo');
const valoresPadraoLabel= document.getElementById('valores-padrao-lbl');
const aparelhosWrapper = document.getElementById('aparelhos-wrapper');

const aparelhosTodos = [
    'Aparelho de som',
    'Ventilador',
    'Aquecedor de ambiente',
    'Máquina de lavar louça',
    'Aspirador de pó',
    'Forno elétrico',
    'Aquecedor central de água',
    'Impressora laser',
    'Balcão frigorífico',
    'Televisão',
    'Batedeira',
    'Forno de micro-ondas',
    'Boiler',
    'Refrigerador Duplex',
    'Cafeteira',
    'Freezer',
    'Computador',
    'Secadora de roupa',
    'Condicionador de ar',
    'Chuveiro elétrico',
    'Fritadeira',
    'Enceradeira',
    'Liquidificador',
    'Exaustor',
    'Ferro elétrico tradicional',
    'Torneira elétrica',
    'Ferro elétrico regulável',
    'Grill',
    'Secador de cabelo',
    'Impressora jato de tinta',
    'Máquina de lavar roupa',
    'Outro'
]
const potenciaTodos = [
    200,
    100,
    1500,
    2700,
    1000,
    5000,
    5000,
    400,
    900,
    200,
    450,
    1300,
    900,
    350,
    300,
    150,
    350,
    3500,
    1600,
    5000,
    1200,
    350,
    400,
    300,
    750,
    3500,
    1500,
    1200,
    1300,
    50,
    1500,
    0
]
let valoresPadrao = false;

ativarAparelhosCheckbox.addEventListener('change', e => {
	if (e.target.checked) {
		consumoLabel.style.display = 'none';
		consumoCampo.required = false;
		consumoCampo.value = '';
		consumoCampo.style.display = 'none';
		aparelhosTitulo.style.display = 'block';
		valoresPadraoCheckbox.style.display = 'inline';
		valoresPadraoLabel.style.display = 'inline';
		aparelhosWrapper.style.display = 'flex';
	} else {
		consumoLabel.style.display = 'block';
		consumoCampo.required = true;
		consumoCampo.style.display = 'block';
		aparelhosTitulo.style.display = 'none';
		valoresPadraoCheckbox.style.display = 'none';
		valoresPadraoLabel.style.display = 'none';
		aparelhosWrapper.style.display = 'none';
		aparelhosTbl.innerHTML = '<div class=\'aparelhos-row\'><p>Aparelho</p><p>Potência em Watts</p></div>';
	}

});
valoresPadraoCheckbox.addEventListener('change', e => { valoresPadrao = e.target.checked; });
addBtn.addEventListener('click', () => {
	let nome;
	let potencia;
	let row;

	linha = document.createElement('div');
	linha.classList.add('aparelhos-row');

	nome = document.createElement('select');
	nome.setAttribute('name', 'aparelho[]');
	aparelhosTodos.forEach((e, i) => {
		opt = document.createElement('option');
		opt.setAttribute('value', e);
		opt.textContent = e;
		nome.appendChild(opt);
	});

	linha.appendChild(nome);

	if (valoresPadrao) {
		nome.addEventListener('change', e => {
			let pai = e.target.parentElement;
			let potenciaOld;
			let potenciaNew;

			for (let c of pai.children)
				if (c.getAttribute('type') === 'number')
					potenciaOld = c;

			potenciaNew = document.createElement('input');
			potenciaNew.setAttribute('type', 'number');
			potenciaNew.setAttribute('name', 'potencia[]');
			potenciaNew.setAttribute('value', potenciaTodos[aparelhosTodos.indexOf(e.target.value)]);
			potenciaNew.readOnly = true;

			if (potenciaOld)
				pai.replaceChild(potenciaNew, potenciaOld);
			else
				pai.appendChild(potenciaNew);
		});
		const e = new Event('change');
		nome.dispatchEvent(e);
	} else {
		potencia = document.createElement('input');
		potencia.setAttribute('type', 'number');
		potencia.setAttribute('placeholder', 'Potência');
		potencia.setAttribute('min', '1');
		potencia.setAttribute('name', 'potencia[]');
		potencia.setAttribute('title', 'Potência do aparelho');
		potencia.required = true;
		linha.appendChild(potencia);
	}

	linha.addEventListener('click', e => {
		if(e.target !== e.currentTarget)
			return;
		e.target.classList.toggle('selected');
	});
	aparelhosTbl.appendChild(linha);
});
delBtn.addEventListener('click', () => {
	document.querySelectorAll('.selected').forEach(e => { e.remove() });
});
trashBtn.addEventListener('click', () => {
	aparelhosTbl.innerHTML = '<div class=\'aparelhos-row\'><p>Aparelho</p><p>Potência em Watts</p></div>';
});
semBateriaCheckbox.addEventListener('change', e => {
	if (e.target.checked) {
		bateriaLabel.style.display = 'none';
		autonomiaCampo.required = false;
		autonomiaCampo.style.display = 'none';
	} else {
		bateriaLabel.style.display = 'block';
		autonomiaCampo.required = true;
		autonomiaCampo.style.display = 'block';
	}
});

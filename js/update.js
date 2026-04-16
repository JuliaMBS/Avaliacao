const form        = document.getElementById('form');
const cardForm    = document.getElementById('card-form');
const cardSucesso = document.getElementById('card-sucesso');
const mensagemEl  = document.getElementById('mensagem');
const contador    = document.getElementById('contador');
const btnVoltar   = document.getElementById('btn-voltar');

// contador
mensagemEl.addEventListener('input', () => {
  contador.textContent = mensagemEl.value.length + '/250';
});

// erro visual
function setErro(id, msg) {
  const campo = document.getElementById('campo-' + id);
  const erro  = document.getElementById('erro-' + id);

  campo.classList.remove('invalido', 'valido');

  if (msg) {
    campo.classList.add('invalido');
    erro.textContent = msg;
  } else {
    erro.textContent = '';
  }
}

// validação
function validar() {
  let ok = true;

  const nome     = nomeEl.value.trim();
  const email    = emailEl.value.trim();
  const senha    = senhaEl.value;
  const mensagem = mensagemEl.value.trim();

  if (!nome) { setErro('nome','Obrigatório'); ok=false; } else setErro('nome','');

  if (!email) { setErro('email','Obrigatório'); ok=false; } else setErro('email','');

  if (senha && senha.length < 6) {
    setErro('senha','Mínimo 6 caracteres'); ok=false;
  } else setErro('senha','');

  if (!mensagem) { setErro('mensagem','Obrigatório'); ok=false; } else setErro('mensagem','');

  return ok;
}

// campos
const nomeEl  = document.getElementById('nome');
const emailEl = document.getElementById('email');
const senhaEl = document.getElementById('senha');

// submit update
form.addEventListener('submit', async (e) => {
  e.preventDefault();

  if (!validar()) return;

  const dados = new FormData(form);

  const res = await fetch('php/update.php', {
    method: 'POST',
    body: dados
  });

  const json = await res.json();

  if (json.success) {
    document.getElementById('res-nome').textContent     = nomeEl.value;
    document.getElementById('res-email').textContent    = emailEl.value;
    document.getElementById('res-mensagem').textContent = mensagemEl.value;

    cardForm.style.display = 'none';
    cardSucesso.style.display = 'block';
  } else {
    alert(json.message);
  }
});

// voltar
btnVoltar.addEventListener('click', () => {
  cardSucesso.style.display = 'none';
  cardForm.style.display = 'block';
});

// carregar por email
async function carregarDados() {
  const params = new URLSearchParams(window.location.search);
  const email = params.get('email');

  if (!email) return;

  const res = await fetch('php/get.php?email=' + encodeURIComponent(email));
  const json = await res.json();

  if (json.success) {
    document.getElementById('id').value        = json.data.id;
    nomeEl.value                                = json.data.nome;
    emailEl.value                               = json.data.email;
    mensagemEl.value                            = json.data.mensagem;

    contador.textContent = mensagemEl.value.length + '/250';
  }
}

carregarDados();

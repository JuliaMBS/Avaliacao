const form        = document.getElementById('form');
const cardForm    = document.getElementById('card-form');
const cardSucesso = document.getElementById('card-sucesso');
const mensagemEl  = document.getElementById('mensagem');
const contador    = document.getElementById('contador');

mensagemEl.addEventListener('input', () => {
  contador.textContent = mensagemEl.value.length + '/250';
});

function setErro(id, msg) {
  document.getElementById('campo-' + id)?.classList[msg ? 'add' : 'remove']('invalido');
  document.getElementById('erro-' + id).textContent = msg;
}


function validar() {
  const nome     = document.getElementById('nome').value.trim();
  const email    = document.getElementById('email').value.trim();
  const senha    = document.getElementById('senha').value;
  const mensagem = mensagemEl.value.trim();
  let ok = true;


  if (!nome) {
    setErro('nome', 'O nome é obrigatório.'); ok = false;
  } else if (!/^[A-Za-zÀ-ÿ\s]+$/.test(nome)) {
    setErro('nome', 'O nome deve conter apenas letras.'); ok = false;
  } else setErro('nome', '');


  if (!email) {
    setErro('email', 'O e-mail é obrigatório.'); ok = false;
  } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
    setErro('email', 'Informe um e-mail válido (ex: usuario@dominio.com).'); ok = false;
  } else setErro('email', '');

  if (!senha) {
    setErro('senha', 'A senha é obrigatória.'); ok = false;
  } else if (senha.length < 6) {
    setErro('senha', 'A senha deve ter pelo menos 6 caracteres.'); ok = false;
  } else setErro('senha', '');

  if (!mensagem) {
    setErro('mensagem', 'A mensagem é obrigatória.'); ok = false;
  } else if (mensagem.length > 250) {
    setErro('mensagem', 'A mensagem não pode ter mais de 250 caracteres.'); ok = false;
  } else setErro('mensagem', '');

  return ok;
}


form.addEventListener('submit', async (e) => {
  e.preventDefault();
  if (!validar()) return;

  const dados = new FormData(form);

  try {
    const res  = await fetch('submit.php', { method: 'POST', body: dados });
    const json = await res.json();

    if (json.success) {
      document.getElementById('res-nome').textContent     = dados.get('nome');
      document.getElementById('res-email').textContent    = dados.get('email');
      document.getElementById('res-mensagem').textContent = dados.get('mensagem');
      cardForm.style.display    = 'none';
      cardSucesso.style.display = 'block';
    } else {
      alert('Erro: ' + json.message);
    }
  } catch {
    alert('Erro de conexão com o servidor.');
  }
});

document.getElementById('btn-novo').addEventListener('click', () => {
  form.reset();
  contador.textContent = '0/250';
  ['nome','email','senha','mensagem'].forEach(id => setErro(id, ''));
  cardSucesso.style.display = 'none';
  cardForm.style.display    = 'block';
});
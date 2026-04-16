 let modoAtivo = 'email';

    function setTab(modo, btn) {
      modoAtivo = modo;
      document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
      btn.classList.add('active');
      document.getElementById('tab-email').style.display = modo === 'email' ? '' : 'none';
      document.getElementById('tab-id').style.display   = modo === 'id'    ? '' : 'none';
      esconderFeedback();
    }

    function esconderFeedback() {
      const f = document.getElementById('feedback');
      f.className = 'feedback';
      f.textContent = '';
    }

    function pedirConfirmacao() {
      esconderFeedback();
      const val = modoAtivo === 'email'
        ? document.getElementById('inp-email').value.trim()
        : document.getElementById('inp-id').value.trim();

      if (!val) {
        mostrarFeedback(false, modoAtivo === 'email' ? 'Informe um e-mail.' : 'Informe um ID.');
        return;
      }
      if (modoAtivo === 'email' && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val)) {
        mostrarFeedback(false, 'E-mail inválido.');
        return;
      }

      document.getElementById('confirm-msg').textContent =
        `Tem certeza que deseja deletar o usuário ${modoAtivo === 'email' ? val : '#' + val}? Esta ação não pode ser desfeita.`;

      document.getElementById('main-form').style.display = 'none';
      document.getElementById('confirm-overlay').classList.add('show');
    }

    function fecharConfirm() {
      document.getElementById('confirm-overlay').classList.remove('show');
      document.getElementById('main-form').style.display = '';
    }

    async function executarDelete() {
      fecharConfirm();

      const body = new URLSearchParams();
      if (modoAtivo === 'email') {
        body.append('email', document.getElementById('inp-email').value.trim());
      } else {
        body.append('id', document.getElementById('inp-id').value.trim());
      }

      try {
        const res  = await fetch('delete.php', { method: 'POST', body });
        const data = await res.json();
        mostrarFeedback(data.success, data.message);
        if (data.success) {
          document.getElementById('inp-email').value = '';
          document.getElementById('inp-id').value    = '';
        }
      } catch (e) {
        mostrarFeedback(false, 'Erro ao conectar com o servidor.');
      }
    }

    function mostrarFeedback(ok, msg) {
      const f = document.getElementById('feedback');
      f.className  = 'feedback ' + (ok ? 'ok' : 'err');
      f.textContent = msg;
    }
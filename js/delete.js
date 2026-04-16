let modo = "email";

// trocar abas
function setTab(tipo, el) {
    modo = tipo;

    document.getElementById("tab-email").style.display = tipo === "email" ? "block" : "none";
    document.getElementById("tab-id").style.display = tipo === "id" ? "block" : "none";

    document.querySelectorAll(".tab").forEach(btn => btn.classList.remove("active"));
    el.classList.add("active");
}

// abrir confirmação
function pedirConfirmacao() {
    document.getElementById("confirm-overlay").style.display = "flex";
}

// fechar confirmação
function fecharConfirm() {
    document.getElementById("confirm-overlay").style.display = "none";
}

// executar delete
async function executarDelete() {
    const email = document.getElementById("inp-email").value.trim();
    const id = document.getElementById("inp-id").value.trim();

    let dados = {};

    if (modo === "email") {
        if (!email) {
            mostrarFeedback("Digite um e-mail.");
            return;
        }
        dados.email = email;
    } else {
        if (!id) {
            mostrarFeedback("Digite um ID.");
            return;
        }
        dados.id = id;
    }

    try {
        const response = await fetch("php/delete.php", {
            method: "POST",
            body: new URLSearchParams(dados)
        });

        const text = await response.text();
        console.log(text); // 🔥 mostra erro real

        const data = JSON.parse(text);

        mostrarFeedback(data.message);

        if (data.success) {
            fecharConfirm();
            document.getElementById("inp-email").value = "";
            document.getElementById("inp-id").value = "";
        }

    } catch (error) {
        console.error(error);
        mostrarFeedback("Erro ao conectar ao servidor");
    }
}

// feedback na tela
function mostrarFeedback(msg) {
    document.getElementById("feedback").innerText = msg;
}

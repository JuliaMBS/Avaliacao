const form = document.getElementById("form");

// PEGAR ID DA URL
const params = new URLSearchParams(window.location.search);
const idParam = params.get("id");

// CARREGAR DADOS
if (idParam) {
    fetch(`php/get.php?id=${idParam}`)
        .then(res => res.json())
        .then(data => {
            if (!data.success) {
                alert(data.message);
                return;
            }

            const user = data.data;

            document.getElementById("id").value = user.id;
            document.getElementById("nome").value = user.nome;
            document.getElementById("email").value = user.email;
            document.getElementById("mensagem").value = user.mensagem;
        });
} else {
    alert("ID não informado na URL");
}

// UPDATE
form.addEventListener("submit", async (e) => {
    e.preventDefault();

    const id = document.getElementById("id").value;
    const nome = document.getElementById("nome").value;
    const email = document.getElementById("email").value;
    const senha = document.getElementById("senha").value;
    const mensagem = document.getElementById("mensagem").value;

    try {
        const response = await fetch("php/update.php", {
            method: "POST",
            body: new URLSearchParams({
                id,
                nome,
                email,
                senha,
                mensagem
            })
        });

        const data = await response.json();

        if (!data.success) {
            alert(data.message);
            return;
        }

        document.getElementById("card-form").style.display = "none";
        document.getElementById("card-sucesso").style.display = "block";

        document.getElementById("res-nome").innerText = nome;
        document.getElementById("res-email").innerText = email;
        document.getElementById("res-mensagem").innerText = mensagem;

    } catch (error) {
        console.error(error);
        alert("Erro ao atualizar");
    }
});

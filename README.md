# 📋 Cadastro PHP + MySQL

Aplicação web de cadastro de usuários desenvolvida com HTML, CSS, JavaScript e PHP, com armazenamento em banco de dados MySQL. O projeto foi criado com fins educacionais para demonstrar o fluxo completo de uma aplicação web: captura de dados no front-end, validação, envio para o back-end e armazenamento em banco de dados.

---

## 📁 Arquivos do projeto

| Arquivo | Descrição |
|--------|-----------|
| `index.html` | Página principal com o formulário |
| `style.css` | Estilização da página |
| `script.js` | Validações e comportamento do formulário |
| `submit.php` | Recebe os dados e salva no banco MySQL |
| `setup.sql` | Cria o banco de dados e a tabela |

---

## ▶️ Como usar a aplicação

### 1. Acessando a página

Abra o navegador e acesse:
```
http://localhost/cadastro-php/index.html
```

---

### 2. Preenchendo o formulário

Preencha todos os campos obrigatórios:

- **Nome** — Digite seu nome completo. Somente letras e espaços são permitidos. Números e caracteres especiais serão rejeitados.

- **E-mail** — Digite um endereço de e-mail válido no formato `usuario@dominio.com`. O sistema verifica se o formato está correto antes de enviar.

- **Senha** — Escolha uma senha com no mínimo 6 caracteres. Ela será armazenada de forma segura (criptografada) no banco de dados.

- **Mensagem** — Escreva uma mensagem de até 250 caracteres. Um contador ao lado do campo mostra quantos caracteres já foram digitados.

---

### 3. Enviando o formulário

Clique no botão **Cadastrar** para enviar os dados.

- Se algum campo estiver incorreto ou vazio, uma mensagem de erro vermelha aparecerá logo abaixo do campo indicando exatamente o que precisa ser corrigido.
- Corrija os campos apontados e tente enviar novamente.

---

### 4. Após o cadastro

Se todos os dados estiverem corretos e o cadastro for realizado com sucesso:

- Uma mensagem de confirmação será exibida na tela: **"Cadastro realizado com sucesso!"**
- Logo abaixo, os dados que foram cadastrados (nome, e-mail e mensagem) serão exibidos para conferência.

---

### 5. Realizando um novo cadastro

Para cadastrar outro usuário, clique no botão **+ Novo cadastro**. O formulário será limpo automaticamente e estará pronto para um novo preenchimento.

---

## ⚠️ Regras de validação

| Campo | Regra |
|-------|-------|
| Nome | Somente letras e espaços. Nenhum número ou símbolo é permitido. |
| E-mail | Deve seguir o formato `usuario@dominio.com` e ser único no banco. |
| Senha | Mínimo de 6 caracteres. |
| Mensagem | Obrigatória. Máximo de 250 caracteres. |

---

## ❌ Mensagens de erro mais comuns

- **"O nome deve conter apenas letras"** — Você digitou um número ou símbolo no campo nome.
- **"Informe um e-mail válido"** — O e-mail digitado não está no formato correto.
- **"A senha deve ter pelo menos 6 caracteres"** — Sua senha está muito curta.
- **"A mensagem não pode ter mais de 250 caracteres"** — Reduza o texto da mensagem.
- **"E-mail já cadastrado"** — Esse e-mail já existe no banco de dados. Use outro e-mail.
- **"Erro de conexão com o servidor"** — O Apache ou MySQL do XAMPP pode estar desligado. Verifique o painel do XAMPP.

---

## 🛠️ Requisitos para rodar o projeto

- [XAMPP](https://www.apachefriends.org/) instalado com **Apache** e **MySQL** em execução
- Navegador web (Chrome, Firefox, Edge etc.)
- Arquivos do projeto dentro da pasta `htdocs` do XAMPP

---

## 👨‍💻 Tecnologias utilizadas

- **HTML5** — estrutura da página
- **CSS3** — estilização
- **JavaScript** — validação no front-end e comportamento dinâmico
- **PHP** — processamento e validação no back-end
- **MySQL** — banco de dados
- **PDO** — conexão segura com o banco (proteção contra SQL Injection)

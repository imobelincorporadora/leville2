const WEBHOOK_URL_DARK =
  "https://www.levilleresidence.com.br/actions/form2.php";

const formDark = document.getElementById("contact-form-dark");
const formMessageDark = document.getElementById("form-message-dark");

async function handleSubmitDark(event) {
  event.preventDefault();

  formMessageDark.textContent = "Enviando...";
  formMessageDark.className = "loading";

  const formData = new FormData(formDark);

  const data = {};
  formData.forEach((value, key) => {
    data[key] = value;
  });

  try {
    const response = await fetch(WEBHOOK_URL_DARK, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(data),
    });

    let result = {};
    try {
      result = await response.json();
    } catch (err) {
      console.warn("Resposta não é JSON:", err);
    }

    if (response.ok && result.success) {
      formMessageDark.textContent =
        result.message || "Cadastro realizado com sucesso!";
      window.location.href =
        "https://levilleresidence.com.br/formulario_enviado";
      formMessageDark.className = "success";
      formDark.reset();
    } else {
      formMessageDark.textContent =
        result.error || `Erro no servidor (${response.status})`;
      formMessageDark.className = "error";
    }
  } catch (error) {
    console.error("Falha no envio:", error);
    formMessageDark.textContent = "Erro ao enviar. Verifique a conexão.";
    formMessageDark.className = "error";
  }
}

formDark.addEventListener("submit", handleSubmitDark);

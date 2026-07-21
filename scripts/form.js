const WEBHOOK_URL = "https://www.levilleresidence.com.br/actions/form1.php";

const form = document.getElementById("contact-form");
const formMessage = document.getElementById("form-message");

async function handleSubmit(event) {
  event.preventDefault();

  formMessage.textContent = "Enviando...";
  formMessage.className = "loading";

  const formData = new FormData(form);
  const data = {};

  formData.forEach((value, key) => {
    data[key] = value;
  });

  try {
    const response = await fetch(WEBHOOK_URL, {
      method: "POST",
      headers: {
        "Content-Type": "application/json; charset=UTF-8",
      },
      body: JSON.stringify(data),
    });

    const result = await response.json();

    if (response.ok && result.success) {
      formMessage.textContent = result.message;
      formMessage.className = "success";
      form.reset();

      window.location.href =
        "https://levilleresidence.com.br/formulario_enviado";
    } else {
      formMessage.textContent =
        result.error || `Erro no servidor (${response.status})`;
      formMessage.className = "error";
    }
  } catch (error) {
    console.error("Falha no envio:", error);
    formMessage.textContent =
      "Erro ao enviar. Verifique sua conexão ou configuração do servidor.";
    formMessage.className = "error";
  }
}

form.addEventListener("submit", handleSubmit);

// ===========================
// LEGENDAS DE IMAGEM
// ===========================
document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll("#img_ilustrativa").forEach((img) => {
    const wrapper = document.createElement("div");
    wrapper.classList.add("img-wrapper");

    img.parentNode.insertBefore(wrapper, img);
    wrapper.appendChild(img);

    const label = document.createElement("span");
    label.classList.add("img-ilustrativa");
    label.innerText = "Imagem meramente ilustrativa";
    wrapper.appendChild(label);
  });
});
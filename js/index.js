// Animação 
document.addEventListener('DOMContentLoaded', () => {
    document.body.style.opacity = 0;
    requestAnimationFrame(() => {
        document.body.style.transition = 'opacity 1s ease-in-out';
        document.body.style.opacity = 1;
    });
});

// Tipo do Profissional
function toggleTipoProfissional() {
    var tipoConta = document.getElementById("tipo_conta").value;
    var tipoProfissionalField = document.getElementById("tipo_profissional_field");
    tipoProfissionalField.style.display = (tipoConta === "profissional") ? "block" : "none";
}
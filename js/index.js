function toggleTipoProfissional() {
    var tipoConta = document.getElementById("tipo_conta").value;
    var tipoProfissionalField = document.getElementById("tipo_profissional_field");
    tipoProfissionalField.style.display = (tipoConta === "profissional") ? "block" : "none";
}
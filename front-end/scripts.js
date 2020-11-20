/* ---------- INITIAL FUNCTIONS ---------- */

// Check if user is logged on the system
console.log(localStorage.getItem("is_logged"));
if (localStorage.getItem("is_logged") == 1)
    showAccountManagement();
else {
    localStorage.setItem("is_logged", 0);
    showLogin();
}

document
  .getElementById("login-form")
  .addEventListener("submit", function(e) {
    e.preventDefault();
    window.location.href = "index.html";
  });

// Change header to show login button
function showLogin() {
    if (document.getElementById('login-header') != null)
        document.getElementById('login-header').style.display = "flex";
    if (document.getElementById('acc-header') != null) 
        document.getElementById('acc-header').style.display = "none";
    console.log("not logged");
}

// Change header to show account button and change account path
function showAccountManagement() {
    console.log(window.location.href);
    if (window.location.pathname == "login.html"){
        document.location.replace("index.html");
        return;
    }
    document.getElementById('acc-header').style.display = "flex";
    document.getElementById('login-header').style.display = "none";
    console.log("is logged");
    goToAccount();
}

// Change account path depending on user type
function goToAccount() {
    if (localStorage.getItem("user_type") == "admin"){
        document.getElementById('acc-ref').href = "acc-management-admin.html";
    }
    else if (localStorage.getItem("user_type") == "patient"){
        document.getElementById('acc-ref').href = "acc-management-patient.html";
    }
    else if (localStorage.getItem("user_type") == "doctor"){
        document.getElementById('acc-ref').href = "acc-management-doctor.html";
    }
    else if (localStorage.getItem("user_type") == "lab"){
        document.getElementById('acc-ref').href = "acc-management-lab.html";
    }
    else {
        document.getElementById('acc-ref').href = "#";
        console.log("Page doesnt exist");
    }
 }

/* ---------- LOGIN FUNCTIONS ---------- */

function makeLogin(){
    console.log(document.location);
    localStorage.setItem("is_logged", 1);
    localStorage.setItem("user_type", "admin");
    window.location.href = "index.html"; 
 }

 function logoutAccount(){
     localStorage.setItem("is_logged", 0);
     localStorage.setItem("user_type", "none");
 }

 /* ---------- ACCOUNT PAGE FUNCTIONS ---------- */

 function loadTab(tab){
    if (tab == 'config acc') {
        document.getElementById('config-acc-tab').style.display = "flex";
        document.getElementById('register-user-tab').style.display = "none";
        document.getElementById('change-user-tab').style.display = "none";
    }
    else if (tab == 'register user') {
        document.getElementById('register-user-tab').style.display = "flex";
        document.getElementById('config-acc-tab').style.display = "none";
        document.getElementById('change-user-tab').style.display = "none";
    }
    else if (tab == 'change user') {
        document.getElementById('change-user-tab').style.display = "flex";
        document.getElementById('config-acc-tab').style.display = "none";
        document.getElementById('register-user-tab').style.display = "none";
    }
 }

/* ---------- REGISTER FORM FUNCTIONS ---------- */

// Change user type entrys depending on radio input
function changeTypeUserForm() { 
    if (document.getElementById('patient-check').checked) {
        document.getElementById('patient-form').style.display = "flex";
        document.getElementById('doctor-form').style.display = "none";
        document.getElementById('lab-form').style.display = "none";
    }
    else if (document.getElementById('doctor-check').checked) {
        document.getElementById('doctor-form').style.display = "flex";
        document.getElementById('patient-form').style.display = "none";
        document.getElementById('lab-form').style.display = "none";
    }
    else if (document.getElementById('lab-check').checked) {
        document.getElementById('lab-form').style.display = "flex";
        document.getElementById('patient-form').style.display = "none";
        document.getElementById('doctor-form').style.display = "none";
    }
 }

 function validateEmail(email) {
    exp_reg = /\S+@\S+\.\S+/;
    return exp_reg.test(email);
}

function validateCPF(numero) {
    var soma;
    var resto;
    soma = 0;
    if (/^(\d)\1*$/.test(numero) == true || numero.length != 11) { //testa se todos os digitos sao iguais
        return false;
    } 
    else {
        for (x = 1; x < 9; x++)
            soma = soma + parseInt(numero.substring(x - 1, x), 10) * (11 - i)
        resto = (soma * 10) % 11;
        //verificando primeiro digito
        if (resto != parseInt(numero.substring(9, 10))) { //primeiro digito verificador
            alert("O cpf inserido é invalido!!!");
            return false;
        }
        else {
            for (d = 1; d <= 10; d++)
                soma = soma + parseInt(number.substring(d - 1, d)) * (12 - d);
            resto = (soma * 10) % 11;
            if (resto != parseInt(number.substring(10, 11))) {
                return true;
            }
        }
    }
}

function validateForm() {
    var form = document.forms['register-form'];

    // Form's first part
    var nome = form.name.value;
    var endereco = form.adress.value;
    var tel = form.tel.value;
    var email = form.email.value;
    var senha = form.password.value;
    var csenha = form.cpassword.value;
    if (nome == "") {
        alert("O nome deve ser preenchido!");
        return false;
    }
    else if (endereco == "") {
        alert("O endereço deve ser preenchido!");
        return false;
    }
    else if (tel == "") {
        alert("O telefone deve ser preenchido!");
        return false;
    }
    else if (!validateEmail(email)) {
        alert("O e-mail inserido é invalido!");
        return false;
    }
    else if (senha == "" || csenha == ""){ 
        alert("Insira uma senha");
        return false;
    }
    else if (senha != csenha) {
        alert("Senha não confere!");
        return false;
    }

    var tipo_de_usuario = form.user_type.value;
    if (tipo_de_usuario == "patient") {
        var cpf = form.cpf.value;
        var sexo = form.sex.value;
        var idade = form.age.value;

        console.log(sexo);

        if (sexo == "nenhum") {
            alert("Por favor, selecione o sexo");
            return false;
        }
        else if (idade == "") {
            alert("Por favor, insira a idade!");
            return false;
        }
        else if (!validateCPF(cpf)) {
            alert("O CPF inserido nao é valido!");
            return false;
        }

    }
    else if (tipo_de_usuario == "doctor") {
        var especialidade = form.especialidade.value;
        var crm = form.crm.value;

        if (especialidade == "nenhuma") {
            alert("Escolha uma especialidade!");
            return false;
        }
        else if (crm == "") {
            alert("Por favor, insira o CRM");
            return false;
        }
    }
    else if (tipo_de_usuario == "lab") {
        var exames = form.exams.value;
        var cnpj = form.cnpj.value;
        console.log(exames);

        if (cnpj == "") {
            alert("O CNPJ inserido é inválido!");
            return false;
        }
    }
    else {
        alert("Escolha um tipo de usuário!");
        return false;
    }

}

function registerUser(){
    validateForm();
}
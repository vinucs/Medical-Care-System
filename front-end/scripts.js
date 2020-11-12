if (localStorage.getItem("is_logged") == 1)
    showAccountManagement();
else {
    localStorage.setItem("is_logged", 0);
    showLogin();
}

function showLogin() {
    document.getElementById('login-header').style.display = "flex";
    console.log("not logged");
}

function showAccountManagement() {
    document.getElementById('acc-header').style.display = "flex";
    console.log("is logged");
}

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

 function isLogged(){
    localStorage.setItem("is_logged", 1);
    localStorage.setItem("user_type", "patient");
 }

 function logoutAccount(){
     localStorage.setItem("is_logged", 0);
 }

 function goToAccount() {
    if (localStorage.getItem("user_type") == "admin"){
        document.getElementById('acc-ref').href = "acc-management-admin.html";
    }
    if (localStorage.getItem("user_type") == "patient"){
        document.getElementById('acc-ref').href = "acc-management-patient.html";
    }
    if (localStorage.getItem("user_type") == "doctor"){
        document.getElementById('acc-ref').href = "acc-management-doctor.html";
    }
    if (localStorage.getItem("user_type") == "lab"){
        document.getElementById('acc-ref').href = "acc-management-lab.html";
    }
 }

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

 function validaCPF(numero) {
    var soma;
    var resto;
    soma = 0;
    if (/^(\d)\1*$/.test(numero) == true || numero.length != 11) { //testa se todos os digitos sao iguais
        return false;
    } else {
        for (x = 1; x < 9; x++)
            soma = soma + parseInt(numero.substring(x - 1, x), 10) * (11 - i)
        resto = (soma * 10) % 11;
        //verificando primeiro digito
        if (resto != parseInt(number.substring(9, 10))) { //primeiro digito verificador
            alert("O cpf inserido � invalido!!!");
        return false;
    }
        else {
            for (d = 1; d <= 10; d++)
                soma = soma + parseInt(number.substring(d - 1, d)) * (12 - d);
            resto = (soma * 10) % 11;
            if (resto != parseInt(numero.substring(10, 11))) {
                return true;
            }
        }
    }
}

function validaEmail(email) {
    exp_reg = /\S+@\S+\.\S+/;
    return exp_reg.test(email);
}

function validaForm() {
    var nome = document.forms["contato"]["nome"].value;
    var sobrenome = document.forms["contato"]["sobrenome"].value;
    var email = document.forms["contato"]["email"].value;
    var cpf = document.forms["contato"]["cpf"].value;
    var sexo = document.forms["contato"]["sexo"].value;
    var msg = document.forms["contato"]["msg"].value;
    if (nome == "") {
        alert("O nome deve ser preenchido!");
        return false;
    }
    else if (sobrenome == "") {
        alert("O sobrenome deve ser preenchido!");
        return false;
    }
    else if (validaCPF(cpf) == false) {
        alert("O CPF inserido nao e valido!");
        return false;
    }
    else if (email == "") {
        alert("Nenhum e-mail foi inserido!");
        return false;
    }
    else if (validarEmail(email) == false) {
            alert("O e-mail inserido e invalido!");
            return false;
        }
        else if (sexo == "none") {
        alert("Por favor, selecione o sexo");
        return false;
        }
    else if (msg == "") {
        alert("Por favor, insira a mensagem!");
        return false;
    }
}
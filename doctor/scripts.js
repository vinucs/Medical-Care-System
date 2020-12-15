 /* ---------- CHANGE TAB FUNCTION ---------- */

if (sessionStorage.getItem('tab') == null) {
    loadTab('register queries');
}   
else {
    loadTab(sessionStorage.getItem('tab'));
}

function logout() {
    sessionStorage.clear();
}

function loadTab(new_tab){
    sessionStorage.setItem('tab', new_tab);
    if (new_tab == 'register queries') {
        document.getElementById('reg-queries-tab').style.display = "flex";
        document.getElementById('queries-hist-tab').style.display = "none";
        document.getElementById('change-user-tab').style.display = "none";
    }
    else if (new_tab == 'queris historic') {
        document.getElementById('queries-hist-tab').style.display = "flex";
        document.getElementById('reg-queries-tab').style.display = "none";
        document.getElementById('change-user-tab').style.display = "none";
    }
    else if (new_tab == 'change user') {
        document.getElementById('change-user-tab').style.display = "flex";
        document.getElementById('reg-queries-tab').style.display = "none";
        document.getElementById('queries-hist-tab').style.display = "none";
    }
}

/* ---------- REGISTER FORM FUNCTIONS ---------- */

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

function validateRegisterForm() {
    var form = document.forms['register-form'];

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

    return true;
}

function validateChangeUserForm() {
    var form = document.forms['changeuser-form'];

    var email = form.email.value;
    var nova_senha = form.new_password.value;
    var nova_csenha = form.new_cpassword.value;

    if (email == "" && nova_senha == ""){
        alert("Nada preenchido!");
        return false;
    }
        
    if (nova_senha != "" && nova_senha != nova_csenha){
        alert("Senhas não conferem!");
        return false;
    }   
        
    return true;
}
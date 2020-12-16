 /* ---------- CHANGE TAB FUNCTION ---------- */

if (sessionStorage.getItem('tab') == null) {
    loadTab('register user');
}   
else {
    loadTab(sessionStorage.getItem('tab'));
}

function loadTab(new_tab){
    sessionStorage.setItem('tab', new_tab);
    if (new_tab == 'config acc') {
        document.getElementById('config-acc-tab').style.display = "flex";
        document.getElementById('register-user-tab').style.display = "none";
        document.getElementById('change-user-tab').style.display = "none";
        document.getElementById('change-user-form-tab').style.display = "none";
        document.getElementById('acc-options-tab').style.display = "flex";
    }
    else if (new_tab == 'register user') {
        document.getElementById('register-user-tab').style.display = "flex";
        document.getElementById('config-acc-tab').style.display = "none";
        document.getElementById('change-user-tab').style.display = "none";
        document.getElementById('change-user-form-tab').style.display = "none";
        document.getElementById('acc-options-tab').style.display = "flex";
    }
    else if (new_tab == 'change user') {
        document.getElementById('change-user-tab').style.display = "flex";
        document.getElementById('config-acc-tab').style.display = "none";
        document.getElementById('register-user-tab').style.display = "none";
        document.getElementById('change-user-form-tab').style.display = "none";
        document.getElementById('acc-options-tab').style.display = "flex";
    }
    else if (new_tab == 'user form') {
        document.getElementById('change-user-form-tab').style.display = "flex";
        document.getElementById('change-user-tab').style.display = "none";
        document.getElementById('config-acc-tab').style.display = "none";
        document.getElementById('register-user-tab').style.display = "none";
        document.getElementById('acc-options-tab').style.display = "none";
    }
}

/* ---------- CREDENTIALS FUNCTION ---------- */

function logout() {
    sessionStorage.clear();
}

 /* ---------- USER FORM DISPLAY FUNCTION ---------- */

 if (sessionStorage.getItem('form') == null) {
    loaduserForm('patient form');
}   
else {
    loadUserForm(sessionStorage.getItem('form'));
}

function loadUserForm(new_form){
    sessionStorage.setItem('form', new_form);
    if (new_form == 'patient form') {
        document.getElementById('patient-check').checked = true;
        document.getElementById('patient-form').style.display = "flex";
        document.getElementById('doctor-form').style.display = "none";
        document.getElementById('lab-form').style.display = "none";
    }
    else if (new_form == 'doctor form') {
        document.getElementById('doctor-check').checked = true;
        document.getElementById('doctor-form').style.display = "flex";
        document.getElementById('patient-form').style.display = "none";
        document.getElementById('lab-form').style.display = "none";
    }
    else if (new_form == 'lab form') {
        document.getElementById('lab-check').checked = true;
        document.getElementById('lab-form').style.display = "flex";
        document.getElementById('patient-form').style.display = "none";
        document.getElementById('doctor-form').style.display = "none";
    }
}

 /* ---------- CHANGE USER FORM DISPLAY FUNCTION ---------- */

function loadChangeUserForm(new_form){
    alert(new_form);
    if (new_form == 'patient') {
        document.getElementById('patient-change-form').style.display = "flex";
        document.getElementById('doctor-change-form').style.display = "none";
        document.getElementById('lab-change-form').style.display = "none";
    }
    else if (new_form == 'doctor') {
        document.getElementById('doctor-change-form').style.display = "flex";
        document.getElementById('patient-change-form').style.display = "none";
        document.getElementById('lab-change-form').style.display = "none";
    }
    else if (new_form == 'lab') {
        document.getElementById('lab-change-form').style.display = "flex";
        document.getElementById('patient-change-form').style.display = "none";
        document.getElementById('doctor-change-form').style.display = "none";
    }
}

/* ---------- FORM VALIDATION FUNCTIONS ---------- */

 // Mask function for form inputs
 function fMasc(objeto, mascara) {
    obj = objeto
    masc = mascara
    setTimeout("fMascEx()",1)
}

function fMascEx() {
    obj.value=masc(obj.value)
}

function mTel(tel) {
    tel=tel.replace(/\D/g,"")
    tel=tel.replace(/^(\d)/,"($1")
    tel=tel.replace(/(.{3})(\d)/,"$1)$2")
    if(tel.length == 9) {
        tel=tel.replace(/(.{1})$/,"-$1")
    } else if (tel.length == 10) {
        tel=tel.replace(/(.{2})$/,"-$1")
    } else if (tel.length == 11) {
        tel=tel.replace(/(.{3})$/,"-$1")
    } else if (tel.length == 12) {
        tel=tel.replace(/(.{4})$/,"-$1")
    } else if (tel.length > 12) {
        tel=tel.replace(/(.{4})$/,"-$1")
    }
    return tel;
}

function mCNPJ(cnpj){
    cnpj=cnpj.replace(/\D/g,"")
    cnpj=cnpj.replace(/^(\d{2})(\d)/,"$1.$2")
    cnpj=cnpj.replace(/^(\d{2})\.(\d{3})(\d)/,"$1.$2.$3")
    cnpj=cnpj.replace(/\.(\d{3})(\d)/,".$1/$2")
    cnpj=cnpj.replace(/(\d{4})(\d)/,"$1-$2")
    return cnpj
}

function mCPF(cpf){
    cpf=cpf.replace(/\D/g,"")
    cpf=cpf.replace(/(\d{3})(\d)/,"$1.$2")
    cpf=cpf.replace(/(\d{3})(\d)/,"$1.$2")
    cpf=cpf.replace(/(\d{3})(\d{1,2})$/,"$1-$2")
    return cpf
}

function mCEP(cep){
    cep=cep.replace(/\D/g,"")
    cep=cep.replace(/^(\d{2})(\d)/,"$1.$2")
    cep=cep.replace(/\.(\d{3})(\d)/,".$1-$2")
    return cep
}

function mNum(num){
    num=num.replace(/\D/g,"")
    return num
}

function validateCPF(numero) {
    numero = numero.replace(/-/g, '');
    numero = numero.replace(/\./g, '');

    var soma;
    var resto;
    soma = 0;
    if (/^(\d)\1*$/.test(numero) == true || numero.length != 11) { //testa se todos os digitos sao iguais
        return false;
    } 
    else {
        for (x = 1; x < 9; x++)
            soma = soma + parseInt(numero.substring(x - 1, x), 10) * (11 - i);
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

    return false;
}

function validateCNPJ(cnpj) {
    cnpj = cnpj.replace(/[^\d]+/g,'');
    cnpj = cnpj.replace(/-/g, '');
    cnpj = cnpj.replace(/\./g, '');
    cnpj = cnpj.replace(/\//g, '');
    console.log(cnpj);
 
    if(cnpj == '' || /^(\d)\1*$/.test(cnpj) || cnpj.length != 14)
        return false;
         
    tamanho = cnpj.length - 2
    numeros = cnpj.substring(0,tamanho);
    digitos = cnpj.substring(tamanho);
    soma = 0;
    pos = tamanho - 7;
    for (i = tamanho; i >= 1; i--) {
      soma += numeros.charAt(tamanho - i) * pos--;
      if (pos < 2)
            pos = 9;
    }
    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
    if (resultado != digitos.charAt(0))
        return false;
         
    tamanho = tamanho + 1;
    numeros = cnpj.substring(0,tamanho);
    soma = 0;
    pos = tamanho - 7;
    for (i = tamanho; i >= 1; i--) {
      soma += numeros.charAt(tamanho - i) * pos--;
      if (pos < 2)
            pos = 9;
    }
    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
    if (resultado != digitos.charAt(1))
          return false;
           
    return true;
}

function validateCRM(crm) {
    if(crm == '' || /^(\d)\1*$/.test(crm) || crm.length < 4 || crm.length > 8)
        return false;

    return true;
}

function validateTel(tel) {
    tel = tel.replace(/-/g, '');
    tel = tel.replace(/\(/g, '');
    tel = tel.replace(/\)/g, '');
    console.log(tel);

    if (tel.length < 10 || tel.length > 11)
        return false;

    return true;
}

function validatePassword(password) {
    if (password.length < 6)
        return false;

    return true;
}

function validateRegisterForm() {
    var form = document.forms['register-form'];
    var tel = form.tel.value;
    var senha = form.password.value;
    var csenha = form.cpassword.value;

    if (!validateTel(tel)) {
        alert("Número de telefone inválido!");
        return false;
    }

    if (senha != csenha) {
        alert("Senha não confere!");
        return false;
    }

    if (!validatePassword(senha)) {
        alert("Senha muito fraca!");
        return false;
    }

    var radios = document.getElementsByName('user_type');
    for (var i = 0, length = radios.length; i < length; i++) {
        if (radios[i].checked) {
            var tipo_de_usuario = form.user_type.value;
            break;
        }
    }
    
    if (tipo_de_usuario == "patient") {
        var cpf = form.cpf.value;
        var sexo = form.sex.value;
        var idade = form.age.value;

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
        else if (!validateCRM(crm)) {
            alert("O CRM inserido é inválido!");
            return false;
        }
    }
    else if (tipo_de_usuario == "lab") {
        var exames = form.exams.value;
        var cnpj = form.cnpj.value;
        console.log(cnpj);

        if (!validateCNPJ(cnpj)) {
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


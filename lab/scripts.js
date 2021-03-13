 /* ---------- LOAD AND DRAW CHART FUNCTIONS ---------- */

google.charts.load('current', {packages: ['corechart']});
google.charts.setOnLoadCallback(function() {drawChart('----')});

function selectedYear(event) {
    drawChart(this.options[this.selectedIndex].text);
}

function contExams(year) {
    yexams = new Array(12).fill(0);
    num_exams_year = 0;
    for(i = 0; i < exams.length; i++) {
        if (year.localeCompare(exams[i].slice(0, 4)) == 0){
            index = parseInt(exams[i].slice(5, 7)) - 1;
            yexams[index] += 1;
            num_exams_year += 1;
        }
    }

    return [yexams, num_exams_year];
}

function drawChart(year) {
    var [year_exams, num_exams_year] = contExams(year)

    const container = document.querySelector('#chart')
    const data = new google.visualization.arrayToDataTable([
        ['Mês', 'Exames'],
        ['Jan', year_exams[0]],
        ['Fev', year_exams[1]],
        ['Mar', year_exams[2]],
        ['Abr', year_exams[3]],
        ['Mai', year_exams[4]],
        ['Jun', year_exams[5]],
        ['Jul', year_exams[6]],
        ['Ago', year_exams[7]],
        ['Set', year_exams[8]],
        ['Out', year_exams[9]],
        ['Nov', year_exams[10]],
        ['Dez', year_exams[11]]
    ])

    const options = {
        title: 'Exames por mês no ano de ' + year,
        height: 400,
        width: 720
    }
    
    document.getElementById('media-mes').innerHTML = +parseFloat((num_exams_year/12).toFixed(3))
    document.getElementById('total-ano').innerHTML = num_exams_year

    const chart = new google.visualization.ColumnChart(container)
    chart.draw(data, options)
}
 
 /* ---------- CHANGE TAB FUNCTION ---------- */

 if (sessionStorage.getItem('tab') == null) {
    document.addEventListener('DOMContentLoaded', loadTab('register exams'));
}   
else {
    loadTab(sessionStorage.getItem('tab'));
}

function loadTab(new_tab){
    sessionStorage.setItem('tab', new_tab);
    if (new_tab == 'register exams') {
        document.getElementById('reg-exams-tab').style.display = "flex";
        document.getElementById('exams-hist-tab').style.display = "none";
        document.getElementById('statistics-tab').style.display = "none";
        document.getElementById('change-user-tab').style.display = "none";
        document.getElementById('change-exam-form-tab').style.display = "none";
        document.getElementById('acc-options-tab').style.display = "flex";
    }
    else if (new_tab == 'exams historic') {
        document.getElementById('exams-hist-tab').style.display = "flex";
        document.getElementById('reg-exams-tab').style.display = "none";
        document.getElementById('statistics-tab').style.display = "none";
        document.getElementById('change-user-tab').style.display = "none";
        document.getElementById('change-exam-form-tab').style.display = "none";
        document.getElementById('acc-options-tab').style.display = "flex";
    }
    else if (new_tab == 'statistics') {
        document.getElementById('statistics-tab').style.display = "flex";
        document.getElementById('exams-hist-tab').style.display = "none";
        document.getElementById('change-user-tab').style.display = "none";
        document.getElementById('reg-exams-tab').style.display = "none";    
        document.getElementById('change-exam-form-tab').style.display = "none";
        document.getElementById('acc-options-tab').style.display = "flex";
    }
    else if (new_tab == 'change user') {
        document.getElementById('change-user-tab').style.display = "flex";
        document.getElementById('reg-exams-tab').style.display = "none";
        document.getElementById('statistics-tab').style.display = "none";
        document.getElementById('exams-hist-tab').style.display = "none";
        document.getElementById('change-exam-form-tab').style.display = "none";
        document.getElementById('acc-options-tab').style.display = "flex";
    }
    else if (new_tab == 'change exam') {
        document.getElementById('change-exam-form-tab').style.display = "flex";
        document.getElementById('change-user-tab').style.display = "none";
        document.getElementById('statistics-tab').style.display = "none";
        document.getElementById('reg-exams-tab').style.display = "none";
        document.getElementById('exams-hist-tab').style.display = "none";
        document.getElementById('acc-options-tab').style.display = "none";
    }
}

/* ---------- CREDENTIALS FUNCTION ---------- */

function logout() {
    sessionStorage.clear();
}

/* ---------- FORM MASK FUNCTIONS ---------- */

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

/* ---------- VALIDATE CHANGE USER FORM FUNCTIONS ---------- */

function validateTel(tel) {
    tel = tel.replace(/-/g, '');
    tel = tel.replace(/\(/g, '');
    tel = tel.replace(/\)/g, '');

    if (tel == '')
        return true;

    if (tel.length < 10 || tel.length > 11)
        return false;

    return true;
}

function validatePassword(password) {
    if (password == '')
        return true;

    if (password.length < 6)
        return false;

    return true;
}

function validateChangeUserForm() {
    var form = document.forms['change-user-form'];

    var email = form.email.value;
    var adress = form.adress.value;
    var tel = form.tel.value;
    var nova_senha = form.new_password.value;
    var nova_csenha = form.new_cpassword.value;

    if (email == "" && nova_senha == "" && adress == "" && tel == ""){
        alert("Nada preenchido!");
        return false;
    }

    if (!validateTel(tel)) {
        alert("Número de telefone inválido!");
        return false;
    }

    if (!validatePassword(nova_senha)) {
        alert("Senha muito fraca!");
        return false;
    }

    if (nova_senha != "" && nova_senha != nova_csenha){
        alert("Senhas não conferem!");
        return false;
    }   
        
    return true;
}
/* ---------- LOAD AND DRAW CHART FUNCTIONS ---------- */

google.charts.load('current', {packages: ['corechart']});
google.charts.setOnLoadCallback(function() {drawChart('----')});

function selectedYear(event) {
    drawChart(this.options[this.selectedIndex].text);
}

function contQueries(year) {
    yqueries = new Array(12).fill(0);
    num_queries_year = 0;
    for(i = 0; i < queries.length; i++) {
        if (year.localeCompare(queries[i].slice(0, 4)) == 0){
            index = parseInt(queries[i].slice(5, 7)) - 1;
            yqueries[index] += 1;
            num_queries_year += 1;
        }
    }

    return [yqueries, num_queries_year];
}

function drawChart(year) {
    var [year_queries, num_queries_year] = contQueries(year)

    const container = document.querySelector('#chart')
    const data = new google.visualization.arrayToDataTable([
        ['Mês', 'Consultas'],
        ['Jan', year_queries[0]],
        ['Fev', year_queries[1]],
        ['Mar', year_queries[2]],
        ['Abr', year_queries[3]],
        ['Mai', year_queries[4]],
        ['Jun', year_queries[5]],
        ['Jul', year_queries[6]],
        ['Ago', year_queries[7]],
        ['Set', year_queries[8]],
        ['Out', year_queries[9]],
        ['Nov', year_queries[10]],
        ['Dez', year_queries[11]]
    ])

    const options = {
        title: 'Consultas por mês no ano de ' + year,
        height: 400,
        width: 720
    }
    
    document.getElementById('media-mes').innerHTML = +parseFloat((num_queries_year/12).toFixed(3))
    document.getElementById('total-ano').innerHTML = num_queries_year

    const chart = new google.visualization.ColumnChart(container)
    chart.draw(data, options)
}
 
 /* ---------- CHANGE TAB FUNCTION ---------- */

 if (sessionStorage.getItem('tab') == null) {
    document.addEventListener('DOMContentLoaded', loadTab('register queries'));
}   
else {
    loadTab(sessionStorage.getItem('tab'));
}

function loadTab(new_tab){
    sessionStorage.setItem('tab', new_tab);
    if (new_tab == 'register queries') {
        document.getElementById('reg-queries-tab').style.display = "flex";
        document.getElementById('queries-hist-tab').style.display = "none";
        document.getElementById('config-acc-tab').style.display = "none";
        document.getElementById('change-querie-form-tab').style.display = "none";
        document.getElementById('statistics-tab').style.display = "none";
        document.getElementById('acc-options-tab').style.display = "flex";
    }
    else if (new_tab == 'queries historic') {
        document.getElementById('queries-hist-tab').style.display = "flex";
        document.getElementById('reg-queries-tab').style.display = "none";
        document.getElementById('config-acc-tab').style.display = "none";
        document.getElementById('change-querie-form-tab').style.display = "none";
        document.getElementById('statistics-tab').style.display = "none";
        document.getElementById('acc-options-tab').style.display = "flex";
    }
    else if (new_tab == 'change user') {
        document.getElementById('config-acc-tab').style.display = "flex";
        document.getElementById('reg-queries-tab').style.display = "none";
        document.getElementById('queries-hist-tab').style.display = "none";
        document.getElementById('change-querie-form-tab').style.display = "none";
        document.getElementById('statistics-tab').style.display = "none";
        document.getElementById('acc-options-tab').style.display = "flex";
    }
    else if (new_tab == 'statistics') {
        document.getElementById('statistics-tab').style.display = "flex";
        document.getElementById('change-querie-form-tab').style.display = "none";
        document.getElementById('config-acc-tab').style.display = "none";
        document.getElementById('reg-queries-tab').style.display = "none";
        document.getElementById('queries-hist-tab').style.display = "none";
        document.getElementById('acc-options-tab').style.display = "flex";
    }
    else if (new_tab == 'change querie') {
        document.getElementById('change-querie-form-tab').style.display = "flex";
        document.getElementById('config-acc-tab').style.display = "none";
        document.getElementById('reg-queries-tab').style.display = "none";
        document.getElementById('queries-hist-tab').style.display = "none";
        document.getElementById('statistics-tab').style.display = "none";
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
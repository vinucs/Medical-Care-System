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
    var [year_queries, num_queries_year] = contQueries(year)
    var [year_exams, num_exams_year] = contExams(year)

    const container = document.querySelector('#chart')
    const data = new google.visualization.arrayToDataTable([
        ['Mês', 'Consultas', 'Exames'],
        ['Jan', year_queries[0], year_exams[0]],
        ['Fev', year_queries[1], year_exams[1]],
        ['Mar', year_queries[2], year_exams[2]],
        ['Abr', year_queries[3], year_exams[3]],
        ['Mai', year_queries[4], year_exams[4]],
        ['Jun', year_queries[5], year_exams[5]],
        ['Jul', year_queries[6], year_exams[6]],
        ['Ago', year_queries[7], year_exams[7]],
        ['Set', year_queries[8], year_exams[8]],
        ['Out', year_queries[9], year_exams[9]],
        ['Nov', year_queries[10], year_exams[10]],
        ['Dez', year_queries[11], year_exams[11]]
    ])

    const options = {
        title: 'Consultas e Exames por mês no ano de ' + year,
        height: 400,
        width: 720
    }
    
    document.getElementById('cmedia-mes').innerHTML = +parseFloat((num_queries_year/12).toFixed(3))
    document.getElementById('ctotal-ano').innerHTML = num_queries_year
    document.getElementById('emedia-mes').innerHTML = +parseFloat((num_exams_year/12).toFixed(3))
    document.getElementById('etotal-ano').innerHTML = num_exams_year

    const chart = new google.visualization.ColumnChart(container)
    chart.draw(data, options)
}

/* ---------- CHANGE TAB FUNCTION ---------- */

if (sessionStorage.getItem('tab') == null) {
    loadTab('queries tab');
}   
else {
    loadTab(sessionStorage.getItem('tab'));
}

function logout() {
    sessionStorage.clear();
}

function loadTab(new_tab){
    sessionStorage.setItem('tab', new_tab);
    if (new_tab == 'queries tab') {
        document.getElementById('queries-tab').style.display = "flex";
        document.getElementById('exams-tab').style.display = "none";
        document.getElementById('statistics-tab').style.display = "none";
    }
    else if (new_tab == 'exams tab') {
        document.getElementById('exams-tab').style.display = "flex";
        document.getElementById('queries-tab').style.display = "none";
        document.getElementById('statistics-tab').style.display = "none";
    }
    else if (new_tab == 'statistics') {
        document.getElementById('statistics-tab').style.display = "flex";
        document.getElementById('exams-tab').style.display = "none";
        document.getElementById('queries-tab').style.display = "none";
    }
}
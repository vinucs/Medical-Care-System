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
    }
    else if (new_tab == 'exams tab') {
        document.getElementById('exams-tab').style.display = "flex";
        document.getElementById('queries-tab').style.display = "none";
    }
}
function changeTypeUserForm(){
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
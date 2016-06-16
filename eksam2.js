function check() {
    var form = document.forms["poest"];
    var ese = form.elements["ese"];
    if (ese.value == "") {
        alert("Sisesta ikka midagi, mis Sa tühja plõksid");
    }
}

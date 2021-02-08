
window.setTimeout(closeAlertCreate,2000);
window.setTimeout(closeAlertUpdate,2000);
window.setTimeout(closeAlertDelete,2000);
window.setTimeout(closeAlertRegister,1000);

function closeAlertCreate(){
  document.getElementById("alert-create").style.display = "none";
}

function closeAlertUpdate(){
  document.getElementById("alert-update").style.display = "none";
}

function closeAlertDelete(){
  document.getElementById("alert-delete").style.display = "none";
}

function closeAlertRegister(){
  document.getElementById("alert").style.display = "none";
}

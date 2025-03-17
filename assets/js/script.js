// Fonction pour l'affichage du mot de passe
function myFunction() {
  let x = document.getElementById("mdp");

  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}

// Confirmation de suppression de compte
function confirmDelete(i) {
  if (!document.querySelector(`.delete-${i}`).classList.contains("d-none")) {
    document.querySelector(`.delete-${i}`).classList.add("d-none");
  } else {
    document.querySelector(`.delete-${i}`).classList.remove("d-none");
  }
}

// Database simulato
const database = [
    { email: "giovanni.gri@iisvittorioveneto.it", password: "password123" },
    { email: "user2@iisvittorioveneto.it", password: "securepass" },
    { email: "user3@iisvittorioveneto.it", password: "mypassword" }
];

document.getElementById('login-form').addEventListener('submit'), function(event) {event.preventDefault();

const email = document.getElementById('email').value.trim();
const password = document.getElementById('password').value.trim();
const errorMessage = document.getElementById('error-message');
const allowedDomain = "iisvittorioveneto.it";

errorMessage.textContent = ""; // Resetta il messaggio di errore

// Controlla che email e password non siano vuote
if (!email || !password) {
    errorMessage.textContent = "Inserisci sia l'email che la password.";
    console.log("Errore: campi vuoti");
    return;
}

// Controlla il dominio dell'email
const emailParts = email.split('@');
if (emailParts.length !== 2 || emailParts[1] !== allowedDomain) {
    errorMessage.textContent = "L'email deve appartenere al dominio @" + allowedDomain + ".";
    console.log("Errore: dominio email non valido", emailParts);
    return;
}

// Verifica email e password nel database simulato
const user = database.find(user => user.email === email && user.password === password);
if (!user) {
    errorMessage.textContent = "Credenziali non valide. Riprova.";
    console.log("Errore: credenziali non valide", { email, password });
    return;
}

// Accesso riuscito
console.log("Accesso riuscito", { email });
alert("Accesso effettuato con successo!");
};
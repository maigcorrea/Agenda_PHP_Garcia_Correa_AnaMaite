// Visualizar/No visualizar contraseña
const eyes = document.querySelectorAll(".eye");


eyes.forEach(eye => {
    //Seleccionar el input asociado a ese icono al que se le va a dar click
    const inputPassword = eye.parentElement.querySelector("input");

    //Establecer el icono en base al tipo de input inicial
    eye.textContent = inputPassword.type === "password" ? "visibility" : "visibility_off";

    eye.addEventListener("click",()=>{
        // Valor del atributo type de input
        const type=inputPassword.type;
        
        // Alternar el valor type en la contraseña
        //Si el tipo es igual a password, se asigna la condición true (detrás de ?), si no es igual, se asigna la condición false (detrás de :)
        inputPassword.type = type === "password" ? "text" : "password"; // Operador ternario, forma compacta de escribir una condición if-else
    
        // Cambiar icono dependiendo del nuevo estado del input al darle click al icono
        eye.textContent = type === "password" ? "visibility_off" : "visibility";
    })

        inputPassword.addEventListener("mouseenter",()=>{
            eye.setAttribute("fill", "red");
    })
});




 // Mostrar el toast automáticamente si existe
//  window.onload = function () {
//     let toast = document.getElementById("toast");
//     if (toast) {
//         setTimeout(() => {
//             toast.classList.add("opacity-100", "translate-y-0");
//         }, 200); // Retraso corto para la animación

//         // Ocultarlo después de 5 segundos
//         setTimeout(() => {
//             closeToast();
//         }, 5000);
//     }
// };
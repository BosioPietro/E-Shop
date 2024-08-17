'use strict';

function togglePWD(icona){
    const mod = icona.prop('name').includes('off');

    if(mod){
        icona.prop('name', 'eye-outline');
        $('#password').prop('type', 'password');
    }
    else{
        icona.prop('name', 'eye-off-outline');
        $('#password').prop('type', 'text');
    }
}   

function registrazione(){
    const mail = $('#mail').val().trim();
    let pwd = $('#password').val();
    const username = $('#username').val().trim();
    
    if(!validaEmail(mail)) return mostraErrore("E-Mail non valida");
    if(!validaUsername(username)) return mostraErrore("Username non valido");
    if(pwd.length < 8 || pwd.length > 30) return mostraErrore("Password non valida");

    pwd = CryptoJS.MD5(pwd).toString(); // MD5 è una funzione di hash

    inviaRichiesta("POST", "registrazione.php", {username, pwd, mail})
    .done((data) => {
        if("errore utente" in data) return mostraErrore(data["errore utente"]);

        const params = ottieniParametri(window.location.search);
        const prec = params["prec"] || "index";
        delete params["prec"];
        window.location.href = `${prec}.php?${$.param(params)}`;
    })
    .fail((err) => {
        console.log(err);
    });
    
}

function validaUsername(username){
    return username.match(/^[a-zA-Z0-9_]{3,30}$/);
}

function validaEmail(email){
    return email.match(/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/);
}

function passaLogin(){
    const params = ottieniParametri(window.location.search);
    const prec = params["prec"] || "index";
    delete params["prec"];
    window.location.href = `login.php?prec=${prec}&${$.param(params)}`;
}
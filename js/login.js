'use strict'

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

function login(){
    const mail = $('#username').val().trim();
    let pwd = $('#password').val();
    if(mail.includes('@') ? validaEmail(mail, pwd) : validaUsername(mail, pwd)){
        if(pwd.length < 8 || pwd.length > 30) return mostraErrore("Password non valida");

        pwd = CryptoJS.MD5(pwd).toString();
        
        inviaRichiesta('POST', 'login.php', { [mail.includes('@') ? "mail" : "username"]: mail, pwd })
        .catch((err) => {
            console.log(err);
        })
        .done((data) => {
            if("errore utente" in data) return mostraErrore(data["errore utente"]);

            const params = ottieniParametri(window.location.search);
            const prec = params["prec"] || "index";
            delete params["prec"];
            window.location.href = `${prec}.php?${$.param(params)}`;
        })
    }
    else mostraErrore(mail.includes('@') ? "E-Mail non valida" : "Username non valido");
}

function validaUsername(username){
    return username.match(/^[a-zA-Z0-9_]{3,30}$/);
}

function validaEmail(email){
    return email.match(/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/);
}

function passaRegistrati(){
    const params = ottieniParametri(window.location.search);
    const prec = params["prec"] || "index";
    delete params["prec"];
    window.location.href = `registrazione.php?prec=${prec}&${$.param(params)}`;
}
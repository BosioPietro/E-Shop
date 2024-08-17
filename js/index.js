'use strict'

function random(stop, start = 0) {
    return Math.floor(Math.random() * (stop - start)) + start; 
}  

function remInPx(rem) {  
    return (rem + "").replace("rem", "") * parseFloat(getComputedStyle(document.documentElement).fontSize);
}

// scrolla fino all'elemento

function scrolla(elem, testo = ""){
    const t = testo ? testo : elem.text().toLowerCase();
    const offset = $(`#${t}`).offset().top;
    window.scrollTo(0, offset)
}

// cursore custom

window.addEventListener("load", () => {

    const cursore = $('.cursore');
    const dentro = $('.cursore-dentro');

    $(document).on('mousemove.mostra', function(e){
        cursore.removeClass('nascosto');
        dentro.removeClass('nascosto');
        $(document).off('mousemove.mostra')
    });
    

    $(window).on('touchstart.supportoMouse',function(){
        $(window).off('.supportoMouse');
        $(".cursore, .cursore-dentro").remove()
        $(document).off('mousemove.mostra')
    });

    $(document).on('mousemove', function(e){
        const x = e.clientX;
        const y = e.clientY;
        cursore.css({transform : `translate3d(calc(${x}px - 50%), calc(${y}px - 50%), 0)`});
    });

    $(document).on('mousemove', function(e){
        var x = e.clientX;
        var y = e.clientY;
        dentro.css({left : `${x}px`, top : `${y}px`});
    });

    $(document).on('mousedown', function(){
        dentro.addClass('clickando')
    });

    $(document).on('mouseup', function(){
        dentro.removeClass('clickando')
    });

    const elementi = "ion-icon, .btn, .logo, .voce-elenco, .categoria, a, .checkBox, .prodotto button, #link-recensioni, .swal2-close";

    $(document).on("mouseenter", elementi , function(){
        dentro.addClass("hover")
        cursore.addClass("hover")
    });

    $(document).on("mouseleave", elementi , function(){
        dentro.removeClass("hover")
        cursore.removeClass("hover")
    });
})

// Effetto brilla

window.addEventListener("scroll", brilla)
window.addEventListener("mousemove", brilla)

function brilla(){
    const brilla = $(".blob-griglia, .hl, #cont-principale .btn")
    $(brilla).addClass("brilla")
    setTimeout(() => $(brilla).removeClass("brilla"), 750)
}


function mostraErrore(titolo){
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2000,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer);
          toast.addEventListener('mouseleave', Swal.resumeTimer);
        },
        customClass: {
            popup: 'swal-errore',
            icon: 'swal-errore-icon',    
        }
    });
  
    Toast.fire({
        icon: 'error',
        title: titolo
    })
}

window.addEventListener("load", () => {
    $(document).on("click", ".wrapper-input, .wrapper-pwd", (e) => {
        $(e.target).find("input").focus()
    })
});

function logout(){
    inviaRichiesta("POST", "logout.php", {}).done((data) => {
        if(data["ok"])
            window.location.reload();
    })
}

window.addEventListener("load", () => {
    $("input[type='password']").on("keydown", (e) => {
        if(e.keyCode == 13) $("#invia").click()
    })
});

function mostraConferma(titolo){
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2000,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer);
          toast.addEventListener('mouseleave', Swal.resumeTimer);
        },
        customClass: {
            popup: 'swal-errore',
            icon: 'swal-errore-icon',    
        }
    });
  
    Toast.fire({
        icon: 'success',
        title: titolo
    })
}
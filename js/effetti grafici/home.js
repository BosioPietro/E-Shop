'use strict'

const c = console.log

function easing(t) {
    return 1 - Math.pow(1 - t, 20);
}

function animateNumber(element, endingNumber, durationInSeconds) {
    const startTime = performance.now();
    const startNumber = parseFloat(element.textContent);
    
    function updateNumber(timestamp) {
        const elapsedTime = (timestamp - startTime) / 1000; // Convert to seconds
        if (elapsedTime >= durationInSeconds) {
            element.textContent = endingNumber;
            return;
        }
        
        const progress = elapsedTime / durationInSeconds;
        const easedProgress = easing(progress);
        const currentNumber = startNumber + (endingNumber - startNumber) * easedProgress;
        
        element.textContent = Math.round(currentNumber);
        
        requestAnimationFrame(updateNumber);
    }

    requestAnimationFrame(updateNumber);
}

// Effetto griglia iniziale
window.addEventListener("load", () => {

    const blob = document.querySelectorAll("main .blob-griglia");
    const shift = (b, index, rangeX, rangeY) => {    
        const translationIntensity = 24,
            maxTranslation = translationIntensity * (index + 1),
            currentTranslation = `${maxTranslation * rangeX}% ${maxTranslation * rangeY}%`;
        b.animate({ 
            translate: currentTranslation,
        }, { duration: 750, fill: "forwards", easing: "ease" });
        brilla()
    }

    const shiftAll = (blob, rangeX, rangeY) => blob.forEach((b, index) => shift(b, index, rangeX, rangeY));

    const shiftLogo = (e) => {  
        const radius = 5000;
        const centerX = window.innerWidth / 2,
                centerY = window.innerHeight / 2;

        const rangeX = (e.clientX - centerX) / radius,
                rangeY = (e.clientY - centerY) / radius;

        shiftAll(blob, rangeX, rangeY);
    }
    window.onmousemove = e => shiftLogo(e, blob);
})


// Effetto griglia recensioni

window.addEventListener("load", () => {
    $(window).on("mousemove", (e) => {
        const blob = $("#recensioni .blob-griglia");
        const x = e.clientX, y = e.clientY;
        let grandezza = parseInt($("#recensioni .blob-griglia").css("--grandezza"));
        const top = $("#recensioni")[0].getBoundingClientRect().top;

        grandezza = remInPx(grandezza);
        blob.css({top : `${y - grandezza / 2 - top}px`, left : `${x - grandezza / 2}px`})
    })
})

window.addEventListener("load", () => {
    $(window).on("mousemove", (e) => {
        const blob = $("#prodotti .blob-griglia");
        const x = e.clientX, y = e.clientY;
        let grandezza = parseInt($("#prodotti .blob-griglia").css("--grandezza"));
        const top = $("#prodotti")[0].getBoundingClientRect().top;

        grandezza = remInPx(grandezza);
        blob.css({top : `${y - grandezza / 2 - top}px`, left : `${x - grandezza / 2}px`})
    })
})

window.addEventListener("load", () => {
    $(window).on("mousemove", (e) => {
        const blob = $("#partner .blob-griglia");
        const x = e.clientX, y = e.clientY;
        let grandezza = parseInt($("#partner .blob-griglia").css("--grandezza"));
        const top = $("#partner")[0].getBoundingClientRect().top;

        grandezza = remInPx(grandezza);
        blob.css({top : `${y - grandezza / 2 - top}px`, left : `${x - grandezza / 2}px`})
    })
})

// Effetto numeri

window.addEventListener("load", () => {
    gsap.registerPlugin(ScrollTrigger); 
    let arrayClip = [0,0,0,0];
    const tl = gsap.timeline({
        scrollTrigger : {
            trigger: "#recensioni",
            start : `top center`,
            end : `center center`,
            scrub : false,
            // markers : 1,
        }
    })
    tl.to(arrayClip, {
        endArray : [4.9, 1825, 2149, 99.9],
        ease : "none",
        onUpdate : () => {
            const s = $(".statistica h3")
            s.eq(0).text(arrayClip[0].toFixed(1))
            s.eq(1).text(Math.floor(arrayClip[1]))
            s.eq(2).text(Math.floor(arrayClip[2]))
            s.eq(3).text(arrayClip[3].toFixed(1))
        },
        duration : 2,
    })
})

// Effetto carte categoria

window.addEventListener("load", () => {
    $("#cont-categoria").on("mousemove", (e) => {
        $(".categoria").each((i, elem) => {
            const rect = elem.getBoundingClientRect(),
            x = e.clientX - rect.left,
            y = e.clientY - rect.top;
  
            elem.style.setProperty("--mouse-x", `${x}px`);
            elem.style.setProperty("--mouse-y", `${y}px`);
        })
    });
})

// Effetto carte categoria 2

window.addEventListener("load", () => {
    $(".categoria").on("mouseenter", (e) => {
         $(e.currentTarget).find("h4").addClass("hl brilla")
    })

    $(".categoria").on("mouseleave", (e) => {
        $(e.currentTarget).find("h4").removeClass("hl brilla")
    })
})
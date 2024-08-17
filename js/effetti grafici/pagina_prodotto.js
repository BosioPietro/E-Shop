'use strict'

window.addEventListener("load", () => {
    $("#specifiche").on("mousemove", (e) => {
        $(".td").each((i, elem) => {
            const rect = elem.getBoundingClientRect(),
            x = e.clientX - rect.left,
            y = e.clientY - rect.top;
  
            elem.style.setProperty("--mouse-x", `${x}px`);
            elem.style.setProperty("--mouse-y", `${y}px`);
        })
    });
})

window.addEventListener("load", () => {
    $(window).on("mousemove", (e) => {
        const blob = $(".blob-griglia");
        const x = e.clientX, y = e.clientY;
        let grandezza = parseInt($(".blob-griglia").css("--grandezza"));

        grandezza = remInPx(grandezza);
        blob.css({top : `${y - grandezza / 2}px`, left : `${x - grandezza / 2}px`})
    })
})
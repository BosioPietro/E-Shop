<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="./img/favicon.webp">
    <title>Ordine Effettuato ・ Ernico</title>
    <!-- CSS -->
    <link rel="stylesheet" href="css/index.css"/>
    <link rel="stylesheet" href="css/ordine_effettuato.css"/>
    <!-- SCRIPT LOCALI -->
    <script src="server/libreria_server.js"></script>
    <script src="js/index.js"></script>
    <script src="./js/effetti grafici/ordine_effettuato.js"></script>
    <!-- jQUERY -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- LENIS -->
    <script src="https://cdn.jsdelivr.net/gh/studio-freight/lenis@1/bundled/lenis.min.js"></script>
    <!-- SWAL -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- ION-ICONS -->
    <script defer src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <!-- GSAP -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <!-- SCROLLTRIGGER -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    
</head>
<body class="flex-col jc-c al-c">
    <div class="cursore nascosto"></div>
    <div class="cursore-dentro nascosto"></div>
    <h2 class="title">Ordine effettuato</h2>
    <h4 class="hl">Grazie per aver scelto Ernico</h4>
    <h6>Codice ordine #<?php echo $_REQUEST["id"] ?></h6>
    <a href="./index.php" class="hl">Torna alla home</a>
    <div class="img-griglia"></div>
    <div class="blob-griglia"></div>
</body>
</html>

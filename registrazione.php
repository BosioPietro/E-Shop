<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="./img/favicon.webp">
    <title>Registrazione ・ Ernico</title>
    <!-- CSS -->
    <link rel="stylesheet" href="css/index.css"/>
    <link rel="stylesheet" href="css/registrazione.css"/>
    <!-- SCRIPT LOCALI -->
    <script src="js/index.js"></script>
    <script src="js/effetti grafici/login.js"></script>
    <script src="server/libreria_server.js"></script>
    <script src="js/registrazione.js"></script>
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
    <!-- CRYPTOJS  -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script>
    
</head>
<body class="flex-col">
    <div class="cursore nascosto"></div>
    <div class="cursore-dentro nascosto"></div>
    <section class="flex-col jc-c al-c">
        <div class="blob-griglia"></div>
        <div class="img-griglia"></div>
        <main class="flex-row al-c">
            <img src="./img/bg_reg.png">
            <div class="flex-col al-c jc-c grow" id="cont-login">
                <h1>Registrati</h1>
                <div class="cella-input flex-col jc-c ev">
                    <label for="mail">E-mail</label>
                    <div class="wrapper-input flex-row">
                        <input type="text" name="mail" id="mail">
                    </div>
                </div>
                <div class="cella-input flex-col jc-c ev">
                    <label for="username">Username</label>
                    <div class="wrapper-input flex-row">
                        <input type="text" name="username" id="username">
                    </div>
                </div>
                <div class="cella-input flex-col jc-c">
                    <label for="username">Password</label>
                    <div class="wrapper-pwd flex-row al-c grow">
                        <div class="wrapper-input flex-row grow">
                            <input type="password" name="password" id="password">
                        </div>
                        <ion-icon name="eye-outline" onclick="togglePWD($(this))">
                        </ion-icon>
                    </div>
                </div>
                <button class="btn accento" onclick="registrazione()" id="invia">Registrati</button>
                <h4>Hai già un account? <a href="javascript:passaLogin()">Accedi</a></h4>
            </div>
        </main>
    </section>
    <footer class="flex-col" id="social">
        <h5>Contattaci</h5>
        <h3><a href="mailto:support@ernico.it">support<span class="hl">@</span>ernico.it</a></h3>
        <div class="flex-row al-c">
            <div>Rimani in conttatto</div>
            <div class="spacer-orizz"></div>
            <ion-icon name="logo-facebook"></ion-icon>
            <ion-icon name="logo-instagram"></ion-icon>
            <ion-icon name="logo-twitter"></ion-icon>
        </div>
        <div class="flex-row sb">
            <div>Via Oscar Milano 188, 12040 Sanfrè CN</div>
            <div>Copyright 2023 ・ 
                <span style="font-family: 'Logo', sans-serif;" class="hl">E</span>
            </div>
        </div>
    </footer>
</body>
</html>

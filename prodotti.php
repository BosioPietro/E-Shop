<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="./img/favicon.webp">
    <title>Prodotti ・ Ernico</title>
    <!-- CSS -->
    <link rel="stylesheet" href="css/index.css"/>
    <link rel="stylesheet" href="css/prodotti.css"/>
    <!-- SCRIPT LOCALI -->
    <script src="server/libreria_server.js"></script>
    <script src="js/index.js"></script>
    <script src="js/prodotti.js"></script>
    <script src="js/effetti grafici/prodotti.js"></script>
    <!-- jQUERY -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- LENIS -->
    <script src="https://cdn.jsdelivr.net/gh/studio-freight/lenis@1/bundled/lenis.min.js"></script>
    <!-- SWAL -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <!-- ION-ICONS -->
    <script defer src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <!-- GSAP -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <!-- SCROLLTRIGGER -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    
</head>
<body class="flex-col">
    <div class="blob-griglia"></div>
    <div class="cursore nascosto"></div>
    <div class="cursore-dentro nascosto"></div>
    <header class="flex-row jc-c">
        <div class="logo flex-row al-c" onclick="window.location.href = './index.php'">
            <div>E</div>
            <div>Ernico</div>
        </div>
        <div class="flex-row al-c" id="elenco-header">
            <div class="voce-elenco flex-col jc-c"  onclick="window.location.href = './index.php'">Home</div>
            <div class="voce-elenco flex-col jc-c" onclick="window.location.href = './checkout.php'">Carrello</div>
            <div class="voce-elenco flex-col jc-c"  onclick="scrolla($(this))">Social</div>
        </div>
        <div id="cont-bottoni" class="flex-row al-c 
                <?php
                    session_start();
                    if(isset($_SESSION['username'])) {
                        echo 'mostra-utente';
                    }
                ?>
            ">
            <button class="btn primario" onclick="vaiA('registrazione')">Registrati</button>
            <button class="btn accento" onclick="vaiA('login')">Accedi</button>
            <span class="hl" id="nome-utente">
                <?php
                    if(isset($_SESSION['username'])){
                        echo $_SESSION['username'];
                    }
                ?>
            </span>
            <ion-icon name="log-out-outline" onclick="logout()"></ion-icon>
        </div>
    </header>
    <div class="flex-row grow">
        <aside class="flex-col al-c">
            <div class="flex-row al-c jc-sb">
                <h2>Filtri</h2>
                <button class="btn btn-primario" onclick="window.location.href = './prodotti.php'">Rimuovi</button>
            </div>
            <div class="spacer-orizz"></div>
            <div class="flex-col">
                <h3 class="flex-row al-c jc-sb">
                    <span class="sotto-filtro">Prezzo (€) </span>
                    <div class="content">
                        <label class="checkBox">
                          <input id="chk-prezzo" type="checkbox" <?php
                            if(isset($_REQUEST["prezzo-enabled"]) && $_REQUEST["prezzo-enabled"] == "true")
                            {
                                echo("checked");
                            }
                          ?>>
                          <div class="transition"></div>
                        </label>
                     </div>
                </h3>
                <?php
                    $s = "tutto";
                    if(isset($_REQUEST["s"]))
                    {
                        $s = $_REQUEST["s"];
                    }
                    require("./server/MySQLi.php");
                    $connection = openConnection("ernico");
                    $query = "SELECT MIN(prezzo) AS min, MAX(prezzo) AS max FROM prodotti";
                    if($s != "tutto")
                    {
                        $query .= " WHERE categoria = '$s'";
                    }
                    $data = eseguiQuery($connection, $query);
                    $min = floor($data[0]["min"]);
                    $max = ceil($data[0]["max"]);

                    $minVal = $min;
                    $maxVal = $max;

                    if(isset($_REQUEST["prezzoMin"]))
                    {
                        $minVal = $_REQUEST["prezzoMin"];
                    }
                    if(isset($_REQUEST["prezzoMax"]))
                    {
                        $maxVal = $_REQUEST["prezzoMax"];
                    }
                ?>
                <div class="flex-row al-c" id="cont-prezzo">
                    <input type="text" placeholder="Min" class="input min" id="prezzo-min" value="<?php echo($minVal) ?>"/>
                    <p>-</p>
                    <input type="text" placeholder="Max" class="input max" id="prezzo-max" value="<?php echo($maxVal) ?>"/>
                </div>
                <div class="range">
                    <div class="range-slider">
                      <span class="range-selected"></span>
                    </div>
                    <div class="range-input">
                      <input type="range" class="min" min="<?php echo($min) ?>" max="<?php echo($max) ?>" value="<?php echo($minVal) ?>" step="1">
                      <input type="range" class="max" min="<?php echo($min) ?>" max="<?php echo($max) ?>" value="<?php echo($maxVal) ?>" step="1">
                    </div>
            </div>
            <div class="flex-col cella-filtro">
                <h3 class="flex-row al-c jc-sb">
                    <span class="sotto-filtro">Marca</span>
                    <div class="content">
                        <label class="checkBox">
                          <input id="chk-marca" type="checkbox"<?php
                            if(isset($_REQUEST["marca-enabled"]) && $_REQUEST["marca-enabled"] == "true")
                            {
                                echo("checked");
                            }
                          ?>>
                          <div class="transition"></div>
                        </label>
                     </div>
                </h3>
                <div class="flex-row al-c wrap jc-sb" id="cont-marche">
                    <?php // filtro marche
                        $query = "SELECT DISTINCT marca FROM prodotti";
                        $marche = eseguiQuery($connection, $query);
                        foreach($marche as $indice => $m)
                        {
                            $m = $m["marca"];
                            echo('<div class="flex-row al-c cont-chk">'.
                                    '<div class="content">'.
                                        '<label class="checkBox">'.
                                            '<input id="chk-marca-'.$indice.'" type="checkbox" value="'.$m.'"');
                                            
                            if(isset($_REQUEST["marca"]) && in_array($m, $_REQUEST["marca"]))
                            {
                                echo('checked');
                            }

                            echo(           '>'.
                                            '<div class="transition"></div>'.
                                        '</label>'.
                                    '</div>'.
                                    '<label for="chk-marca-'.$indice.'">'.$m.'</label>'.
                                '</div>');
                        }
                    ?>
                </div>
            </div>
            <div class="flex-col cella-filtro">
                <h3 class="flex-row al-c jc-sb">
                    <span class="sotto-filtro">Categoria</span>
                </h3>
                <div class="flex-row al-c wrap jc-sb" id="cont-cat">
                   <?php // filtro categorie
                        $query = "SELECT nome FROM categorie_prodotti";
                        $categorie = eseguiQuery($connection, $query);

                        foreach($categorie as $indice => $cat)
                        {
                            $cat = $cat["nome"];
                            echo('<div class="flex-row al-c cont-chk">'.
                                    '<div class="content">'.
                                        '<label class="checkBox">'.
                                            '<input id="chk-cat-'.$indice.'" type="checkbox" value="'.$cat.'" onchange="cambiaCat($(this))" ');
                            if((!isset($_REQUEST["categoria"]) && $s != null && $cat == $s) || (isset($_REQUEST["categoria"]) && in_array($cat, $_REQUEST["categoria"])))
                            {
                                echo('checked');
                            }
                            echo(           '><div class="transition"></div>'.
                                        '</label>'.
                                    '</div>'.
                                    '<label for="chk-cat-'.$indice.'">'.$cat.'</label>'.
                                '</div>');
                        }
                   ?>
                </div>
            </div>
            <button class="btn accento" id="btn-applica" onclick="applicaFiltri()">Applica Filtri</button>
        </aside>
        <section class="grow flex-row wrap al-c jc-c">
            <h1>
                <?php
                    if(!isset($_REQUEST["categoria"]))
                    {
                        if($s == "tutto")
                        {
                            echo("Tutti i Prodotti");
                        }
                        else echo($s);
                    }
                    else{
                        if(in_array("tutto", $_REQUEST["categoria"]))
                        {
                            echo("Tutti i Prodotti");
                        }
                        else if(count($_REQUEST["categoria"]) == 1)
                        {
                            echo($_REQUEST["categoria"][0]);
                        }
                        else if (count($_REQUEST["categoria"]) == 2)
                        {
                            echo($_REQUEST["categoria"][0]." & ".$_REQUEST["categoria"][1]);
                        }
                        else if (count($_REQUEST["categoria"]) < 5)
                        {
                            echo($_REQUEST["categoria"][0].", ".$_REQUEST["categoria"][1]);
                            if(isset($_REQUEST["categoria"][3]))
                            {
                                echo(", ".$_REQUEST["categoria"][2]." & ".$_REQUEST["categoria"][3]);
                            }
                            else echo(" & ".$_REQUEST["categoria"][2]);
                        }
                        else
                        {
                            echo("Risultati della ricerca");
                        }
                    }
                ?>
            </h1>
            <?php // stampa i prodotti
                $query = "SELECT id, nome, prezzo, categoria, quantita, sconto FROM prodotti";
                if($s != "tutto" && !isset($_REQUEST["categoria"]))
                {
                    $query .= " WHERE categoria = '$s'";
                }
                if(isset($_REQUEST["categoria"]) && !in_array("tutto", $_REQUEST["categoria"]))
                {
                    if(strpos($query, "WHERE") === false)
                    {
                        $query .= " WHERE";
                    }
                    else
                    {
                        $query .= " AND";
                    }
                    $query .= " categoria IN (";
                    foreach($_REQUEST["categoria"] as $c)
                    {
                        $query .= "'".$c."',";
                    }
                    $query = substr($query, 0, -1);
                    $query .= ")";
                }
                $abilitato = isset($_REQUEST["prezzo-enabled"]) && $_REQUEST["prezzo-enabled"] == "true";
                if(isset($_REQUEST["prezzoMin"]) && $abilitato)
                {
                    if(strpos($query, "WHERE") === false)
                    {
                        $query .= " WHERE";
                    }
                    else
                    {
                        $query .= " AND";
                    }
                    $query .= "  prezzo >= ".$_REQUEST["prezzoMin"];
                }
                if(isset($_REQUEST["prezzoMax"]) && $abilitato)
                {
                    if(strpos($query, "WHERE") === false)
                    {
                        $query .= " WHERE";
                    }
                    else
                    {
                        $query .= " AND";
                    }
                    $query .= " prezzo <= ".$_REQUEST["prezzoMax"];
                }
                $abilitato = isset($_REQUEST["marca-enabled"]) && $_REQUEST["marca-enabled"] == "true";
                if(isset($_REQUEST["marca"]) && $abilitato)
                {
                    if(strpos($query, "WHERE") === false)
                    {
                        $query .= " WHERE";
                    }
                    else
                    {
                        $query .= " AND";
                    }
                    $query .= " marca IN (";
                    foreach($_REQUEST["marca"] as $m)
                    {
                        $query .= "'".$m."',";
                    }
                    $query = substr($query, 0, -1);
                    $query .= ")";
                }
                $prodotti = eseguiQuery($connection, $query);
                $risultati = "";
                if(count($prodotti) > 0)
                {
                    $risultati = "nascosto";
                }
                foreach($prodotti as $p)
                {
                    $categoria = $p["categoria"];
                    echo(
                    '<div class="prodotto flex-col">'.
                    '<div class="prodotto-content flex-col">'.
                        '<img src="./img_prodotti/'.$categoria.'/'.$p["id"].'.png">'.
                        '<h3>'.$p["nome"].'</h3>'.
                        '<div class="flex-row al-c">');
                        if($p["quantita"] == 0)
                        {
                            echo('<ion-icon class="non-disp" name="close-circle-outline"></ion-icon>
                                    <h4 class="non-disp">Non disponibile</h4>');
                        }
                        else{
                            $query = "SELECT AVG(rating) AS rating FROM recensioni WHERE prodotto = $p[id]";
                            $p["rating"] = eseguiQuery($connection, $query)[0]["rating"];
                            $p["rating"] = number_format($p["rating"], 1);
                            $prezzo = $p["prezzo"] * (100 - $p["sconto"]) / 100;
                            $cls = "";
                            if($p["rating"] == 0){
                                $cls = "no-stelle";
                            }
                            echo(
                                '<h4>€ '.number_format($prezzo, 2).'</h4>'.
                                '<p> ・ </p>'.
                                '<div class="flex-row al-c stelle '.$cls.'">');
                                    $intero = floor($p["rating"]);
                                    $decimale = 0;
                                    if($intero != $p["rating"])
                                    {
                                        $decimale = 1;
                                    }
                                    for($i = 0; $i < $intero; $i++)
                                    {
                                        echo('<ion-icon name="star"></ion-icon>');
                                    }
                                    if($decimale == 1)
                                    {
                                        echo('<ion-icon name="star-half"></ion-icon>');
                                    }
                                    for($i = 0; $i < 5 - $intero - $decimale; $i++)
                                    {
                                        echo('<ion-icon name="star-outline"></ion-icon>');
                                    }
                                    echo('</div>');
                        }
                        echo(
                        '</div>'.
                        '<button class="btn accento" onclick="window.location.href = \'./pagina_prodotto.php?id='.$p["id"].'\'">Visualizza</button>'.
                    '</div>'.
                '</div>');
                }
            ?>
            <div class="flex-col <?php echo $risultati ?> jc-c al-c" id="no-risultati">
                <h2 class="hl">Nessun Risultato</h2>
                <h4>Non sono stati trovati prodotti con i filtri selezionati</h4>
            </div>
            <!-- <button class="btn primario btn-mostra"">Mostra altro</button> -->
        </section>
    </div>
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

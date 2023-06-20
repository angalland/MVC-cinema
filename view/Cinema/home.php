<?php
ob_start();?>
<!-- affiche la page home -->
<div id="home">
    <h2>News cinéma</h2>
    <p class="phome">Lorem ipsum dolor sit amet consectetur adipisicing elit. Minima blanditiis nobis exercitationem similique porro magnam explicabo tempore veniam, magni doloribus quasi debitis, quibusdam eos sunt sequi in? Eos, laborum modi.</p>
</div>

<?php
$titre = "PDO-cinema";
$titre_secondaire = "Home";
$contenu = ob_get_clean();

require "view/template.php";
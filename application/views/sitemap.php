<?= '<?xml version="1.0" encoding="UTF-8" ?>' ?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc><?= $my_url;?></loc>
        <priority>1.0</priority>
        <changefreq>daily</changefreq>
        <lastmod><?=$lastmod_main?></lastmod>
    </url>
    <url>
        <loc><?= $my_url."coches-segunda-mano";?></loc>
        <priority>1.0</priority>
        <changefreq>hourly</changefreq>
        <lastmod><?=$lastmod?></lastmod>
    </url>
    <url>
        <loc><?= $my_url."coches-segunda-mano/granada";?></loc>
        <priority>1.0</priority>
        <changefreq>hourly</changefreq>
        <lastmod><?=$lastmod?></lastmod>
    </url>
    <url>
        <loc><?= $my_url."coches-segunda-mano/malaga";?></loc>
        <priority>1.0</priority>
        <changefreq>hourly</changefreq>
        <lastmod><?=$lastmod?></lastmod>
    </url>
    <url>
        <loc><?= $my_url."coches-segunda-mano/sevilla";?></loc>
        <priority>1.0</priority>
        <changefreq>hourly</changefreq>
        <lastmod><?=$lastmod?></lastmod>
    </url>
    <url>
        <loc><?= $my_url."coches-segunda-mano/madrid";?></loc>
        <priority>1.0</priority>
        <changefreq>hourly</changefreq>
        <lastmod><?=$lastmod?></lastmod>
    </url>
    <url>
        <loc><?= $my_url."motos-segunda-mano";?></loc>
        <priority>1.0</priority>
        <changefreq>hourly</changefreq>
        <lastmod><?=$lastmod?></lastmod>
    </url>
    <url>
        <loc><?= $my_url."renting-particulares-empresas";?></loc>
        <priority>0.7</priority>
    </url>
    <url>
        <loc><?= $my_url."compramos-tu-coche";?></loc>
        <priority>0.7</priority>
    </url>
    <url>
        <loc><?= $my_url."compramos-tu-moto";?></loc>
        <priority>0.7</priority>
    </url>

    <url>
        <loc><?= $my_url."garantia-coches-segunda-mano";?></loc>
        <priority>0.6</priority>
    </url>

    <url>
        <loc><?= $my_url."conocenos/preguntas-frecuentes-coches-segunda-mano";?></loc>
        <priority>0.6</priority>
    </url>
    <url>
        <loc><?= $my_url."contacto";?></loc>
        <priority>0.6</priority>
    </url>
    <url>
        <loc><?= $my_url."conocenos/preguntas-frecuentes-coches-segunda-mano";?></loc>
        <priority>0.6</priority>
    </url>


    <url>
        <loc><?= $my_url."noticias-motor";?></loc>
        <priority>0.5</priority>
    </url>
    <url>
        <loc><?= $my_url."conocenos/quienes-somos";?></loc>
        <priority>0.5</priority>
    </url>
    <url>
        <loc><?= $my_url."conocenos/nuestros-clientes";?></loc>
        <priority>0.5</priority>
    </url>
    <url>
        <loc><?= $my_url."conocenos/nuestras-instalaciones-granada-malaga-sevilla";?></loc>
        <priority>0.5</priority>
    </url>

    <!-- My code is looking quite different, but the principle is similar-->
    <?php foreach($ciudades as $c) { ?>
    <url>
        <loc><?= $my_url."coches-segunda-mano-".$c?></loc>
        <priority>0.9</priority>
        <changefreq>hourly</changefreq>
        <lastmod><?=$lastmod?></lastmod>
    </url>
    <?php } ?>

    <!-- My code is looking quite different, but the principle is similar-->
    <?php foreach($coches as $v) { ?>
    <url>
        <loc><?= $my_url.(($v['veh_segmento']!=8)?"coches-segunda-mano":"moto-segunda-mano")."/".url_title($v['veh_marca']."-".$v['veh_modelo']."-".$v['veh_acabado'])."/".$v['vehiculo_id']?></loc>
        <priority><?= (($v['veh_destacado']==1)?"0.8":"0.7")?></priority>
    </url>
    <?php } ?>

    <?php foreach($contenidoSEO as $p) { ?>
    <url>
        <loc><?=$my_url.$p['noticia_url']?></loc>
        <priority>0.5</priority>
    </url>
    <?php } ?>

    <?php foreach($blogs as $p) { ?>
    <url>
        <loc><?=$my_url."noticias-motor/".convert_accented_characters(url_title($p['noticia_titulo']))."/".$p['noticia_id']?></loc>
        <priority>0.5</priority>
    </url>
    <?php } ?>


</urlset>

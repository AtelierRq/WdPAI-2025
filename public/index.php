<?php


require_once 'Routing.php';

$path = trim($_SERVER["REQUEST_URI"],"/");
$path = parse_url($path, PHP_URL_PATH);

Routing::run($path);

# echo $path;

# var_dump($path);


#kody http
#100
#200 
#300
#400 np. 404
#500


echo "
<script>
    const header = document.querySelector('h1');
    console.log(header);
    header.addEventListener('click', () => {
        header.style.color = 'green';
    })
</script>
";


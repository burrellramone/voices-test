<!DOCTYPE html>
<html lang="en">
     <head>
        <meta charset="utf-8" />
        <title><?=$page_title?> - Voices Test</title>
        <link rel="stylesheet" type="text/css" href="/assets/style.css" />
        <link rel="icon" href="favicon.ico" type="image/x-icon" />
        
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, minimum-scale=1, maximum-scale=1" />
        <meta name="mobile-web-app-capable" content="yes" />
        <meta name="apple-mobile-web-app-capable" content="yes" />
    </head>
    <body>
        <header class="header">Voices Test</header>
        <main>
            <div class="container">
                <h1 class="page-title"><?=$page_title?></h1>
                <?=$template?>
            </div>
        </main>
        <footer class="footer">
            <small class="copyright">&copy; <?=date("Y")?> Voices Test</small>
        </footer>
    </body>
    <script type="text/javascript" src="/assets/app.js"></script>
</html>
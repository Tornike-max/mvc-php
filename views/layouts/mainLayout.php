<?php

use app\core\Application;

echo '<pre>';
var_dump(Application::$app->user);
echo '</pre>';

?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">Navbar</a>

            <div style='display:flex; align-items: center; justify-content:space-between;' class="collapse navbar-collapse" id="navbarSupportedContent">

                <ul class="navbar-nav mr-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/contact">Contact</a>
                    </li>
                </ul>
                <?php if (!Application::isGuest()) : ?>
                    <ul style="display: flex; align-items:center;" class="navbar-nav mr-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="/register">Register</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/login">Login</a>
                        </li>
                    </ul>
                <?php endif; ?>

                <?php if (Application::isGuest()) : ?>
                    <ul style="display: flex; align-items:center;" class="navbar-nav mr-auto mb-2 mb-lg-0">
                        <li class="nav-item active">
                            <a class="nav-link" href="/profile">Profile</a>
                        </li>
                        <li class="nav-item active">
                            <?php echo Application::$app->user->getDisplayName() ?? '' ?>
                        </li>
                        <li style="margin-left: 10px;" class="nav-item active">
                            <a class="nav-link" href="/logout">Logout</a>
                        </li>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    <div class="container">
        <?php if (Application::isGuest()) : ?>
            <div class="alert alert-success">
                <?php echo Application::$app->session->getFlash('success') ?>
            </div>
        <?php endif; ?>
        {{content}}
    </div>
</body>

</html>
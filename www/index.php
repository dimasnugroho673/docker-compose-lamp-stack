<!doctype html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Docker - LAMP74 STACK</title>

    <link rel="shortcut icon" href="assets/images/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container">
            <a id="server-addr" class="nav-link font-monospace" aria-current="page" href="#"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle btn-icon-theme" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"></a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item btn-change-theme" href="#" data-set-theme="light"><i class="bi bi-brightness-high-fill me-2"></i> Light</a></li>
                            <li><a class="dropdown-item btn-change-theme" href="#" data-set-theme="dark"><i class="bi bi-moon-fill me-2"></i> Dark</a></li>
                            <li><a class="dropdown-item btn-change-theme" href="#" data-set-theme="auto"><i class="bi bi-circle-half me-2"></i> Auto</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="p-5 mb-4 bg-body-tertiary">
        <div class="container py-5">
            <h1 class="display-5 fw-bold">Local environment LAMP STACK</h1>
            <p class="col-md-8 fs-4">Selamat datang di local environment. Stack ini menggunakan <?= apache_get_version(); ?>, PHP <?= phpversion(); ?>, MySQL, dan phpMyAdmin.</p>
            <!-- <button class="btn btn-primary btn-lg" type="button">Example button</button> -->
        </div>
    </div>
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-8">
                <section class="mb-5">
                    <h2 class="fw-bold">Active Sites</h2>
                    <div class="input-group flex-nowrap mt-3 mb-4 w-75">
                        <span class="input-group-text" id="addon-wrapping"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control" id="input-sites" placeholder="Search active sites...">
                    </div>
                    <?php
                    $directories = scandir('./');
                    $directories = array_diff($directories, array('.', '..', 'assets', '.DS_Store', 'vendor', 'test_db.php', 'test_db_pdo.php', 'phpinfo.php', 'index.php', 'favicon.png', 'composer.json', 'composer.lock'));
                    $directories = array_values($directories);
                    ?>
                    <div id="card-active-dir">
                    </div>
                </section>
                <section class="mb-5">
                    <h2 class="fw-bold">Testing Sites</h2>
                    <div id="card-testing-dir">
                    </div>
                </section>
                <section class="mb-5">
                    <h2 class="fw-bold">Template Sites</h2>
                    <div id="card-template-dir">
                    </div>
                </section>
                <section class="mb-5">
                    <h2 class="fw-bold">Other PHP Files</h2>
                    <div id="card-phpfiles-dir">
                    </div>
                </section>
            </div>
            <div class="col-md-4">
                <section class="mb-5">
                    <h2 class="fw-bold">Shortcut Link</h2>
                    <div id="card-shortcut-dir">
                        <a href="http://<? print $_ENV['SERVER_ADDR']; ?>:<? print $_ENV['PMA_PORT']; ?>" target="_blank" rel="noopener noreferrer" class="font-monospace text-decoration-none">phpMyAdmin <i class="bi bi-table"></i></a><br>
                        <a href="test_db.php" class="font-monospace text-decoration-none">Check DB connection (MySQLi) <i class="bi bi-database-fill"></i></a> <br>
                        <a href="test_db_pdo.php" class="font-monospace text-decoration-none">Check DB connection (PDO) <i class="bi bi-database-fill"></i></a> <br>
                        <a href="phpinfo.php" class="font-monospace text-decoration-none">PHP Info <i class="bi bi-filetype-php"></i></a> <br>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <footer class="mt-5 py-3 text-center">
        <small class="text-muted">© Copyright <?= date('Y') ?> Local environment by Docker Container</small>
    </footer>
    <script>
        $(document).ready(() => {
            const getPreferredTheme = () => {
                const storedTheme = localStorage.getItem('lamp-local-theme')
                if (storedTheme) {
                    return storedTheme
                }
                return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'
            }
            const setTheme = function(theme) {
                if (theme === 'auto' && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                    document.documentElement.setAttribute('data-bs-theme', 'dark')
                    $('.btn-icon-theme').html('<i class="bi bi-circle-half"></i>')
                    localStorage.setItem('lamp-local-theme', theme)
                } else {
                    document.documentElement.setAttribute('data-bs-theme', theme)
                    $('.btn-icon-theme').html(theme == 'dark' ? '<i class="bi bi-moon-fill"></i>' : '<i class="bi bi-brightness-high-fill"></i>')
                    localStorage.setItem('lamp-local-theme', theme)
                }
            }
            switch (getPreferredTheme()) {
                case 'dark':
                    $('.btn-icon-theme').html('<i class="bi bi-moon-fill"></i>')
                    setTheme(getPreferredTheme())
                    break;
                case 'light':
                    $('.btn-icon-theme').html('<i class="bi bi-brightness-high-fill"></i>')
                    setTheme(getPreferredTheme())
                    break;
                default:
                    break;
            }
            if (getPreferredTheme() === 'auto' && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                setTheme(getPreferredTheme())
                $('.btn-icon-theme').html('<i class="bi bi-circle-half"></i>')
            } else {
                setTheme(getPreferredTheme())
                $('.btn-icon-theme').html('<i class="bi bi-brightness-high-fill"></i>')
            }
            $('.btn-change-theme').click(function() {
                setTheme($(this).data('set-theme'))
            })
            $('#server-addr').text('Server: ' + window.location.host)
            let directories = '<?= json_encode($directories) ?>'
            directories = JSON.parse(directories)
            let activeDir = directories.filter(dir => {
                if (dir.split('.')[1] == undefined) {
                    return dir
                }
            })
            let testingDir = directories.filter(dir => {
                if (dir.split('.')[1] == 'test') {
                    return dir
                }
            })
            let templateDir = directories.filter(dir => {
                if (dir.split('.')[1] == 'mockview') {
                    return dir
                }
            })
            let phpFileDir = directories.filter(dir => {
                if (dir.split('.')[1] == 'php') {
                    return dir
                }
            })
            let filteredDir = activeDir
            $('#input-sites').keyup((e) => {
                let keyword = e.target.value.toLowerCase()
                if (keyword == '') {
                    filteredDir = activeDir
                }
                filteredDir = activeDir.filter((dir) => {
                    return dir.toLowerCase().includes(keyword)
                })
                renderDir()
            })
            renderDir()

            function renderDir() {
                let activeDirRow = ''
                let testingDirRow = ''
                let templateDirRow = ''
                let phpFileRow = ''

                filteredDir.forEach(dir => {
                    activeDirRow += `<a href="${dir}" class="font-monospace text-decoration-none">${dir} <i class="bi bi-box-arrow-up-right"></i></a> <br>`
                })
                testingDir.forEach(dir => {
                    testingDirRow += `<a href="${dir}" class="font-monospace text-decoration-none">${dir} <i class="bi bi-box-arrow-up-right"></i></a> <br>`
                })
                templateDir.forEach(dir => {
                    templateDirRow += `<a href="${dir}" class="font-monospace text-decoration-none">${dir} <i class="bi bi-box-arrow-up-right"></i></a> <br>`
                })
                phpFileDir.forEach(dir => {
                    phpFileRow += `<a href="${dir}" class="font-monospace text-decoration-none">${dir} <i class="bi bi-box-arrow-up-right"></i></a> <br>`
                })
                $('#card-active-dir').html(activeDirRow)
                $('#card-testing-dir').html(testingDirRow)
                $('#card-template-dir').html(templateDirRow)
                $('#card-phpfiles-dir').html(phpFileRow)
            }
        })
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>

</html>
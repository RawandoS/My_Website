<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Main Page</title>

        <script src="<?php echo BASE_URL?>/public/assets/js/color-modes.js"></script>
        <link href="<?php echo BASE_URL?>/public/assets/css/bootstrap.min.css" rel="stylesheet" />
        <meta name="theme-color" content="#712cf9" />
        <link href="<?php echo BASE_URL?>/public/assets/css/headers.css" rel="stylesheet" />
        <link href="<?php echo BASE_URL?>/public/assets/css/suggestion.css" rel="stylesheet" />
        <style>
            .bd-placeholder-img {
                font-size: 1.125rem;
                text-anchor: middle;
                -webkit-user-select: none;
                -moz-user-select: none;
                user-select: none;
            }
            @media (min-width: 768px) {
                .bd-placeholder-img-lg {
                    font-size: 3.5rem;
                }
            }
            .b-example-divider {
                width: 100%;
                height: 3rem;
                background-color: #0000001a;
                border: solid rgba(0, 0, 0, 0.15);
                border-width: 1px 0;
                box-shadow: inset 0 0.5em 1.5em #0000001a, inset 0 0.125em 0.5em #00000026;
            }
            .b-example-vr {
                flex-shrink: 0;
                width: 1.5rem;
                height: 100vh;
            }
            .bi {
                vertical-align: -0.125em;
                fill: currentColor;
            }
            .nav-scroller {
                position: relative;
                z-index: 2;
                height: 2.75rem;
                overflow-y: hidden;
            }
            .nav-scroller .nav {
                display: flex;
                flex-wrap: nowrap;
                padding-bottom: 1rem;
                margin-top: -1px;
                overflow-x: auto;
                text-align: center;
                white-space: nowrap;
                -webkit-overflow-scrolling: touch;
            }
            .btn-bd-primary {
                --bd-violet-bg: #712cf9;
                --bd-violet-rgb: 112.520718, 44.062154, 249.437846;
                --bs-btn-font-weight: 600;
                --bs-btn-color: var(--bs-white);
                --bs-btn-bg: var(--bd-violet-bg);
                --bs-btn-border-color: var(--bd-violet-bg);
                --bs-btn-hover-color: var(--bs-white);
                --bs-btn-hover-bg: #6528e0;
                --bs-btn-hover-border-color: #6528e0;
                --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
                --bs-btn-active-color: var(--bs-btn-hover-color);
                --bs-btn-active-bg: #5a23c8;
                --bs-btn-active-border-color: #5a23c8;
            }
            .bd-mode-toggle {
                z-index: 1500;
            }
            .bd-mode-toggle .bi {
                width: 1em;
                height: 1em;
            }
            .bd-mode-toggle .dropdown-menu .active .bi {
                display: block !important;
            }
        </style>
    </head>
    <body>
        <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
            <a href="" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
                <svg class="bi me-2" width="40" height="32" aria-hidden="true"><use xlink:href="#bootstrap"></use></svg> <span class="fs-4">My Website</span>
            </a>
            <ul class="nav nav-pills">
                <li class="nav-item"><a href="<?php echo BASE_URL?>/coverShow" class="nav-link" aria-current="page">AlbumCovers</a></li>
                <li class="nav-item"><a href="<?php echo BASE_URL?>/main" class="nav-link active">Main Page</a></li>
                <li class="nav-item"><a href="<?php echo BASE_URL?>/datatable" class="nav-link">Datatables</a></li>
                <?php if($_SESSION['isAdmin']): ?>
                <li class="nav-item"><a href="<?php echo BASE_URL?>/adminDatabase" class="nav-link">Admin</a></li>
                <?php endif;?>
                <li class="nav-item"><a href="<?php echo BASE_URL?>/accountPage" class="nav-link">AccountPage</a></li>
            </ul>
        </header>
        <main class="container mt-4">
            <h1 class="text-center mb-4">Hello <?php echo $_SESSION['user']?></h1>
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h2 class="card-title text-center mb-4">Suggestion Box</h2>
                            <form action="" method="post">
                                <div class="mb-3">
                                    <label for="suggestion" class="form-label">Make a suggestion to the Admins:</label>
                                    <input type="text" class="form-control" id="suggestion" name="suggestion" placeholder="Enter your suggestion here...">
                                </div>
                                <div class="d-grid">
                                    <button type="submit" name="submit" class="btn btn-primary">Send to Admins</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
            <div class="col-md-4 d-flex align-items-center">
                <a href="/" class="mb-3 me-2 mb-md-0 text-body-secondary text-decoration-none lh-1" aria-label="Bootstrap">
                    <svg class="bi" width="30" height="24" aria-hidden="true"><use xlink:href="#bootstrap"></use></svg>
                </a>
                <span class="mb-3 mb-md-0 text-body-secondary">&copy; 2025 Company, Inc</span>
            </div>
            <ul class="nav col-md-4 justify-content-end list-unstyled d-flex">
                <li class="ms-3">
                    <a class="text-body-secondary" href="#" aria-label="Instagram">
                        <svg class="bi" width="24" height="24" aria-hidden="true"><use xlink:href="#instagram"></use></svg>
                    </a>
                </li>
                <li class="ms-3">
                    <a class="text-body-secondary" href="#" aria-label="Facebook">
                        <svg class="bi" width="24" height="24"><use xlink:href="#facebook"></use></svg>
                    </a>
                </li>
            </ul>
        </footer>
    </body>
</html>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Main Page</title>

        <script src="<?php echo BASE_URL?>/public/assets/js/color-modes.js"></script>
        <link href="<?php echo BASE_URL?>/public/assets/css/bootstrap.min.css" rel="stylesheet" />
        <meta name="theme-color" content="#712cf9" />
        <link href="headers.css" rel="stylesheet" />
        <link href="checkout.css" rel="stylesheet" />
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
            .row label{
                margin-left: 10px;
            }
            .needs-validation{
                width: 50%;
                margin-left : 40%
            }
            .uploadImg {
                align-self: center;
                display: block;
                border-radius: 8px;
                max-width:128px;
                max-height:128px;
                width: auto;
                height: auto;
                margin: auto;
            }
            .flex-grow-1 {
                flex: 1 1 auto;
            }
            .form-narrow {
                max-width: 500px;
                width: 100%;
            }
            .content-center {
                display: flex;
                flex-direction: column;
                justify-content: center;
                min-height: calc(100vh - 112px);
            }
        </style>
    </head>
    <body>
        <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
            <a href="" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
                <span class="fs-4">My Website</span>
            </a>
            <ul class="nav nav-pills">
                <li class="nav-item"><a href="<?php echo BASE_URL?>/coverShow" class="nav-link" aria-current="page">AlbumCovers</a></li>
                <li class="nav-item"><a href="<?php echo BASE_URL?>/main" class="nav-link active">Main Page</a></li>
                <li class="nav-item"><a href="<?php echo BASE_URL?>/datatable" class="nav-link">Datatables</a></li>
                <?php if($_SESSION['isAdmin']): ?>
                <li class="nav-item"><a href="<?php echo BASE_URL?>/admin" class="nav-link">Admin</a></li>
                <?php endif;?>
                <li class="nav-item"><a href="<?php echo BASE_URL?>/accountPage" class="nav-link">ModifyAlbum</a></li>
            </ul>
        </header>
        <main>
            <div class="py-5 text-center">
                <img class="d-block mx-auto mb-4" src="http://localhost/public/assets/images/defaultVinyl.png" alt="" width="64" height="64" />
                <h1 class="h2">Modify Album</h1>
            </div>
            <div class="row ">
                <div class="col-md-7 col-lg-8 text-center">
                    <h4 class="mb-3 ">Album values</h4>
                    <form class="needs-validation" method="post" enctype="multipart/form-data">
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <label for="firstName" class="form-label">Title</label>
                                <input type="text" class="form-control" name="title" id="title" placeholder="" value="<?php echo $data['title']?>" required />
                                <div class="invalid-feedback">
                                    Valid title is required.
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="lastName" class="form-label">Artists</label>
                                <input type="text" class="form-control" name="artists" id="lastName" placeholder="" value="<?php echo $data['artists']?>" required />
                                <div class="invalid-feedback">
                                    Valid last name is required.
                                </div>
                            </div>
                            <div class="col-12">
                                <label for="username" class="form-label">Year</label>
                                <input type="text" class="form-control" min="1000" max="2100" name="year" id="username" placeholder="" value="<?php echo $data['year']?>" required />
                                <div class="invalid-feedback">
                                    Your username is required.
                                </div>
                            </div>
                            <div class="col-12">
                                <label for="address" class="form-label">Genres</label>
                                <input type="text" class="form-control" name="genres" id="address" placeholder="" value="<?php echo $data['genres']?>" required />
                                <div class="invalid-feedback">
                                    Please enter your shipping address.
                                </div>
                            </div>
                            <div class="col-12">
                                <label for="address" class="form-label">Styles</label>
                                <input type="text" class="form-control" name="styles" id="address" placeholder="" value="<?php echo $data['styles']?>" required />
                                <div class="invalid-feedback">
                                    Please enter your shipping address.
                                </div>
                            </div>
                            <div class="col-12">
                                <label for="address" class="form-label">Lables</label>
                                <input type="text" class="form-control" name="labels" id="address" placeholder="" value="<?php echo $data['labels']?>" required />
                                <div class="invalid-feedback">
                                    Please enter your shipping address.
                                </div>
                            </div>
                            <div class="col-12">
                                <label for="address" class="form-label">Track Names</label>
                                <input type="text" class="form-control" name="trackNames" id="address" placeholder="" value="<?php echo $data['trackNames']?>" required />
                                <div class="invalid-feedback">
                                    Please enter your shipping address.
                                </div>
                            </div>
                            <div class="col-12">
                                <label for="address" class="form-label">Track Times</label>
                                <input type="text" class="form-control" name="trackTimes" id="address" placeholder="" value="<?php echo $data['trackTimes']?>" required />
                                <div class="invalid-feedback">
                                    Please enter your shipping address.
                                </div>
                            </div>
                            <div class="col-12">
                                <label for="address" class="form-label">Album Lenght</label>
                                <input type="text" class="form-control" name="albumTime" id="address" placeholder="" value="<?php echo $data['albumTime']?>" required />
                                <div class="invalid-feedback">
                                    Please enter your shipping address.
                                </div>
                            </div>
                            <div class="col-12">
                                <label for="address" class="form-label">Image</label><br>
                                <label for="fileInput">
                                    <img class="uploadImg" src="<?php echo $data['albumCoverPath'];?>" alt="No image found" style="pointer-events: none">
                                </label>
                                <input type="file" id="fileInput" name="fileInput" style="display: none;">
                            </div>
                        </div>
                        <hr class="my-4" />
                        <button class="w-100 btn btn-primary btn-lg" type="submit" name="submit value"submit">ModifyAlbum</button>
                    </form>
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
        <script src="<?php echo BASE_URL?>/assets/js/bootstrap.bundle.min.js" class="astro-vvvwv3sm"></script>
        <script src="checkout.js" class="astro-vvvwv3sm"></script>
    </body>
</html>
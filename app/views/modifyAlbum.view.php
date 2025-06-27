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
            .uploadImg {
                border-radius: 8px;
                max-width: 128px;
                max-height: 128px;
                width: auto;
                height: auto;
                cursor: pointer;
                transition: transform 0.2s;
            }
            .uploadImg:hover {
                transform: scale(1.05);
            }
            .form-container {
                max-width: 800px;
                margin: 0 auto;
            }
        </style>
    </head>
    <body>
        <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
            <a href="" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
                <span class="fs-4">My Website</span>
            </a>
            <ul class="nav nav-pills">
                <li class="nav-item"><a href="<?php echo BASE_URL?>/coverShow" class="nav-link">AlbumCovers</a></li>
                <li class="nav-item"><a href="<?php echo BASE_URL?>/main" class="nav-link active">Main Page</a></li>
                <li class="nav-item"><a href="<?php echo BASE_URL?>/datatable" class="nav-link">Datatables</a></li>
                <?php if($_SESSION['isAdmin']): ?>
                <li class="nav-item"><a href="<?php echo BASE_URL?>/adminDatabase" class="nav-link">Admin</a></li>
                <?php endif;?>
                <li class="nav-item"><a href="<?php echo BASE_URL?>/accountPage" class="nav-link">ModifyAlbum</a></li>
            </ul>
        </header>
        <main class="container">
            <div class="py-5 text-center">
                <img class="d-block mx-auto mb-4" src="http://localhost/public/assets/images/defaultVinyl.png" alt="" width="64" height="64">
                <h2>Modify Album</h2>
            </div>
            <div class="form-container">
                <form class="needs-validation" method="post" enctype="multipart/form-data" novalidate>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="title" id="title" value="<?php echo $data['title']?>" required>
                                <label for="title">Title</label>
                                <div class="invalid-feedback">Please enter a valid title.</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="artists" value="<?php echo $data['artists']?>" required>
                                <label>Artists</label>
                                <div class="invalid-feedback">Please enter valid artists.</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="number" class="form-control" name="year" min="1000" max="2100" value="<?php echo $data['year']?>" required>
                                <label>Year</label>
                                <div class="invalid-feedback">Please enter a valid year.</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="genres" value="<?php echo $data['genres']?>" required>
                                <label>Genres</label>
                                <div class="invalid-feedback">Please enter valid genres.</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="styles" value="<?php echo $data['styles']?>" required>
                                <label>Styles</label>
                                <div class="invalid-feedback">Please enter valid styles.</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="labels" value="<?php echo $data['labels']?>" required>
                                <label>Labels</label>
                                <div class="invalid-feedback">Please enter valid labels.</div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="trackNames" value="<?php echo $data['trackNames']?>" required>
                                <label>Track Names</label>
                                <div class="invalid-feedback">Please enter valid track names.</div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="trackTimes" value="<?php echo $data['trackTimes']?>" required>
                                <label>Track Times</label>
                                <div class="invalid-feedback">Please enter valid track times.</div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="albumTime" value="<?php echo $data['albumTime']?>" required>
                                <label>Album Length</label>
                                <div class="invalid-feedback">Please enter valid album length.</div>
                            </div>
                        </div>
                        <div class="col-12 text-center">
                            <label class="d-block mb-2">Album Cover</label>
                            <label for="fileInput" class="d-inline-block">
                                <img class="uploadImg img-thumbnail" src="<?php echo $data['albumCoverPath'];?>" alt="Album cover">
                            </label>
                            <input type="file" id="fileInput" name="fileInput" class="d-none">
                        </div>
                    </div>
                    <hr class="my-4">
                    <button class="w-100 btn btn-primary btn-lg" type="submit">Modify Album</button>
                </form>
            </div>
        </main>
        <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
            <div class="col-md-4 d-flex align-items-center">
                <a href="/" class="mb-3 me-2 mb-md-0 text-body-secondary text-decoration-none lh-1">
                    <svg class="bi" width="30" height="24"><use xlink:href="#bootstrap"></use></svg>
                </a>
                <span class="mb-3 mb-md-0 text-body-secondary">&copy; 2025 Company, Inc</span>
            </div>
            <ul class="nav col-md-4 justify-content-end list-unstyled d-flex">
                <li class="ms-3">
                    <a class="text-body-secondary" href="#">
                        <svg class="bi" width="24" height="24"><use xlink:href="#instagram"></use></svg>
                    </a>
                </li>
                <li class="ms-3">
                    <a class="text-body-secondary" href="#">
                        <svg class="bi" width="24" height="24"><use xlink:href="#facebook"></use></svg>
                    </a>
                </li>
            </ul>
        </footer>
        <script src="<?php echo BASE_URL?>/public/assets/js/bootstrap.bundle.min.js"></script>
        <script src="<?php echo BASE_URL?>/public/assets/js/modifyAlbum.js"></script>
    </body>
</html>
```
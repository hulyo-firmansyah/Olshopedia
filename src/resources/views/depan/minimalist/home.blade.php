<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('template_depan/minimalist/modules/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template_depan/minimalist/css/style.css') }}">
    <title>Hello, world!</title>
  </head>
  <body>
    <nav class="nav d-flex justify-content-center fixed-top bd-highlight">
        <a href="#" class="nav-brand">Logo</a>
        <ul>
            <li><a href="#" id="orderBtn"><i class="fas fa-sort-amount-down"></i></a></li>
            <li><a href="#" id="searchBtn"><i class="fas fa-search"></i></a></li>
            <li><a class="profile" id="profileBtn" href="#"><i class="fas fa-user"></i></a></li>
        </ul>
    </nav>

    <div class="container">
        <div class="content">
            <section class="image">
                <!-- Yoko Kara Miru Ka -->
                <img src="img/bg.jpg" alt="">
            </section>
            <section class="main">
                <div class="brand text-center">
                    Toko Kocak
                </div>
                <div class="button-section">
                    <div class="button">
                        <a href="#"><i class="fas fa-star"></i></a>
                        <div class="title">
                            Rating
                        </div>
                    </div>
                    <div class="button">
                        <a href="#"><i class="fas fa-store-alt"></i></a>
                        <div class="title">
                            Info Toko
                        </div>
                    </div>
                    <div class="button">
                        <a href="#"><i class="fas fa-sort"></i></a>
                        <div class="title">
                            Blog
                        </div>
                    </div>
                </div>
            </section>
            <hr>
            <section class="product">
                <div class="row justify-content-center">
                    <div class="col-6 col-sm-6 col-md-3 col-lg-3 item mb-3">
                        <a href="#" class="card-link">
                            <div class="card item-card card-block">
                                <img src="img/patung.jpg" alt="Photo of sunset">
                                <h5 class="card-title mt-3 mb-3">ProVyuh</h5>
                                <p class="card-text text-muted">Rp. 5000</p>
                                <div class="text-center border-top">
                                    <small class="text-muted">Lihat Produk</small>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 col-sm-6 col-md-3 col-lg-3 item mb-3">
                        <a href="#" class="card-link">
                            <div class="card item-card card-block">
                                <img src="img/patung.jpg" alt="Photo of sunset">
                                <h5 class="card-title mt-3 mb-3">ProVyuh</h5>
                                <p class="card-text text-muted">Rp. 5000</p>
                                <div class="text-center border-top">
                                    <small class="text-muted">Lihat Produk</small>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 col-sm-6 col-md-3 col-lg-3 item mb-3">
                        <a href="#" class="card-link">
                            <div class="card item-card card-block">
                                <img src="img/patung.jpg" alt="Photo of sunset">
                                <h5 class="card-title mt-3 mb-3">ProVyuh</h5>
                                <p class="card-text text-muted">Rp. 5000</p>
                                <div class="text-center border-top">
                                    <small class="text-muted">Lihat Produk</small>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 col-sm-6 col-md-3 col-lg-3 item mb-3">
                        <a href="#" class="card-link">
                            <div class="card item-card card-block">
                                <img src="img/patung.jpg" alt="Photo of sunset">
                                <h5 class="card-title mt-3 mb-3">ProVyuh</h5>
                                <p class="card-text text-muted">Rp. 5000</p>
                                <div class="text-center border-top">
                                    <small class="text-muted">Lihat Produk</small>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <!-- Order Modal -->
    <div class="modal fade" id="orderByModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header" style="border:none">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Urutkan Produk Berdasarkan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <button type="button" class="btn btn-sm btn-danger" ><i class="fas fa-check mr-2" style="font-size: 12px;"></i>Semua</button>
                    <button type="button" class="btn btn-sm btn-secondary disabled" >Tersedia</button>
                    <div class="list-group mt-4">
                        <a href="#" class="list-group-item list-group-item-action active d-flex justify-content-between align-items-center">
                        Cras justo odio 
                        <i class="fas fa-check mr-2" style="font-size: 12px;"></i>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">Dapibus ac facilisis in</a>
                        <a href="#" class="list-group-item list-group-item-action">Morbi leo risus</a>
                        <a href="#" class="list-group-item list-group-item-action">Porta ac consectetur ac</a>
                        <a href="#" class="list-group-item list-group-item-action disabled" tabindex="-1" aria-disabled="true">Vestibulum at eros</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search Modal -->
    <div class="modal fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content pt-3">
                <div class="modal-body">
                    <div class="form-group has-search">
                        <span class="fa fa-search form-control-feedback"></span>
                        <input type="text" class="form-control" placeholder="Search">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function(){
            $('#orderBtn').on('click', function(){
                $('#orderByModal').modal('show');
            })
            $('#searchBtn').on('click', function(){
                $('#searchModal').modal('show');
            })
        })
    </script>
  </body>
</html>
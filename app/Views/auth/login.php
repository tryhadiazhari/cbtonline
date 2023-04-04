<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title; ?></title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/assets/plugins/fontawesome/css/all.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/assets/dist/css/adminlte.min.css">
    <link rel="stylesheet" type="text/css" href="/assets/plugins/animate/animate.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="<?= base_url() ?>/assets/plugins/toastr/toastr.min.css">

    <style>
        :root {
            --input-padding-x: 1.5rem;
            --input-padding-y: 0.75rem;
        }

        .form-control.is-invalid,
        .was-validated .form-control:invalid {
            border-color: #dc3545;
            padding-right: 2.25rem;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='none' stroke='%23dc3545' viewBox='0 0 12 12'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right calc(3em + 0.1875rem) center;
            background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
        }

        .login-page {
            background-color: #ffffff;
        }

        .judul {
            position: absolute;
            right: 20px;
            top: 20px;
            z-index: 2;
            color: #000;
        }

        .login,
        .image {
            min-height: 100vh;
        }

        .bg-image {
            background-image: url('/assets/dist/img/bg.jpg');
            background-size: cover;
            background-position: center;
        }

        .login-heading {
            font-weight: 300;
        }

        .btn-login {
            font-size: 0.9rem;
            letter-spacing: 0.05rem;
            padding: 0.75rem 1rem;
            border-radius: 2rem;
        }

        .form-label-group {
            position: relative;
            margin-bottom: 1rem;
        }

        .form-label-group>input,
        .form-label-group>label {
            padding: var(--input-padding-y) var(--input-padding-x);
            height: auto;
            border-radius: 2rem;
        }

        .form-label-group>label {
            position: absolute;
            top: 0;
            left: 0;
            display: block;
            width: 100%;
            margin-bottom: 0;
            /* Override default `<label>` margin */
            line-height: 1.5;
            color: #495057;
            cursor: text;
            /* Match the input under the label */
            border: 1px solid transparent;
            border-radius: .25rem;
            transition: all .1s ease-in-out;
        }

        .form-label-group input::-webkit-input-placeholder {
            color: transparent;
        }

        .form-label-group input:-ms-input-placeholder {
            color: transparent;
        }

        .form-label-group input::-ms-input-placeholder {
            color: transparent;
        }

        .form-label-group input::-moz-placeholder {
            color: transparent;
        }

        .form-label-group input::placeholder {
            color: transparent;
        }

        .form-label-group input:not(:placeholder-shown) {
            padding-top: calc(var(--input-padding-y) + var(--input-padding-y) * (2 / 3));
            padding-bottom: calc(var(--input-padding-y) / 3);
        }

        .form-label-group input:not(:placeholder-shown)~label {
            padding-top: calc(var(--input-padding-y) / 3);
            padding-bottom: calc(var(--input-padding-y) / 3);
            font-size: 12px;
            color: #777;
        }

        /* Fallback for Edge
-------------------------------------------------- */

        @supports (-ms-ime-align: auto) {
            .form-label-group>label {
                display: none;
            }

            .form-label-group input::-ms-input-placeholder {
                color: #777;
            }
        }

        /* Fallback for IE
-------------------------------------------------- */

        @media all and (-ms-high-contrast: none),
        (-ms-high-contrast: active) {
            .form-label-group>label {
                display: none;
            }

            .form-label-group input:-ms-input-placeholder {
                color: #777;
            }
        }
    </style>
</head>

<body class="hold-transition login-page">
    <div class="container-fluid">
        <div class="row no-gutter">
            <div class="d-none d-md-flex col-md-6 col-lg-7 bg-image animate__animated animate__zoomIn"></div>
            <div class="col-md-6 col-lg-5">
                <div class="login d-flex align-items-center py-5">
                    <div class="container">
                        <div class="row">
                            <div class='judul'>&copy;
                                <a href="https://" class="txt2 hov1">
                                    <b><?= $developer ?></b>
                                </a>
                            </div>
                            <div class="col-md-9 col-lg-9 mx-auto">
                                <h1 class="animate__animated animate__flipInX py-2">
                                    <strong><?= $subtitle; ?></strong>
                                </h1>
                                <p class="mb-5 animate__animated animate__flipInX">Selamat datang di aplikasi <?= $subtitle ?>. Silahkan masukkan Username dan Password yang telah diberikan</p>

                                <form action="/auth/ceklogin" method="POST" id="formlogin" class="form-floating" autocomplete="off">
                                    <?= csrf_field(); ?>
                                    <div class="form-label-group mb-4 animate__animated animate__slideInLeft">
                                        <input type="text" id="inputUser" name="username" class="username form-control" placeholder="Username">
                                        <label for="inputUser">Username</label>
                                        <i class="fa fa-user fa-fw"></i>
                                        <div class="invalid-feedback error-username"></div>
                                    </div>

                                    <div class="form-label-group mb-4 animate__animated animate__slideInLeft">
                                        <input type="password" id="inputPassword" name="password" class="password form-control" placeholder="Password">
                                        <label for="inputPassword">Password</label>
                                        <i class="fa fa-eye fa-fw show-password"></i>
                                        <div class="invalid-feedback error-password"></div>
                                    </div>

                                    <button class="btn btn-lg btn-primary btn-block btn-login text-uppercase font-weight-bold mb-2 animate__animated animate__slideInUp" type="submit">Login</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="/assets/plugins/jquery/jquery.min.js"></script>
    <script src="/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/dist/js/adminlte.min.js"></script>
    <script src="/assets/plugins/inputmask/jquery.inputmask.min.js"></script>
    <script src="/assets/plugins/toastr/toastr.min.js"></script>
    <script>
        $(document).ready(function() {
            $(':input').inputmask({
                placeholder: '',
                regex: '[a-zA-Z0-9\\_]+$'
            });

            $('.show-password').on('click', function() {
                if ($(this).hasClass('fa-eye')) {
                    $('#inputPassword').attr('type', 'text');
                    $(this).removeClass('fa-eye').addClass('fa-eye-slash');
                } else {
                    $('#inputPassword').attr('type', 'password');
                    $(this).removeClass('fa-eye-slash').addClass('fa-eye');
                }
            })

            $('#formlogin').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: $(this).attr('action'),
                    type: $(this).attr('method'),
                    data: $(this).serialize(),
                    beforeSend: function() {
                        $('.btn-login').html('<i class="fas fa-spin fa-spinner"></i>');
                        $(".form-control").removeClass('is-invalid');
                    },
                    complete: function() {
                        $('.btn-login').html('Login');
                    },
                    statusCode: {
                        404: function(errors) {
                            $.each(errors.responseJSON, function(field, val) {
                                $("." + field).addClass('is-invalid');
                                $(".error-" + field).html('<i>' + val + '</i>');
                            })
                        },
                        400: function(errors) {
                            toastr.error(errors.responseJSON.errors);
                        },
                    },
                    success: function(response) {
                        toastr.success(response.success);
                        setTimeout(function() {
                            location.reload();
                        }, 0);
                    }
                });
                return false;
            });
        });
        <?php if (session()->getFlashdata('error')) : ?>
            toastr.error('<?= session()->getFlashdata('error') ?>');
        <?php elseif (session()->getFlashdata('success')) : ?>
            toastr.success("<?= session()->getFlashdata('success') ?>");
        <?php endif; ?>
    </script>
</body>

</html>
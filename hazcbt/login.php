<?php require("config/config.default.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Login | HAz CBT Online</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="favicon.ico" />
	<link rel="stylesheet" type="text/css" href="plugins/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="plugins/animate/animate.css">
	<link rel="stylesheet" type="text/css" href="plugins/fontawesome/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="dist/css/adminlte.min.css">
	<link rel="stylesheet" href="plugins/sweetalert2/sweetalert2.min.css">
	<style>
		:root {
			--input-padding-x: 1.5rem;
			--input-padding-y: 0.75rem;
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

<body>
	<header class="masthead">
		<div class="container-fluid">
			<div class="row no-gutters">
				<div class="col-md-12">
					<center><img src="/dist/img/logo.png" class="img img-responsive"></center>
				</div>
			</div>
		</div>
	</header>

	<div class="container-fluid">
		<?= $_SESSION['id_siswa'] ?>
		<div class="d-flex justify-content-center" style="margin-top: -70px">
			<div class="card col-lg-4" style="border-radius: 10px">
				<div class="card-body">
					<div class="mx-4 my-2">
						<h2 class="card-title">Selamat Datang</h2>
						<p class="mt-3 mb-4" style="line-height: 30px">Silahkan login dengan username dan password yang telah anda miliki.</p>
						<form action="/ceklogin" method="POST" id="formlogin" class="form-floating" autocomplete="off">
							<div class="form-label-group" style="margin-top: 30px">
								<input type="text" id="username" name="username" class="username form-control" placeholder="Username" autofocus>
								<label for="username">Username</label>
								<i class="fa fa-user fa-fw"></i>
								<div class="invalid-feedback error-username"></div>
							</div>

							<div class="form-label-group" style="margin-top: 30px">
								<input type="password" id="password" name="password" class="password form-control" placeholder="Password">
								<label for="password">Password</label>
								<i class="fa fa-eye fa-fw show-password"></i>
								<div class="invalid-feedback error-password"></div>
							</div>

							<div class="container-login100-form-btn py-0" style="margin-top: 30px">
								<div class="wrap-login100-form-btn">
									<div class="login100-form-bgbtn"></div>
									<button type="submit" class="login100-form-btn">Login</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>
	<script src="plugins/jquery/jquery.min.js"></script>
	<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="plugins/inputmask/jquery.inputmask.min.js"></script>
	<script>
		$(function() {
			$('#username').inputmask({
				placeholder: '',
				regex: '[A-Z\\d]+$'
			});
			$('#password').inputmask({
				placeholder: '',
				regex: '[A-Z\\d\\*]+$'
			});
		});

		$(document).ready(function() {
			$('.show-password').on('click', function() {
				if ($(this).hasClass('fa-eye')) {
					$('#password').attr('type', 'text');
					$(this).removeClass('fa-eye').addClass('fa-eye-slash');
				} else {
					$('#password').attr('type', 'password');
					$(this).removeClass('fa-eye-slash').addClass('fa-eye');
				}
			})

			$('#formlogin').on('submit', function(e) {
				e.preventDefault();

				$.ajax({
					url: $(this).attr('action'),
					type: 'POST',
					data: $(this).serialize(),
					dataType: "JSON",
					error: function(error) {
						if (error.status == 404) {
							$.each(error.responseJSON.error, function(field, val) {
								$('.' + field).addClass('is-invalid')
								$('.error-' + field).html(val);

								$('.fa-user, .show-password').css({
									'display': 'inline',
									'margin-right': '9px'
								});
							});
						} else {
							Swal.fire({
								icon: 'error',
								title: 'Oops...',
								html: '<h4>' + error.responseJSON.error + '</h4>',
								showConfirmButton: false,
								timer: 3000
							})
						}
					},
					success: function(response) {
						window.location = './';
					}
				})
			});

		});
	</script>
</body>

</html>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
	<section class="h-100">
		<div class="container h-100">
			<div class="row justify-content-sm-center h-100">
				<div class="col-xxl-4 col-xl-5 col-lg-5 col-md-7 col-sm-9">
					<div class="text-center">
						<img src="<?=base_url();?>assets/images/Logo_of_Tagudin,_Ilocos_Sur.png" alt="logo" width="160">
						<!-- <h2>E-Schedule MO</h2> -->
					</div>
					<div class="card shadow-lg py-3">
						<div class="card-body p-5">
							<h1 class="fs-2 card-title fw-bold mb-4">Login</h1>
							<form method="POST" action="<?=base_url();?>login/validate" class="needs-validation" autocomplete="off">
                                <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />
								<div class="mb-3">
									<label class="mb-2 text-muted" for="email">E-Mail Address</label>
									<input id="email" type="text" class="form-control" name="email" placeholder="Enter your email" required autofocus>
									<div class="invalid-feedback">
										Email is invalid
									</div>
								</div>

								<div class="mb-3">
									<div class="mb-2 w-100">
										<label class="text-muted" for="password">Password</label>
									</div>
									<input id="password" type="password" class="form-control" name="password" placeholder="Enter your password"  required>
								    <div class="invalid-feedback">
								    	Password is required
							    	</div>
								</div>

								<div class="d-flex align-items-center">
									<button type="submit" class="btn btn-primary ms-auto">
										Login
									</button>
								</div>
							</form>
						</div>

					</div>

                    <!-- Login errors displays here! -->
                    <?php if(!empty($this->session->flashdata('input_errors'))){ ?>    
                    <div class="text-center mt-3 text-danger">
                        <p> <?=$this->session->flashdata('input_errors');?> </p> 
					</div>

                    <?php } ?>
					<div class="text-center mt-4 text-muted">
						Copyright &copy; 2022 &mdash; E-Schedule MO.	
					</div>
				</div>
			</div>
		</div>
	</section>
</body>
</html>
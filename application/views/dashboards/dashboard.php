<?php
	$user_level="";
	if($this->session->userdata('user_level') === "1"){
		$user_level = "Staff 1";
	}else if($this->session->userdata('user_level') === "2"){
		$user_level = "Staff 2";
	}else if($this->session->userdata('user_level') === "3"){
		$user_level = "Staff 3";
	}else if($this->session->userdata('user_level') === "4"){
		$user_level = "Head of Assessors";
	}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
	<meta name="author" content="AdminKit">
	<meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

	<meta name="viewport" content="width=device-width, initial-scale=1">
  	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

	<link rel="preconnect" href="https://fonts.gstatic.com">
	<!-- <link rel="shortcut icon" href="img/icons/ispsc_logo.png" /> -->

	<link rel="canonical" href="https://demo-basic.adminkit.io/" />

	<title><?= $user_level ?> Dashboard</title>

	<link href="<?= base_url(); ?>assets/admin/css/app.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" rel="stylesheet">
	<link href="https://cdn.datatables.net/1.12.0/css/dataTables.bootstrap5.min.css" rel="stylesheet">
	<style>
		/* *{
			outline: 1px solid black;
		} */
	</style>
	<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
	<script>
		$(document).ready(function() {

			//The partial page will reload if clicked in the navigation bar. 
			$(document).on('click', 'li.navigation_link', function() {
				let navigation_link_id = $(this).attr('id'); //id of the li.navigation_link
				let link = $('li#' + navigation_link_id + ' a'); //anchor tag of navigation_link_id
				$('#load_page').show();
				$('#dashboard_analytics').hide();
				$("#dashboard_link").removeClass("active");
				$('li.navigation_link').removeClass("active"); // remove all first the li.navigation_link that has a active id.
				$("#" + navigation_link_id).addClass("active");
				$.get(link.attr('href'), function(res) {
					$('#load_page').html(res);
				});
				return false;
			});

			$(document).on('click', 'li a#dashboard_analytics_link', function() {
				$('#dashboard_analytics').show();
				$('#load_page').hide();
				$("#dashboard_link").addClass("active");
				$("li.navigation_link").removeClass("active");
				return false;
			});

			//when add client info transaction form is submitted.
			$(document).on('submit', 'form#add_client_form', function() {
				var form = $(this);
				$.post(form.attr('action'), form.serialize(), function(res) {
					$('#load_page').html(res);
				});
				return false;
			});

		});
	</script>
</head>

<body>
	<div class="wrapper">
		<nav id="sidebar" class="sidebar js-sidebar">
			<div class="sidebar-content js-simplebar">
				<a class="sidebar-brand" href="index.html">
					<span class="align-middle">E-Schedule MO</span>
				</a>
				<ul class="sidebar-nav">
					<li class="sidebar-item active" id="dashboard_link">
						<a class="sidebar-link" href="#" id="dashboard_analytics_link">
							<i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
						</a>
					</li>
					<li class="sidebar-item navigation_link" id="all_transaction_link">
						<a class="sidebar-link" href="load/0" id="all_list_transaction">
							<i class="align-middle" data-feather="list"></i> <span class="align-middle">View All
								Transactions</span>
						</a>
					</li>
					<li class="sidebar-item navigation_link" id="list_transaction_link">
						<a class="sidebar-link" href="load/1" id="list_transaction">
							<i class="align-middle" data-feather="search"></i> <span class="align-middle">Assess
								Transactions</span>
						</a>
					</li>
					<?php if($this->session->userdata('user_level') === "1"){ ?>
					<li class="sidebar-item navigation_link" id="add_form_link">
						<a class="sidebar-link" href="load/2" id="add_form">
							<i class="align-middle" data-feather="user-plus"></i> <span class="align-middle">Add Client
								Transaction</span>
						</a>
					</li>
					<?php } ?>
					<li class="sidebar-item">
						<a class="sidebar-link" href="<?= base_url(); ?>logout">
							<i class="align-middle" data-feather="log-out"></i> <span class="align-middle">Log-out</span>
						</a>
					</li>

				</ul>
			</div>
		</nav>

		<div class="main">
			<nav class="navbar navbar-expand navbar-light navbar-bg">
				<a class="sidebar-toggle js-sidebar-toggle">
					<i class="hamburger align-self-center"></i>
				</a>

				<div class="navbar-collapse collapse">
					<ul class="navbar-nav navbar-align">
						<li class="nav-item">
							<?=$user_level?>
						</li>
					</ul>
				</div>
			</nav>

			<main id="dashboard_analytics" class="content">
				<div class="container-fluid p-0">

					<h1 class="h3 mb-3"><?=$user_level?> Dashboard</h1>

					<div class="row">

						<div class="w-100">
							<div class="row">
								<div class="col-sm-3">
									<div class="card">
										<div class="card-body">
											<div class="row">
												<div class="col mt-0">
													<h5 class="card-title">Recieved</h5>
												</div>

												<div class="col-auto">
													<div class="stat text-primary">
														<i class="align-middle" data-feather="plus"></i>
													</div>
												</div>
											</div>
											<h1 class="mt-1 mb-3"><?= $total_recieved ?></h1>
										</div>
									</div>
								</div>

								<div class="col-sm-3">
									<div class="card">
										<div class="card-body">
											<div class="row">
												<div class="col mt-0">
													<h5 class="card-title">Prepared</h5>
												</div>

												<div class="col-auto">
													<div class="stat text-primary">
														<i class="align-middle" data-feather="user-plus"></i>
													</div>
												</div>
											</div>
											<h1 class="mt-1 mb-3"><?= $total_prepared ?></h1>
										</div>
									</div>
								</div>

								<div class="col-sm-3">
									<div class="card">
										<div class="card-body">
											<div class="row">
												<div class="col mt-0">
													<h5 class="card-title">Verified</h5> 
												</div>

												<div class="col-auto">
													<div class="stat text-primary">
														<i class="align-middle" data-feather="user-check"></i> 
													</div>
												</div>
											</div>
											<h1 class="mt-1 mb-3"><?= $total_verified ?></h1>
										</div>
									</div>
								</div>

								<div class="col-sm-3">
									<div class="card">
										<div class="card-body">
											<div class="row">
												<div class="col mt-0">
													<h5 class="card-title">Successful Transactions</h5>
												</div>

												<div class="col-auto">
													<div class="stat text-primary">
														<i class="align-middle" data-feather="check"></i>
													</div>
												</div>
											</div>
											<h1 class="mt-1 mb-3"><?=$total_successfull?></h1>
										</div>
									</div>
								</div>

							</div>
						</div>

					</div>

					<div class="row">
						<div class="col-11 col-lg-8 col-xxl-9 d-flex">
							<div class="card flex-fill">
								<div class="card-header">

									<h5 class="card-title mb-0">Transactions in Months</h5>
								</div>
								<div class="card-body py-3">
									<div class="chart chart-lg">
										<canvas id="chartjs-dashboard-line"></canvas>
									</div>
								</div>
							</div>
						</div>
						<div class="col-11 col-lg-4 col-xxl-3 d-flex">
							<div class="card flex-fill w-100">
								<div class="card-header">

									<h5 class="card-title mb-0">Transaction Success Rate</h5>
								</div>
								<div class="card-body d-flex">
									<div class="align-self-center w-100">
										<div class="py-3">
											<div class="chart chart-xs">
												<canvas id="chartjs-dashboard-pie"></canvas>
											</div>
										</div>

										<table class="table mb-0">
											<tbody>
												<tr>
													<td>Successfull</td>
													<td class="text-end"><?=$total_successfull?></td>
												</tr>
												<tr>
													<td>On Progress</td>
													<td class="text-end"><?=$total_recieved?></td>
												</tr>
												<tr>
													<td>Pending</td>
													<td class="text-end"><?=$total_pending?></td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</main>

			<main id="load_page" class="content">		
						
			</main>

			<footer class="footer">
				<div class="container-fluid">
					<div class="row text-muted">
						<div class="col-12 text-center">
							<p class="mb-0">
								<a class="text-muted" href="#" target="_blank">E-Schedule MO</a> - <a class="text-muted" href="#">All Rights Reserved</a> &copy;
							</p>
						</div>
					</div>
				</div>
			</footer>
		</div>
	</div>

	<script src="<?= base_url(); ?>assets/admin/js/app.js"></script>
	<script src="https://cdn.datatables.net/1.12.0/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.12.0/js/dataTables.bootstrap5.min.js"></script>

	<!-- For data analytics in dashboard. -->
	<script>
		document.addEventListener("DOMContentLoaded", function() {
			var ctx = document.getElementById("chartjs-dashboard-line").getContext("2d");
			var gradient = ctx.createLinearGradient(0, 0, 0, 225);
			gradient.addColorStop(0, "rgba(215, 227, 244, 1)");
			gradient.addColorStop(1, "rgba(215, 227, 244, 0)");
			// Line chart
			new Chart(document.getElementById("chartjs-dashboard-line"), {
				type: "line",
				data: {
					labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
					datasets: [{
						label: "Total",
						fill: true,
						backgroundColor: gradient,
						borderColor: window.theme.primary,
						data: [
							<?= $january ?>,
							<?= $february ?>,
							<?= $march ?>,
							<?= $april ?>,
							<?= $may ?>,
							<?= $june ?>,
							<?= $july ?>,
							<?= $august ?>,
							<?= $september ?>,
							<?= $october ?>,
							<?= $november ?>,
							<?= $december ?>
						]
					}]
				},
				options: {
					maintainAspectRatio: false,
					legend: {
						display: false
					},
					tooltips: {
						intersect: false
					},
					hover: {
						intersect: true
					},
					plugins: {
						filler: {
							propagate: false
						}
					},
					scales: {
						xAxes: [{
							reverse: true,
							gridLines: {
								color: "rgba(0,0,0,0.0)"
							}
						}],
						yAxes: [{
							ticks: {
								stepSize: 1000
							},
							display: true,
							borderDash: [3, 3],
							gridLines: {
								color: "rgba(0,0,0,0.0)"
							}
						}]
					}
				}
			});
		});
	</script>
	<script>
		document.addEventListener("DOMContentLoaded", function() {
			// Pie chart
			var total_successfull = <?= $total_successfull ?>;
			var total_on_progress = <?= $total_recieved ?>;
			var total_pending = <?= $total_pending ?>;
			new Chart(document.getElementById("chartjs-dashboard-pie"), {
				type: "pie",
				data: {
					labels: ["Successfull", "On Progress", "Pending"],
					datasets: [{
						data: [total_successfull, total_on_progress, total_pending],
						backgroundColor: [
							window.theme.success,
							window.theme.secondary,
							window.theme.warning
						],
						borderWidth: 5
					}]
				},
				options: {
					responsive: !window.MSInputMethodContext,
					maintainAspectRatio: false,
					legend: {
						display: false
					},
					cutoutPercentage: 75
				}
			});
		});
	</script>
	<!-- end of comment data analytics in dashboard. -->

</body>

</html>
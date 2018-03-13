<!------------ Assets for Tiva Events Calendar ------------->
<!-- CSS Files -->
<link rel="stylesheet" href="myCss/assets/css/calendar.css">
<link rel="stylesheet" href="myCss/assets/css/calendar_full.css">
<link rel="stylesheet" href="myCss/assets/css/calendar_compact.css">
<?php $this->irElmNav(); ?>
<!-- Main layout-->
<main>
	<div class="container-fluid">
		<div class="row">
			<!--Grid column-->
			<div class="col-xl-6 col-md-6 mb-4">
				<!--Card-->
				<div class="card card-cascade cascading-admin-card">
					<!--Card Data-->
					<div class="admin-up">
						<h5><span class="px-4 py-3 white-text z-depth-1-half blue lighten-1" style="
							border-radius: 5px;">Nueva Agenda</span></h5>
					</div>
					<!--/.Card Data-->

					<!--Card content-->
					<div class="card-body">
						<select class="mdb-select colorful-select dropdown-primary">
							<option value="0"> - Seleccione un Tipo de Agenda - </option>
							<?php
								$query = "select id, tipo from tipo_agendas order by tipo;";
								$resultado = $this->getEjecutarQ($query);
								while ($tipo = $this->getFetchQ($resultado) ) {
									echo "<option value='".$tipo["id"]."'>".$tipo["tipo"]."</option>";
								}
								$this->getLiberar($resultado);
							?>
						</select>
						
						
						<div class="row text-left">
							<div class="col-md-4 mb-4">
								<h1 class="section-heading h1">Nueva Agenda</h1>
							</div>
							
							<!--Grid column-->
							<div class="col-md-6 mb-4">
								<!--Titulo -->
								<div class="md-form">
									<i class="fa fa-pencil prefix"></i>
									<input type="email" id="form1" class="form-control validate">
									<label for="form1" data-error="wrong" data-success="right" class=""> Titulo</label>
								</div>
							</div>
							<!--Grid column-->
							
							<!--Grid column-->
							<div class="col-md-6 mb-4">
								<!--Titulo -->
								<div class="md-form">
									<i class="fa fa-calendar-o prefix"></i>
									<input type="date" id="form2" class="form-control validate" placeholder="a">
									<label for="form2" data-error="wrong" data-success="right" class=""> </label>
								</div>
							</div>
							<!--Grid column-->
							
							<!--Grid column-->
							<div class="col-md-6 mb-4">
								<!--Titulo -->
								<div class="md-form">
									<i class="fa fa-clock-o prefix"></i>
									<input type="time" id="form3" class="form-control validate" placeholder="a">
									<label for="form3" data-error="wrong" data-success="right" class=""> </label>
								</div>
							</div>
							<!--Grid column-->
							
							<!--Grid column-->
							<div class="col-md-6 mb-4">
								<!--Titulo -->
								<div class="md-form">
									<i class="fa fa-map-marker prefix"></i>
									<input type="text" id="form4" class="form-control validate">
									<label for="form4" data-error="wrong" data-success="right" class=""> Lugar</label>
								</div>
							</div>
							<!--Grid column-->
							
							<!--Grid column-->
							<div class="col-md-6 mb-4">
								<!--Titulo -->
								<div class="md-form">
									<i class="fa fa-money prefix"></i>
									<input type="number" id="form4" class="form-control validate">
									<label for="form4" data-error="wrong" data-success="right" class=""> $ Monto de Venta</label>
								</div>
							</div>
							<!--Grid column-->
							
							<div class="col-md-6 mb-4">
								<!--Textarea with icon prefix-->
								<div class="md-form">
									<i class="fa fa-align-left prefix active"></i>
									<textarea type="text" id="form5" class="md-textarea form-control" rows="3"></textarea>
									<label for="form5" class="active">Descripción</label>
								</div>
							</div>
							
							<div class="col-md-6 mb-4">
								<!--Textarea with icon prefix-->
								<div class="md-form">
									<button type="button" class="btn btn-primary btn-sm waves-effect waves-light">Agregar Anfitrión</button>
								</div>
							</div>
						</div>
							
						<h5 class=""> Anfitrión (es) </h5>
						<table class="table table-striped">

                            <!--Table head-->
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Anfitrión</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <!--Table head-->

                            <!--Table body-->
                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>Mark</td>
                                    <td>Otto</td>
                                    <td>
										<a class="fa-lg p-2 m-2 pin-ic">
											<i class="fa fa-trash"> </i>
										</a>
									</td>
                                </tr>
                                <tr>
                                    <th scope="row">2</th>
                                    <td>Jacob</td>
                                    <td>Thornton</td>
                                    <td>
										<a class="fa-lg p-2 m-2 pin-ic">
											<i class="fa fa-trash"> </i>
										</a>
									</td>
                                </tr>
                                <tr>
                                    <th scope="row">3</th>
                                    <td>Larry</td>
                                    <td>the Bird</td>
                                    <td>
										<a class="fa-lg p-2 m-2 pin-ic">
											<i class="fa fa-trash"> </i>
										</a>
									</td>
                                </tr>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>Mark</td>
                                    <td>Otto</td>
                                    <td>
										<a class="fa-lg p-2 m-2 pin-ic">
											<i class="fa fa-trash"> </i>
										</a>
									</td>
                                </tr>
                                <tr>
                                    <th scope="row">2</th>
                                    <td>Jacob</td>
                                    <td>Thornton</td>
                                    <td>
										<a class="fa-lg p-2 m-2 pin-ic">
											<i class="fa fa-trash"> </i>
										</a>
									</td>
                                </tr>
                                <tr>
                                    <th scope="row">3</th>
                                    <td>Larry</td>
                                    <td>the Bird</td>
                                    <td>
										<a class="fa-lg p-2 m-2 pin-ic">
											<i class="fa fa-trash"> </i>
										</a>
									</td>
                                </tr>
                            </tbody>
                            <!--Table body-->
                        </table>
					</div>
					<!--/.Card content-->
				</div>
				<!--/.Card-->
			</div>
			<!--Grid column-->
		</div>
		
		<section class="mb-5">
			<div class="card card-cascade narrower">
				<section>
					<div class="row">
						<div class="col-xl-12 col-lg-12 mr-0">
							<!--Card image-->
							<div class="view gradient-card-header light-green lighten-1">
								<h2 class="h2-responsive mb-0">Calendario</h2>
							</div>
							<!--/Card image-->

							<!--Call Full Events Calendar-->
							<div class="col-md-12">
								<div class="tiva-events-calendar full" data-view="calendar"></div>
							</div>
							<!--/.Call Full Events Calendar-->

						</div>
						<!--Main column-->
					</div>
					
				</section>
			</div>
		</section>
		
		<section class="mb-5">
			<div class="card card-cascade narrower">
				<section>
					<div class="row">
						<div class="col-xl-5 col-lg-12 mr-0">
							<!--Card image-->
							<div class="view gradient-card-header light-blue lighten-1">
								<h2 class="h2-responsive mb-0">Calendario</h2>
							</div>
							<!--/Card image-->

							<!--Call Full Events Calendar-->
							<div class="col-md-6">
								
							</div>
							<!--/.Call Full Events Calendar-->

						</div>
						<!--Main column-->
					</div>
					
				</section>
			</div>
		</section>
	</div>
</main>
<!-- /.Main layout-->

<!-- Foot -->
<?php $this->irElemFoot(); ?>

<!-- JS Base -->
<?=$inDatos["JS_BASE"]?>
<!-- JS Files -->
<script src="myCss/assets/js/calendar.js"></script>
<script>
	jQuery(document).ready(function(){
		// Get events from json file or ajax php
		jQuery.ajax({
			url: 'events.php',
			dataType: 'json',
			data: '',
			beforeSend : function(){
				jQuery('.tiva-calendar').html('<div class="loading"><img src="images/temp/loading.gif" /></div>');
			},
			success: function(data) {
				for (var i = 0; i < data.length; i++) {
					var event_date = new Date(data[i].year, Number(data[i].month) - 1, data[i].day);
					data[i].date = event_date.getTime();
					tiva_events.push(data[i]);
				}

				// Sort events by date
				tiva_events.sort(sortEventsByDate);

				for (var j = 0; j < tiva_events.length; j++) {
					tiva_events[j].id = j;
					if (!tiva_events[j].duration) {
						tiva_events[j].duration = 1;
					}
				}
				
				// Create calendar
				changedate('current', 'full');
				changedate('current', 'compact');

				jQuery('.tiva-events-calendar').each(function(index) {
					// Initial view
					var initial_view = (typeof jQuery(this).attr('data-view') != "undefined") ? jQuery(this).attr('data-view') : 'calendar';
					if (initial_view == 'list') {
						jQuery(this).find('.list-view').click();
					}
				});
			}
		});
		
		//--
		showListCalendar();
		
		
        // Material Select Initialization
		$('.mdb-select').material_select();


	});
	
</script>


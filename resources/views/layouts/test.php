
<!DOCTYPE html>
<html>
<head>
	<title></title>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />

<!-- Include Bootstrap Datepicker -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>


</head>
<body>
<div class="dates">
  <div class="start_date input-group mb-4">
    <input class="form-control start_date" type="text" placeholder="start date" id="startdate_datepicker">
    <div class="input-group-append">
      <span class="fa fa-calendar input-group-text start_date_calendar" aria-hidden="true "></span>
    </div>

  </div>
  <div class="end_date input-group mb-4">
    <input class="form-control end_date" type="text" placeholder="end date" id="enddate_datepicker">
    <div class="input-group-append">
      <span class="fa fa-calendar input-group-text end_date_calendar" aria-hidden="true "></span>
    </div>
  </div>
</div>
</body>

<script type="text/javascript">
	$("#startdate_datepicker").datepicker();
$("#enddate_datepicker").datepicker();

</script>
</html>
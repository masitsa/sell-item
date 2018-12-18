
<hr>
<h4>Incidents</h4>
<input id="myInput" type="text" placeholder="Search..">
<br><br>

<table>
  <thead>
    <tr>
      <th>#</th>
      <th>Incident Date</th>
      <th>Image</th>
      <th>Classification</th>
      <th>Reported By</th>
      <th>Phone</th>
      <th>Reported On</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody id="myTable">
	<?php 
	$count = 0;
	if($incidents->num_rows() > 0){
		foreach($incidents->result() as $row){
			$count++;
			$incident_id = $row->incident_id;
			$incident_date = $row->incident_date;
			$incident_station = $row->incident_station;
			$incident_reporting_person_ssa = $row->incident_reporting_person_ssa;
			$incident_reporting_person_co_no = $row->incident_reporting_person_co_no;
			$incident_reporting_person_name = $row->incident_reporting_person_name;
			$incident_reporting_person_phone = $row->incident_reporting_person_phone;
			$incident_lat = $row->incident_lat;
			$incident_long = $row->incident_long;
			$incident_location = $row->incident_location;
			$incident_person_injured = $row->incident_person_injured;
			$incident_designation = $row->incident_designation;
			$incident_permit_order_no = $row->incident_permit_order_no;
			$incident_classification = $row->incident_classification;
			$incident_other_classification = $row->incident_other_classification;
			$incident_summary = $row->incident_summary;
			$incident_results = $row->incident_results;
			$incident_action = $row->incident_action;
			$incident_image = $row->incident_image;
			$incident_submitted_date = $row->incident_submitted_date;
			$incident_timestamp = $row->incident_timestamp;

			echo '
			<tr>
				<td>'.$count.'</td>
				<td>'.date("Y-m-d H:i:s", strtotime($incident_date)).'</td>
				<td><img src="'.$incident_image.'" height="100"/></td>
				<td>'.$incident_classification.'</td>
				<td>'.$incident_reporting_person_name.'</td>
				<td>'.$incident_reporting_person_phone.'</td>
				<td>'.date("Y-m-d H:i:s", strtotime($incident_timestamp)).'</td>
				<td>
					<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal'.$incident_id.'">
						<i class="fa fa-plus"></i> View
					</button>
					
					<div class="modal fade" id="modal'.$incident_id.'" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="modalLabel">Modal title</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body">
									<table class="table table-striped table-bordered">
										<tr>
											<th>Incident Date</th>
											<td>'.date("Y-m-d H:i:s", strtotime($incident_date)).'</td>
										</tr>
										<tr>
											<th>Incident Station</th>
											<td>'.$incident_station.'</td>
										</tr>
										<tr>
											<th>Reporting Person SSA</th>
											<td>'.$incident_reporting_person_ssa.'</td>
										</tr>
										<tr>
											<th>Reporting Person Co. No.</th>
											<td>'.$incident_reporting_person_co_no.'</td>
										</tr>
										<tr>
											<th>Reporting Person Name</th>
											<td>'.$incident_reporting_person_name.'</td>
										</tr>
										<tr>
											<th>Reporting Person Phone</th>
											<td>'.$incident_reporting_person_phone.'</td>
										</tr>
										<tr>
											<th>Incident Latitude</th>
											<td>'.$incident_lat.'</td>
										</tr>
										<tr>
											<th>Incident Longitude</th>
											<td>'.$incident_long.'</td>
										</tr>
										<tr>
											<th>Incident Location</th>
											<td>'.$incident_location.'</td>
										</tr>
										<tr>
											<th>Person Injured</th>
											<td>'.$incident_person_injured.'</td>
										</tr>
										<tr>
											<th>Designation</th>
											<td>'.$incident_designation.'</td>
										</tr>
										<tr>
											<th>Permit Order No.</th>
											<td>'.$incident_permit_order_no.'</td>
										</tr>
										<tr>
											<th>Classification</th>
											<td>'.$incident_classification.'</td>
										</tr>
										<tr>
											<th>Other Classification</th>
											<td>'.$incident_other_classification.'</td>
										</tr>
										<tr>
											<th>Summary of Incident</th>
											<td>'.$incident_summary.'</td>
										</tr>
										<tr>
											<th>Preliminary Results</th>
											<td>'.$incident_results.'</td>
										</tr>
										<tr>
											<th>Corrective Action</th>
											<td>'.$incident_action.'</td>
										</tr>
										<tr>
											<th>Image</th>
											<td><img src="'.$incident_image.'" class="img-fluid"/></td>
										</tr>
										<tr>
											<th>Logged Date</th>
											<td>'.date("Y-m-d H:i:s", strtotime($incident_submitted_date)).'</td>
										</tr>
										<tr>
											<th>Submitted Date</th>
											<td>'.date("Y-m-d H:i:s", strtotime($incident_timestamp)).'</td>
										</tr>
									</table>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
								</div>
							</div>
						</div>
					</div>
				</td>
			</tr>
			';
		}
	}
	?>
    
  </tbody>
</table>

<script type="text/javascript">
$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>

<h3><?php echo $store['name']; ?></h3>
<table class="table table-bordered table-striped">
		<tr>
			<td><b>Location (latitude-longitude)</b></td>
			<td><?php echo $store['lat'] . ' ' . $store['lng']; ?></td>
		</tr>
		<tr>
			<td><b>Driver ESL For This Store</b></td>
			<td><?php echo DRIVER_ESL . DS . $store['id']; ?></td>
		</tr>
		<tr>
			<td><b>Store ESL</b></td>
			<td><?php echo $store['esl']; ?></td>
		</tr>
	</tbody>
</table>

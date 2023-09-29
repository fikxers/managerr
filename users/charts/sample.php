<!-- start chart -->	
<div> <canvas id="myChart"></canvas> </div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('myChart');
	new Chart(ctx, {
	type: 'bar',
	data: {
	  labels: ['Estate Residents', 'Hostel Residents', 'FMs', 'Fikxers', 'Hostel Mgrs'],
	  datasets: [{
		label: 'All Users',
		data: [12, 19, 3, 5, 2],
		borderWidth: 1
	  }]
	},
	options: {
	  scales: {
		y: {
	      beginAtZero: true
		}
	  }
	}
    });
</script>
<!-- end chart -->	
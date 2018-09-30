<?php include(dirname(__FILE__) . "/includes/header.php");
if (!$session->is_signed_in()) {
    redirect("login.php");
}
?>
        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">

            <?php include("includes/top_nav.php"); ?>

            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <?php include("includes/side_nav.php"); ?>
            <!-- /.navbar-collapse -->
        </nav>



        <div id="page-wrapper">

            <?php include("includes/admin_content.php"); ?>

        </div>
        <!-- /#page-wrapper -->
    <script>
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

            var data = google.visualization.arrayToDataTable([
                ['Task', 'Hours per Day'],
                ['Views', <?php echo $session->count; ?>],
                ['Comments', <?php echo Comment::count_all(); ?>],
                ['Users', <?php echo User::count_all(); ?>],
                ['Photos', <?php echo Photo::count_all(); ?>]
            ]);

            var options = {
                legend: 'none',
                pieSliceText: 'label',
                title: 'My Daily Activities',
                backgroundColor: 'transparent'
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart'));

            chart.draw(data, options);
        }
    </script>
  <?php include("includes/footer.php"); ?>
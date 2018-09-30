  </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="/gallery/admin/js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="/gallery/admin/js/bootstrap.min.js"></script>

  <!-- WYSIWYG -->
  <script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=xmqyusgt0kob2jl1gixmom3rmxs69n4b874l8c8ninnkrj5l"></script>
  <script src="js/scripts.js"></script>

  <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

          var data = google.visualization.arrayToDataTable([
              ['Task', 'Hours per Day'],
              ['Work',     11],
              ['Eat',      2],
              ['Commute',  2],
              ['Watch TV', 2],
              ['Sleep',    7]
          ]);

          var options = {
              title: 'My Daily Activities'
          };

          var chart = new google.visualization.PieChart(document.getElementById('piechart'));

          chart.draw(data, options);
      }
  </script>
</body>

</html>

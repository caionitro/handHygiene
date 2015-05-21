  <footer>
    <div class="navbar navbar-inverse navbar-fixed-bottom rodapeMenor">
      <div class="container">
        <div class="text-center center-block">
          <p class="text-muted"><?=SISTEMA?> Article - Made with <span class="fa fa-heart"></span> by Nahida <span class="fa fa-stethoscope"></span> and Caio <span class="fa fa-laptop"></span></p>
      </div>
      </div>
    </div>
  </footer>
  <script type="text/javascript">
    setInterval(function(){
      $.ajax({
        url: '../sessionUp.php',
        type: 'POST',
        dataType: 'html',
      }).done(function() {
        console.log("success");
      });
    }, 50000);
  </script>
  <!-- Latest compiled and minified JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.5/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/plug-ins/f2c75b7247b/integration/bootstrap/3/dataTables.bootstrap.js"></script>
  <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/jquery.validate.min.js"></script>
</body>
</html>
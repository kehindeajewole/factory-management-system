    <!-- Footer Start -->
    <footer class="app-footer-main">
        <div class="container-fluid">
              <p> &copy; <?php echo date("Y");?> Factory Management System. All Rights Reserved. Website Developed by <a href="#" target="_blank">Kehinde Ajewole</a></p>
        </div>
    </footer>
    <!-- Footer End -->
    </div>
  </main>
  <!-- End Main from header -->
  <!-- Core -->
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/chartjs.min.js"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <script src="../assets/js/admin.js"></script>
  <script src="../assets/js/app.js"></script>
</body>

</html>
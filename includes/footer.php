<footer>
    <p> Image Gallery - COMP1006 </p>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-JpV0cHVPk77lhdqGRG5j6jGFJfYBkVTL7qRvLGx6IkDzYqq6M5y1CSYV" crossorigin="anonymous"></script>

<!-- Make sure the cached version of the page isn't shown (in case user is logged out) -->
<script>
  window.addEventListener("pageshow", function(event) {
    if (event.persisted) {
      window.location.reload();
    }
  });
</script>
</body>
</html>
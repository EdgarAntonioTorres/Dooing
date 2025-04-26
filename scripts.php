<script src="./public/bootstrap5/bootstrap.bundle.min.js"></script>
<script src="./public/sweetalert/sweetalert.min.js"></script>
<script src="./public/js/script.js"></script>
<?php
if (isset($mensaje) && !empty($mensaje)) {
    echo "<script>
    document.addEventListener('DOMContentLoaded', function() {
        $mensaje
    });
    </script>";
}
?>
</body>
</html>
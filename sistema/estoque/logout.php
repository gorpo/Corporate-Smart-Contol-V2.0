<!-- @Guilherme Paluch 2021 -->
<?php
session_start();
session_destroy();
header('Location: /sistema/');
exit();
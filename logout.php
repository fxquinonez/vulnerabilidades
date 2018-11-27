<?php
require_once dirname(__FILE__) . '/private/conf.php';

# Require logged users
require dirname(__FILE__) . '/private/auth.php';

# Show form
?><html><head><title>Logout</title></head>
<body>
 <meta http-equiv="refresh" content="0; url=./index.php">
</body></html>


<?php

require __DIR__.'/bootstrap/app.php';

use \App\Http\Router;

//Start the router
$obRouter = new Router(URL);

//Includes page routes
include __DIR__.'/routes/pages.php';

//Includes page routes
include __DIR__.'/routes/user.php';

//Includes panel routes
include __DIR__.'/routes/admin.php';

//Includes API routes
include __DIR__.'/routes/api.php';

//Print the route response
$obRouter->run()->sendResponse();
<?php

// Fallback to forward direct requests to the public front controller.
// This helps ``http://localhost/project-name/...`` work when Apache
// serves the project folder directly from htdocs.

require __DIR__.'/public/index.php';

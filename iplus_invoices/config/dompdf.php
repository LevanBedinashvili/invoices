<?php
return [
    // Set the public_path explicitly for DomPDF as a string, not a closure
    'public_path' => realpath(__DIR__ . '/../public'),
];

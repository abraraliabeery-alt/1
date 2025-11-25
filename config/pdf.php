<?php

return [
	'mode'                  => 'utf-8',
	'format'                => 'A4',
	'default_font_size'    => '12',
	// Prefer Amiri/Cairo if present; fallback to DejaVu Sans which supports Arabic.
	'default_font'         => 'dejavusans',
	'author'                => '',
	'subject'               => '',
	'keywords'              => '',
	'creator'               => 'Laravel Pdf',
	'display_mode'          => 'fullpage',
	'tempDir'               => storage_path('app/pdf-temp'),
	'pdf_a'                 => false,
	'pdf_a_auto'            => false,
	'icc_profile_path'      => ''
];

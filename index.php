<?php
$index = 'page/index.html';

if (file_exists($index)) {
	include $index;
} else {
	die('Page is not configured');
}
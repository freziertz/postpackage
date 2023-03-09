<?php

return [
  'posts_table' => 'posts',
  // other options...

  'prefix' => 'brainypost',
  'middleware' => ['web'], 

  'notifications' => [

                   'channels' => 'mail']// you probably want to include 'web' here

];
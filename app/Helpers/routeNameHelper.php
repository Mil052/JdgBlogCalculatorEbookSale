<?php

if (! function_exists('routeName')) {
    function routeToName(string $routeName) {
      switch ($routeName) {
        case 'admin.dashboard':
          return 'Admin Panel';
        case 'admin.blog':
          return 'Blog';
        case 'admin.post-create':
          return 'Nowy Post';
        case 'admin.post-update':
          return 'Edycja Postu';
      }
    }
}
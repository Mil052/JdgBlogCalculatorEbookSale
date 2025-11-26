<?php

if (! function_exists('routeName')) {
    function routeToName(string $routeName) {
      switch ($routeName) {
        case 'admin.dashboard':
          return 'Admin Panel';
        case 'admin.blog':
          return 'Blog';
        case 'admin.post-create':
          return 'Blog';
        case 'admin.post-update':
          return 'Blog';
        case 'admin.products-list':
          return 'Produkty';
        case 'admin.product-create':
          return 'Produkty';
        case 'admin.product-update':
          return 'Produkty';
        case 'admin.orders-list':
          return 'Zamówienia';
        case 'admin.order-details':
          return 'Zamówienia';
      }
    }
}
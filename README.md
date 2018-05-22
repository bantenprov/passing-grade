# Passing Grade

[![Join the chat at https://gitter.im/passing-grade/Lobby](https://badges.gitter.im/passing-grade/Lobby.svg)](https://gitter.im/passing-grade/Lobby?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/bantenprov/passing-grade/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/bantenprov/passing-grade/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/bantenprov/passing-grade/badges/build.png?b=master)](https://scrutinizer-ci.com/g/bantenprov/passing-grade/build-status/master)
[![Latest Stable Version](https://poser.pugx.org/bantenprov/passing-grade/v/stable)](https://packagist.org/packages/bantenprov/passing-grade)
[![Total Downloads](https://poser.pugx.org/bantenprov/passing-grade/downloads)](https://packagist.org/packages/bantenprov/passing-grade)
[![Latest Unstable Version](https://poser.pugx.org/bantenprov/passing-grade/v/unstable)](https://packagist.org/packages/bantenprov/passing-grade)
[![License](https://poser.pugx.org/bantenprov/passing-grade/license)](https://packagist.org/packages/bantenprov/passing-grade)
[![Monthly Downloads](https://poser.pugx.org/bantenprov/passing-grade/d/monthly)](https://packagist.org/packages/bantenprov/passing-grade)
[![Daily Downloads](https://poser.pugx.org/bantenprov/passing-grade/d/daily)](https://packagist.org/packages/bantenprov/passing-grade)

Passing Grade

### Install via composer

- Development snapshot

```bash
composer require bantenprov/passing-grade:dev-master
```

- Latest release:

```bash
composer require bantenprov/passing-grade
```

### Download via github

```bash
git clone https://github.com/bantenprov/passing-grade.git
```

#### Edit `config/app.php` :

```php
'providers' => [
    /*
    * Laravel Framework Service Providers...
    */
    Illuminate\Auth\AuthServiceProvider::class,
    Illuminate\Broadcasting\BroadcastServiceProvider::class,
    Illuminate\Bus\BusServiceProvider::class,
    Illuminate\Cache\CacheServiceProvider::class,
    Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
    Illuminate\Cookie\CookieServiceProvider::class,
    //...
    Bantenprov\PassingGrade\PassingGradeServiceProvider::class,
    //...
];
```

#### Edit `app/Http/Kernel.php`

```php
protected $routeMiddleware = [
    'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
    'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
    'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
    'can' => \Illuminate\Auth\Middleware\Authorize::class,
    'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
    'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
    //...
    'role' => \Laratrust\Middleware\LaratrustRole::class,
    'permission' => \Laratrust\Middleware\LaratrustPermission::class,
    'ability' => \Laratrust\Middleware\LaratrustAbility::class,
    //...
];
```

#### Lakukan publish semua komponen :

```bash
php artisan vendor:publish --tag=passing-grade-publish
```

#### Lakukan auto dump :

```bash
composer dump-autoload
```

#### Lakukan seeding :

```bash
```

#### Edit menu `resources/assets/js/menu.js`

```javascript
{
    name: 'Dashboard',
    icon: 'fa fa-dashboard',
    childType: 'collapse',
    childItem: [
        //...
        // Passing Grade (Public)
        {
            name: 'Passing Grade (Public)',
            link: '/passing-grade-public',
            icon: 'fa fa-angle-double-right',
        },
        // Passing Grade
        {
            name: 'Passing Grade',
            link: '/dashboard/passing-grade',
            icon: 'fa fa-angle-double-right',
        },
        //...
    ]
},
```

```javascript
{
    name: 'Admin',
    icon: 'fa fa-lock',
    childType: 'collapse',
    childItem: [
        //...
        // Passing Grade
        {
            name: 'Passing Grade',
            link: '/admin/passing-grade',
            icon: 'fa fa-angle-double-right',
        },
        //...
    ]
},
```

#### Tambahkan components `resources/assets/js/components.js` :

```javascript
//... Passing Grade ...//

import PassingGradeAdminShow from '~/components/bantenprov/passing-grade/passing-grade/PassingGradeAdmin.show.vue';
Vue.component('passing-grade-admin', PassingGradeAdminShow);

//... Echarts Passing Grade ...//

import PassingGrade from '~/components/bantenprov/passing-grade/passing-grade/PassingGrade.chart.vue';
Vue.component('passing-grade-echarts', PassingGrade);

import PassingGradeKota from '~/components/bantenprov/passing-grade/passing-grade/PassingGradeKota.chart.vue';
Vue.component('passing-grade-echarts-kota', PassingGradeKota);

import PassingGradeTahun from '~/components/bantenprov/passing-grade/passing-grade/PassingGradeTahun.chart.vue';
Vue.component('passing-grade-echarts-tahun', PassingGradeTahun);

//... Mini Bar Charts Passing Grade ...//

import PassingGradeBar01 from '~/components/views/bantenprov/passing-grade/passing-grade/PassingGradeBar01.vue';
Vue.component('passing-grade-bar-01', PassingGradeBar01);

import PassingGradeBar02 from '~/components/views/bantenprov/passing-grade/passing-grade/PassingGradeBar02.vue';
Vue.component('passing-grade-bar-02', PassingGradeBar02);

import PassingGradeBar03 from '~/components/views/bantenprov/passing-grade/passing-grade/PassingGradeBar03.vue';
Vue.component('passing-grade-bar-03', PassingGradeBar03);

//... Mini Pie Charts Passing Grade ...//

import PassingGradePie01 from '~/components/views/bantenprov/passing-grade/passing-grade/PassingGradePie01.vue';
Vue.component('passing-grade-pie-01', PassingGradePie01);

import PassingGradePie02 from '~/components/views/bantenprov/passing-grade/passing-grade/PassingGradePie02.vue';
Vue.component('passing-grade-pie-02', PassingGradePie02);

import PassingGradePie03 from '~/components/views/bantenprov/passing-grade/passing-grade/PassingGradePie03.vue';
Vue.component('passing-grade-pie-03', PassingGradePie03);
```

#### Tambahkan route di dalam file : `resources/assets/js/routes.js` :

```javascript
{
    path: '/dashboard',
    redirect: '/dashboard/home',
    component: layout('Default'),
    children: [
        //...
        // Passing Grade (Public)
        {
            path: '/passing-grade-public',
            components: {
                main: resolve => require(['~/components/bantenprov/passing-grade/passing-grade-public/PassingGradePublic.index.vue'], resolve),
                navbar: resolve => require(['~/components/Navbar.vue'], resolve),
                sidebar: resolve => require(['~/components/Sidebar.vue'], resolve),
            },
            meta: {
                title: "Passing Grade",
            },
        },
        {
            path: '/passing-grade-public/:id',
            components: {
                main: resolve => require(['~/components/bantenprov/passing-grade/passing-grade-public/PassingGradePublic.show.vue'], resolve),
                navbar: resolve => require(['~/components/Navbar.vue'], resolve),
                sidebar: resolve => require(['~/components/Sidebar.vue'], resolve),
            },
            meta: {
                title: "View Passing Grade",
            },
        },
        //...
        // Passing Grade
        {
            path: '/dashboard/passing-grade',
            components: {
                main: resolve => require(['~/components/views/bantenprov/passing-grade/passing-grade/PassingGradeDashboard.vue'], resolve),
                navbar: resolve => require(['~/components/Navbar.vue'], resolve),
                sidebar: resolve => require(['~/components/Sidebar.vue'], resolve)
            },
            meta: {
                title: "Passing Grade",
            },
        },
        //...
    ]
},
```

```javascript
{
    path: '/admin',
    redirect: '/admin/dashboard/home',
    component: layout('Default'),
    children: [
        //...
        // Passing Grade
        {
            path: '/admin/passing-grade',
            components: {
                main: resolve => require(['~/components/bantenprov/passing-grade/passing-grade/PassingGrade.index.vue'], resolve),
                navbar: resolve => require(['~/components/Navbar.vue'], resolve),
                sidebar: resolve => require(['~/components/Sidebar.vue'], resolve),
            },
            meta: {
                title: "Passing Grade",
            },
        },
        {
            path: '/admin/passing-grade/:id',
            components: {
                main: resolve => require(['~/components/bantenprov/passing-grade/passing-grade/PassingGrade.show.vue'], resolve),
                navbar: resolve => require(['~/components/Navbar.vue'], resolve),
                sidebar: resolve => require(['~/components/Sidebar.vue'], resolve),
            },
            meta: {
                title: "View Passing Grade",
            },
        },
        //...
    ]
},
```

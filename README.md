# Data Akademik

[![Join the chat at https://gitter.im/data-akademik/Lobby](https://badges.gitter.im/data-akademik/Lobby.svg)](https://gitter.im/data-akademik/Lobby?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/bantenprov/data-akademik/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/bantenprov/data-akademik/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/bantenprov/data-akademik/badges/build.png?b=master)](https://scrutinizer-ci.com/g/bantenprov/data-akademik/build-status/master)
[![Latest Stable Version](https://poser.pugx.org/bantenprov/data-akademik/v/stable)](https://packagist.org/packages/bantenprov/data-akademik)
[![Total Downloads](https://poser.pugx.org/bantenprov/data-akademik/downloads)](https://packagist.org/packages/bantenprov/data-akademik)
[![Latest Unstable Version](https://poser.pugx.org/bantenprov/data-akademik/v/unstable)](https://packagist.org/packages/bantenprov/data-akademik)
[![License](https://poser.pugx.org/bantenprov/data-akademik/license)](https://packagist.org/packages/bantenprov/data-akademik)
[![Monthly Downloads](https://poser.pugx.org/bantenprov/data-akademik/d/monthly)](https://packagist.org/packages/bantenprov/data-akademik)
[![Daily Downloads](https://poser.pugx.org/bantenprov/data-akademik/d/daily)](https://packagist.org/packages/bantenprov/data-akademik)

Data Akademik pada sekolah

### Install via composer

- Development snapshot

```bash
$ composer require bantenprov/data-akademik:dev-master
```

- Latest release:

```bash
$ composer require bantenprov/data-akademik
```

### Download via github

```bash
$ git clone https://github.com/bantenprov/data-akademik.git
```

#### Edit `config/app.php` :

```php
'providers' => [

    /*
     * Package Service Providers...
     */
    Laravel\Tinker\TinkerServiceProvider::class,
    //....
    Bantenprov\DataAkademik\DataAkademikServiceProvider::class,
```

#### Publish vendor :

```bash
$ php artisan vendor:publish --tag=data-akademik-seeds
$ php artisan vendor:publish --tag=data-akademik-assets
$ php artisan vendor:publish --tag=data-akademik-public
```

#### Lakukan auto dump :

```bash
$ composer dump-autoload
```

#### Lakukan migrate :

```bash
$ php artisan migrate
```

#### Lakukan seeding :

```bash
$ php artisan db:seed --class=BantenprovDataAkademikSeeder
```

#### Tambahkan route di dalam file : `resources/assets/js/routes.js` :

```javascript
{
    path: '/dashboard',
    redirect: '/dashboard/home',
    component: layout('Default'),
    children: [
        //== ...
        {
            path: '/dashboard/data-akademik',
            components: {
                main: resolve => require(['./components/views/bantenprov/data-akademik/DashboardDataAkademik.vue'], resolve),
                navbar: resolve => require(['./components/Navbar.vue'], resolve),
                sidebar: resolve => require(['./components/Sidebar.vue'], resolve)
            },
            meta: {
                title: "Data Akademik"
            }
        },
        //== ...
    ]
},
```

```javascript
{
    path: '/admin',
    redirect: '/admin/dashboard/home',
    component: layout('Default'),
    children: [
        //== ...
        {
            path: '/admin/data-akademik',
            components: {
                main: resolve => require(['./components/bantenprov/data-akademik/DataAkademik.index.vue'], resolve),
                navbar: resolve => require(['./components/Navbar.vue'], resolve),
                sidebar: resolve => require(['./components/Sidebar.vue'], resolve)
            },
            meta: {
                title: "Data Akademik"
            }
        },
        {
            path: '/admin/data-akademik/create',
            components: {
                main: resolve => require(['./components/bantenprov/data-akademik/DataAkademik.add.vue'], resolve),
                navbar: resolve => require(['./components/Navbar.vue'], resolve),
                sidebar: resolve => require(['./components/Sidebar.vue'], resolve)
            },
            meta: {
                title: "Add Data Akademik"
            }
        },
        {
            path: '/admin/data-akademik/:id',
            components: {
                main: resolve => require(['./components/bantenprov/data-akademik/DataAkademik.show.vue'], resolve),
                navbar: resolve => require(['./components/Navbar.vue'], resolve),
                sidebar: resolve => require(['./components/Sidebar.vue'], resolve)
            },
            meta: {
                title: "View Data Akademik"
            }
        },
        {
            path: '/admin/data-akademik/:id/edit',
            components: {
                main: resolve => require(['./components/bantenprov/data-akademik/DataAkademik.edit.vue'], resolve),
                navbar: resolve => require(['./components/Navbar.vue'], resolve),
                sidebar: resolve => require(['./components/Sidebar.vue'], resolve)
            },
            meta: {
                title: "Edit Data Akademik"
            }
        },
        //== ...
    ]
},
```
#### Edit menu `resources/assets/js/menu.js`

```javascript
{
    name: 'Dashboard',
    icon: 'fa fa-dashboard',
    childType: 'collapse',
    childItem: [
        //== ...
        {
            name: 'Data Akademik',
            link: '/dashboard/data-akademik',
            icon: 'fa fa-angle-double-right'
        },
        //== ...
    ]
},
```

```javascript
{
    name: 'Admin',
    icon: 'fa fa-lock',
    childType: 'collapse',
    childItem: [
        //== ...
        {
            name: 'Data Akademik',
            link: '/admin/data-akademik',
            icon: 'fa fa-angle-double-right'
        },
        //== ...
    ]
},
```

#### Tambahkan components `resources/assets/js/components.js` :

```javascript
import DataAkademik from './components/bantenprov/data-akademik/DataAkademik.chart.vue';
Vue.component('echarts-data-akademik', DataAkademik);

import DataAkademikKota from './components/bantenprov/data-akademik/DataAkademikKota.chart.vue';
Vue.component('echarts-data-akademik-kota', DataAkademikKota);

import DataAkademikTahun from './components/bantenprov/data-akademik/DataAkademikTahun.chart.vue';
Vue.component('echarts-data-akademik-tahun', DataAkademikTahun);

import DataAkademikAdminShow from './components/bantenprov/data-akademik/DataAkademikAdmin.show.vue';
Vue.component('admin-view-data-akademik-tahun', DataAkademikAdminShow);

//== Echarts Data Akademik

import DataAkademikBar01 from './components/views/bantenprov/data-akademik/DataAkademikBar01.vue';
Vue.component('data-akademik-bar-01', DataAkademikBar01);

import DataAkademikBar02 from './components/views/bantenprov/data-akademik/DataAkademikBar02.vue';
Vue.component('data-akademik-bar-02', DataAkademikBar02);

//== mini bar charts
import DataAkademikBar03 from './components/views/bantenprov/data-akademik/DataAkademikBar03.vue';
Vue.component('data-akademik-bar-03', DataAkademikBar03);

import DataAkademikPie01 from './components/views/bantenprov/data-akademik/DataAkademikPie01.vue';
Vue.component('data-akademik-pie-01', DataAkademikPie01);

import DataAkademikPie02 from './components/views/bantenprov/data-akademik/DataAkademikPie02.vue';
Vue.component('data-akademik-pie-02', DataAkademikPie02);

//== mini pie charts
import DataAkademikPie03 from './components/views/bantenprov/data-akademik/DataAkademikPie03.vue';
Vue.component('data-akademik-pie-03', DataAkademikPie03);
```

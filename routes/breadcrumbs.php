<?php // routes/breadcrumbs.php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.
use Diglactic\Breadcrumbs\Breadcrumbs;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// dashboard
Breadcrumbs::for('dashboard.index', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard', route('dashboard.index'));
});

// settings
Breadcrumbs::for('settings.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard.index');
    $trail->push('Settings');
});

// karyawan
Breadcrumbs::for('karyawan.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard.index');
    $trail->push('Karyawan', route('karyawan.index'));
});

// karyawan > add
Breadcrumbs::for('karyawan.add.index', function (BreadcrumbTrail $trail) {
    $trail->parent('karyawan.index');
    $trail->push('Tambah karyawan', route('karyawan.add.index'));
});
// karyawan > edit
Breadcrumbs::for('karyawan.edit.index', function (BreadcrumbTrail $trail) {
    $trail->parent('karyawan.index');
    $trail->push('Edit karyawan');
});


// settings > role
Breadcrumbs::for('settings.role.index', function (BreadcrumbTrail $trail) {
    $trail->parent('settings.index');
    $trail->push('Role', route('settings.role.index'));
});

// settings > permission
Breadcrumbs::for('settings.permission.index', function (BreadcrumbTrail $trail) {
    $trail->parent('settings.index');
    $trail->push('Permission', route('settings.permission.index'));
});

// settings > menu
Breadcrumbs::for('settings.menu.index', function (BreadcrumbTrail $trail) {
    $trail->parent('settings.index');
    $trail->push('Menu', route('settings.menu.index'));
});

// settings > user
Breadcrumbs::for('settings.user.index', function (BreadcrumbTrail $trail) {
    $trail->parent('settings.index');
    $trail->push('User', route('settings.user.index'));
});

// settings > logo
Breadcrumbs::for('settings.logo.index', function (BreadcrumbTrail $trail) {
    $trail->parent('settings.index');
    $trail->push('Logo', route('settings.logo.index'));
});

// settings > konfig umum
Breadcrumbs::for('settings.konfig-umum.index', function (BreadcrumbTrail $trail) {
    $trail->parent('settings.index');
    $trail->push('Konfig umum', route('settings.konfig-umum.index'));
});

// settings > konfig umum
Breadcrumbs::for('settings.config-app.index', function (BreadcrumbTrail $trail) {
    $trail->parent('settings.index');
    $trail->push('Konfig umum', route('settings.config-app.index'));
});

// settings > masters
Breadcrumbs::for('settings.masters.index', function (BreadcrumbTrail $trail) {
    $trail->parent('settings.index');
    $trail->push('Masters');
});

// settings > masters > struktur-organisasi
Breadcrumbs::for('settings.masters.struktur-organisasi.index', function (BreadcrumbTrail $trail) {
    $trail->parent('settings.masters.index');
    $trail->push('Struktur organisasi', route('settings.masters.struktur-organisasi.index'));
});

// settings > masters > jabatan
Breadcrumbs::for('settings.masters.jabatan.index', function (BreadcrumbTrail $trail) {
    $trail->parent('settings.masters.index');
    $trail->push('Jabatan');
});

// settings > masters > status-pegawai
Breadcrumbs::for('settings.masters.status-pegawai.index', function (BreadcrumbTrail $trail) {
    $trail->parent('settings.masters.index');
    $trail->push('Status pegawai');
});

// settings > masters > libur
Breadcrumbs::for('settings.masters.libur.index', function (BreadcrumbTrail $trail) {
    $trail->parent('settings.masters.index');
    $trail->push('Libur');
});

// settings > masters > kartu-identitas
Breadcrumbs::for('settings.masters.kartu-identitas.index', function (BreadcrumbTrail $trail) {
    $trail->parent('settings.masters.index');
    $trail->push('Kartu identitas');
});

// settings > masters > negara
Breadcrumbs::for('settings.masters.negara.index', function (BreadcrumbTrail $trail) {
    $trail->parent('settings.masters.index');
    $trail->push('Negara');
});

// settings > masters > pendidikan
Breadcrumbs::for('settings.masters.pendidikan.index', function (BreadcrumbTrail $trail) {
    $trail->parent('settings.masters.index');
    $trail->push('Pendidikan');
});

// settings > masters > status-ijin
Breadcrumbs::for('settings.masters.status-ijin.index', function (BreadcrumbTrail $trail) {
    $trail->parent('settings.masters.index');
    $trail->push('Status ijin');
});

// settings > masters > jabatan > struktural
Breadcrumbs::for('settings.masters.jabatan.struktural.index', function (BreadcrumbTrail $trail) {
    $trail->parent('settings.masters.jabatan.index');
    $trail->push('Struktural', route('settings.masters.jabatan.struktural.index'));
});

// settings > masters > jabatan > fungsional
Breadcrumbs::for('settings.masters.jabatan.fungsional.index', function (BreadcrumbTrail $trail) {
    $trail->parent('settings.masters.jabatan.index');
    $trail->push('Fungsional', route('settings.masters.jabatan.fungsional.index'));
});

// settings > masters > sub-unit
Breadcrumbs::for('settings.masters.sub-unit.index', function (BreadcrumbTrail $trail) {
    $trail->parent('settings.masters.index');
    $trail->push('Sub unit', route('settings.masters.sub-unit.index'));
});

// profile
Breadcrumbs::for('profile.index', function (BreadcrumbTrail $trail) {
    $trail->push('Profile', route('profile.index'));
});

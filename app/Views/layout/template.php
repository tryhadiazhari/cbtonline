<?php
function buat_tanggal($format, $time = null)
{
    $time = ($time == null) ? time() : strtotime($time);
    $str = date($format, $time);
    for ($t = 1; $t <= 9; $t++) {
        $str = str_replace("0$t ", "$t ", $str);
    }
    $str = str_replace("Jan", "Januari", $str);
    $str = str_replace("Feb", "Februari", $str);
    $str = str_replace("Mar", "Maret", $str);
    $str = str_replace("Apr", "April", $str);
    $str = str_replace("May", "Mei", $str);
    $str = str_replace("Jun", "Juni", $str);
    $str = str_replace("Jul", "Juli", $str);
    $str = str_replace("Aug", "Agustus", $str);
    $str = str_replace("Sep", "September", $str);
    $str = str_replace("Oct", "Oktober", $str);
    $str = str_replace("Nov", "November", $str);
    $str = str_replace("Dec", "Desember", $str);
    $str = str_replace("Mon", "Senin", $str);
    $str = str_replace("Tue", "Selasa", $str);
    $str = str_replace("Wed", "Rabu", $str);
    $str = str_replace("Thu", "Kamis", $str);
    $str = str_replace("Fri", "Jumat", $str);
    $str = str_replace("Sat", "Sabtu", $str);
    $str = str_replace("Sun", "Minggu", $str);
    return $str;
}
function timeAgo($tanggal)
{
    $ayeuna = date('Y-m-d H:i:s');
    $detik = strtotime($ayeuna) - strtotime($tanggal);
    if ($detik <= 0) {
        return "Baru saja";
    } else {
        if ($detik < 60) {
            return $detik . " detik yang lalu";
        } else {
            $menit = $detik / 60;
            if ($menit < 60) {
                return number_format($menit, 0) . " menit yang lalu";
            } else {
                $jam = $menit / 60;
                if ($jam < 24) {
                    return number_format($jam, 0) . " jam yang lalu";
                } else {
                    $hari = $jam / 24;
                    if ($hari < 2) {
                        return "Kemarin";
                    } elseif ($hari < 3) {
                        return number_format($hari, 0) . " hari yang lalu";
                    } else {
                        return $tanggal;
                    }
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title . " | " . $setting['appname']; ?></title>

    <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"> -->
    <link rel="stylesheet" href="/assets/plugins/fontawesome/css/all.css">
    <link rel="stylesheet" href="/assets/plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/plugins/ionicons/docs/css/ionicons.min.css">
    <link rel="stylesheet" href="/assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <link rel="stylesheet" href="/assets/plugins/jqvmap/jqvmap.min.css">
    <link rel="stylesheet" href="/assets/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="/assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <link rel="stylesheet" href="/assets/dist/css/loader.css">
    <link rel="stylesheet" type="text/css" href="/assets/plugins/animate/animate.min.css">
    <link rel="stylesheet" href="/assets/plugins/sweetalert2/sweetalert2.min.css">
    <?= $this->renderSection('css'); ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-footer-fixed text-sm">
    <div class="wrapper">
        <div id="loader">
            <div class="lds-ring d-flex justify-content-center">
                <div class="d-flex justify-content-center"></div>
                <div class="d-flex justify-content-center"></div>
                <div class="d-flex justify-content-center"></div>
                <div class="d-flex justify-content-center"></div>
            </div>
        </div>
        <?= $this->include('layout/navbar'); ?>

        <aside class="main-sidebar main-sidebar-custom sidebar-dark-primary">
            <a href="<?= (session()->lv == 1) ? '/admin' : '/' ?>" class="brand-link">
                <img src="/assets/dist/img/haz-logo.png" alt="AdminLTE Logo" class="brand-image img-circle" style="opacity: .8; background: white">
                <span class="brand-text font-weight-light"><?= $setting['appname']; ?></span>
            </a>

            <div class="sidebar">
                <div class="user-panel py-2 d-flex">
                    <div class="image">
                        <img src="/assets/dist/img/<?= session()->lv == 1 ? 'avatar_default.png' : ($datalembaga['logo'] == '' ? 'avatar-6.png' : $datalembaga['logo']); ?>" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="<?= (session()->lv == 1) ? '/admin' : '/' ?>" class="d-block"><?= session()->fname ?></a>
                    </div>
                </div>

                <?= $this->include('layout/menu'); ?>
            </div>

            <div class="sidebar-custom bg-danger nav-pills nav-sidebar flex-column" style="padding: 0; margin-top:">
                <button onclick="window.location='<?= base_url('auth/logout'); ?>'" class="nav-link btn btn-block" style="border-radius: 0">
                    <i class="fas fa-sign-out fa-lg fa-fw text-light"></i>
                    <p class="text-light">Keluar</p>
                </button>
            </div>
        </aside>

        <div class="content-wrapper">
            <?= $this->renderSection('content'); ?>
            <div class='detailview'></div>
        </div>

        <footer class="main-footer">
            <strong>Copyright &copy; <?= date('Y') ?> <a href="#"><?= $setting['company']; ?></a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> <?= $setting['version']; ?>
            </div>
        </footer>
    </div>

    <script src="/assets/plugins/jquery/jquery.min.js"></script>
    <script src="/assets/plugins/jquery-ui/jquery-ui.min.js"></script>
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <script src="/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/plugins/popper/umd/popper.min.js"></script>
    <script src="/assets/plugins/moment/moment.min.js"></script>
    <script src="/assets/plugins/moment/locale/id.js"></script>
    <script src="/assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <script src="/assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <script src="/assets/dist/js/adminlte.min.js"></script>
    <script src="/assets/plugins/sweetalert2/sweetalert2.all.min.js"></script>
    <?= $this->renderSection('plugins'); ?>
    <script>
        $(window).on('load', function() {
            $('#loader').fadeOut('slow');
        });

        var url = window.location.href;
        var str = url.split("/");

        $('a.nav-link').filter(function() {
            if (<?= session()->lv ?> == 1) {
                return this.href == '<?= base_url() ?>/' + str[3] + '/' + str[4];
            } else {
                return this.href == '<?= base_url() ?>/' + str[3];
            }
        }).addClass('active');

        $('ul.nav-treeview a').filter(function() {
            if (<?= session()->lv ?> == 1) {
                return this.href == '<?= base_url() ?>/' + str[3] + '/' + str[4];
            } else {
                return this.href == '<?= base_url() ?>/' + str[3];
            }
        }).closest('.has-treeview').addClass('menu-open');

        $(document).ready(function() {
            var autoRefresh = setInterval(function() {
                // $("#log-list").load('/loaddata/log');
                $("#waktu").load('/loaddata/times');
            }, 1000);

            $('#ceksemua').change(function() {
                $(this).parents('#datatabel:eq(0)').find(':checkbox').attr('checked', this.checked);
            });
        });
    </script>
    <?= $this->renderSection('script'); ?>
</body>

</html>
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="<?= base_url() ?>" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item">
                    <h4 class="nav-link d-none d-lg-block py-0 my-0 mb-1" style='text-shadow: 2px 2px 4px #827e7e;'>
                        <span><?= (session()->lv == 2) ? $setting['appname'] . " | " . $datalembaga['sp'] : $setting['appname']; ?> <small class="fs-6">Control Panel</small></span>
                    </h4>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <div class="text-bold nav-link px-0">
                        <i class='fas fa-calendar fa-fw'></i>&nbsp;<?= buat_tanggal('D, d M Y') ?>
                    </div>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <div class="text-bold nav-link">
                        <i class="fas fa-clock fa-fw"></i>&nbsp;<span id='waktu' class="text-sm-left"><?= date("H:i:s") ?></span>
                    </div>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->
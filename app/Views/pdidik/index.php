<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="card card-outline card-primary col-12">
                <div class="card-header px-3">
                    <div class="row">
                        <div class="col">
                            <h4 class="card-header p-0 m-0" style="border: none"><?= $titlecontent ?></h4>
                        </div>
                        <div class="col-auto me-auto">
                            <button type="submit" class="btn btn-success btn-sm">
                                <i class="fas fa-download"></i>
                                <span class="d-none d-lg-inline">Import Data</span>
                            </button>
                            <button type="button" class="btn btn-primary btn-sm" onclick="window.location='/pd/tambah'">
                                <i class="fas fa-plus"></i> <span class="d-none d-lg-inline">Tambah</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="viewpd"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class='modalview'></div>

<!-- /.content -->
<?= $this->endSection(); ?>
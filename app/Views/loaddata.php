<?php if ($type  == 'pengumuman') : ?>
    <?php if (count($datapengumuman) > 0) : ?>
        <?php foreach ($datapengumuman as $pengumuman) : ?>
            <div class="timeline">
                <!-- timeline time label -->
                <div class="time-label">
                    <span class="bg-primary"><?= date('d-m-Y', strtotime($pengumuman['date_created'])) ?></span>
                </div>
                <!-- /.timeline-label -->
                <!-- timeline item -->
                <div>
                    <i class="fas fa-<?= ($pengumuman['type'] == 'info') ? "info alert-info" : "envelope bg-primary bg-gradient" ?>"></i>
                    <div class="timeline-item">
                        <span class="time text-light"><i class="fas fa-clock"></i> <?= date('H:i', strtotime($pengumuman['time_created'])) ?></span>
                        <h3 class="timeline-header alert-info"><a><?= $pengumuman['judul'] ?></a> | <small>By: <?= $pengumuman['fullname'] ?></small></h3>

                        <div class="timeline-body"><?= $pengumuman['text'] ?></div>
                    </div>
                </div>
                <!-- END timeline item -->
            </div>
        <?php endforeach ?>
    <?php else : ?>
        <p class='text-center'>
            Tidak ada pengumuman apapun saat ini...
        </p>
    <?php endif ?>
<?php elseif ($type  == 'log') : ?>
    <?php if (count($datalog) == 0) : ?>
        <p class="text-center">Tidak ada Aktifitas Log saat ini...</p>
    <?php else : ?>
        <div class='direct-chat-messages' style="max-height: 100%">
            <!-- Message. Default to the left -->

            <?php foreach ($datalog as $log) : ?>
                <div class="direct-chat-msg <?= ($log->type == 'testongoing') ? 'right' : '' ?>">
                    <div class="direct-chat-infos clearfix">
                        <span class="direct-chat-name <?= ($log->type == 'testongoing') ? 'float-right' : 'float-left' ?>"><?= $log->nama ?></span>
                        <span class="direct-chat-timestamp <?= ($log->type == 'testongoing') ? 'float-left' : 'float-right' ?>"><?= date('d M Y H:i', strtotime($log->date)) ?></span>
                    </div>
                    <!-- /.direct-chat-infos -->
                    <img class='direct-chat-img' src='<?= base_url() ?>/assets/dist/img/svg/manager.svg' alt='message user image'>
                    <!-- /.direct-chat-img -->
                    <div class="direct-chat-text">
                        <?= $log->text ?>
                    </div>
                    <!-- /.direct-chat-text -->
                </div>
            <?php endforeach ?>
        </div>
    <?php endif ?>
<?php endif; ?>
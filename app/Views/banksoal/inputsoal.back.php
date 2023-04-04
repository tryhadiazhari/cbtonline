            <form class="formsoal" action="/banksoal/upsoal" method="POST">
                <div class="card card-outline card-primary p-0">
                    <div class="card-header px-3" <?= (session()->get('level') == 2) ? 'style="display: none"' : ''; ?>>
                        <div class="row">
                            <div class="col">
                                <h5 class="card-header p-0 m-0" style="border: none"><?= $titlecontent . " " . $tampildata['nama'] . " | " . $tampildata['rombel'] ?></h5>
                            </div>
                            <div class="col-auto ms-auto">
                                <button type="submit" class="btn btn-success btn-sm btn-soal-save">
                                    <i class="fas fa-save"></i> <span class="d-none d-lg-inline">Simpan</span>
                                </button>
                                <a class="btn" href="../../../../view/<?= $tampildata['id_mapel'] ?>"><i class="fas fa-times"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <input type="hidden" name="mapel" value="<?= $tampildata['id_mapel'] ?>">
                        <input type="hidden" name="jenis" value="<?= service('uri')->getSegment(4) ?>">
                        <input type="hidden" name="idsoal" value="<?= $tampilsoalpg['id_soal'] ?>">
                        <input type="hidden" name="opsi" value="<?= $tampildata['opsi'] ?>">

                        <div class="row">
                            <div class="col<?= (service('uri')->getSegment(4) == 1) ? "-6" : "" ?>">
                                <?php foreach ($tampilsoal as $soal) : ?>
                                    <button type="button" class="btn btn-<?= ($soal['nomor'] == service('uri')->getSegment(5)) ? "primary" : "default" ?> btn-xs nomsoal mb-2" data-id="<?= $tampildata['id_mapel'] ?>" data-soal="<?= $soal['nomor'] ?>"><?= $soal['nomor'] ?></button>
                                <?php endforeach; ?>
                                <hr>
                                <textarea name='soal' class='editor' rows='10' cols='80' style='resize: none; width:100%;'><?= ucfirst($tampilsoalpg['soal']) ?></textarea>
                            </div>
                            <?php if (service('uri')->getSegment(4) == 1) : ?>
                                <div class="col-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="accordion accordion-flush card" id="accordionFlushExample">
                                                <?php $array = [1 => 'A', 2 => 'B', 3 => 'C', 4 => 'D', 5 => 'E'];
                                                for ($ii = 1; $ii <= $tampildata['opsi']; $ii++) : ?>
                                                    <div class="accordion-item">
                                                        <div class="row">
                                                            <div class="col-11">
                                                                <div class='card-header with-border'>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="jawaban" id="check<?= $array[$ii]; ?>" value="<?= $array[$ii]; ?>" <?= ($tampilsoalpg['jawaban'] == $array[$ii]) ? "checked" : "" ?>>
                                                                        <label class="form-check-label" for="flexRadioDefault1">
                                                                            <h4 class="btn m-0 p-0 card-title collapsed" id="flush-headingOne" data-toggle="collapse" data-target="#flush-<?= $array[$ii]; ?>" aria-expanded="<?= (($array[$ii] == $tampilsoalpg['jawaban'])) ? "true" : "false" ?>" aria-controls="flush-<?= $array[$ii]; ?>">
                                                                                Pilihan Jawaban <?= $array[$ii]; ?>
                                                                            </h4>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div id="flush-<?= $array[$ii]; ?>" class="accordion-collapse collapse <?= (($array[$ii] == $tampilsoalpg['jawaban'])) ? "show" : "" ?>" aria-labelledby=" flush-headingOne" data-parent="#accordionFlushExample">
                                                            <div class="accordion-body">
                                                                <textarea name="pil<?= $array[$ii] ?>" class='pilihan form-control'><?= ($array[$ii] == $tampilsoalpg['jawaban']) ? ucfirst($tampilsoalpg['pil' . $array[$ii]]) : ucfirst($tampilsoalpg['pil' . $array[$ii]]) ?></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endfor; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </form>
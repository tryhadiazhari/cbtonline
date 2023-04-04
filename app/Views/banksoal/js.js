function _load() {
    $.ajax({
        url: "<?= base_url('/banksoal/view'); ?>",
        dataType: "json",
        success: function(response) {
            $('.view').html(response.data);

            $('#example1').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "processing": true,
                "aoColumnDefs": [{
                    "bSortable": false,
                    "aTargets": ["no-short"]
                }],
            });
            
            $('#ceksemua').change(function () {
                $(this).parents('#example1:eq(0)').
                    find(':checkbox').attr('checked', this.checked);
            });
       }
    });

    loadsoal();
}

function loadsoal()
{
    var url = window.location.href;
    var str = url.split("/");

    if (str[4] == 'pg') {
        $.ajax({
            url: '/banksoal/soal/' + str[5] + '/' + str[6] + '/' + str[7],
            data: {},
            success: function (html) {
                document.getElementById("contentsoal").innerHTML = html;
                $('.nomsoal').click(function (e) {
                    e.preventDefault();

                    window.history.pushState('', '', '/banksoal/pg/' + $(this).data('id') + '/' + str[6] + '/' + $(this).data('soal'));
                    loadsoal();
                });
                        
                $('body').addClass('sidebar-collapse');

                tinymce.init({
                    selector: 'textarea',
                    resize: false,
                    plugins: [
                        'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                        'searchreplace wordcount visualblocks visualchars code fullscreen',
                        'insertdatetime nonbreaking save table contextmenu directionality',
                        'emoticons template paste textcolor colorpicker textpattern imagetools uploadimage paste formula'
                    ],
										
                    toolbar: 'bold italic fontselect fontsizeselect | alignleft aligncenter alignright bullist numlist  backcolor forecolor | formula code | imagetools link image paste ',
                    fontsize_formats: '8pt 10pt 12pt 14pt 18pt 24pt 36pt',
                    paste_data_images: true,
										
                    images_upload_handler: function (blobInfo, success, failure) {
                        success('data:' + blobInfo.blob().type + ';base64,' + blobInfo.base64());
                    },
                    image_class_list: [
                        { title: 'Responsive', value: 'img-fluid' }
                    ],
                });
            }
        });
    }
    else {
        $.ajax({
            url: '/banksoal/soal/' + str[5] + '/' + str[6] + '/' + str[7],
            data: {},
            success: function (html) {
                document.getElementById("contentsoal").innerHTML = html;
                $('.nomsoal').click(function (e) {
                    e.preventDefault();

                    window.history.pushState('', '', '/banksoal/essai/' + $(this).data('id') + '/' + str[6] + '/' + $(this).data('soal'));
                    loadsoal();
                });
                        
                $('body').addClass('sidebar-collapse');

                tinymce.init({
                    selector: 'textarea',
                    resize: false,
                    plugins: [
                        'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                        'searchreplace wordcount visualblocks visualchars code fullscreen',
                        'insertdatetime nonbreaking save table contextmenu directionality',
                        'emoticons template paste textcolor colorpicker textpattern imagetools uploadimage paste formula'
                    ],
										
                    toolbar: 'bold italic fontselect fontsizeselect | alignleft aligncenter alignright bullist numlist  backcolor forecolor | formula code | imagetools link image paste ',
                    fontsize_formats: '8pt 10pt 12pt 14pt 18pt 24pt 36pt',
                    paste_data_images: true,
										
                    images_upload_handler: function (blobInfo, success, failure) {
                        success('data:' + blobInfo.blob().type + ';base64,' + blobInfo.base64());
                    },
                    image_class_list: [
                        { title: 'Responsive', value: 'img-fluid' }
                    ],
                });
            }
        });
    }
}

$(document).ready(function () {
    _load();

    $(window).on("popstate", function (e) {
        loadsoal();
    });
    
    $("#id_pk").change(function () {
        var idpk = $("#id_pk option:selected").data('id');
        // console.log(idpk);

        $.ajax({
            type: "POST",
            url: "/banksoal/datalevel",
            data: {
                'id': idpk
            },
            dataType: 'json',
            success: function (response) {
                $("#soallevel").html('<option disabled selected></option>');
                $("#soalkelas").html('<option disabled selected></option>');
                $("#nama").html('<option disabled selected></option>');
               
                response.level.forEach(function (e) {
                    $("#soallevel").append('<option value="' + e.keterangan + '" data-value="' + e.jenjang + '">' + e.keterangan + '</option>');
                });

                $("#soallevel").change(function () {
                    $("#soalkelas").attr('style', 'display: none');
                    if (response.userlevel == 1) {
                        $("#nama").html('<option disabled selected></option>');
                        response.mapel.forEach(function (eee) {
                            if ($("#id_pk option:selected").val() == 'IPS' || $("#id_pk option:selected").val() == 'IPA') {
                                if (eee.kurikulum == '' && eee.program == '') {
                                    $("#nama").append('<option value="' + eee.nama_mapel + '" data-id="' + eee.kode_mapel + '" data-alias="' + eee.alias + '">' + eee.nama_mapel + '</option>');
                                }
                                if (eee.kurikulum == 'Kurikulum Paket C '+ $("#id_pk option:selected").val() +' 2013' && eee.program == $("#soallevel option:selected").data('value')) {
                                    $("#nama").append('<option value="' + eee.nama_mapel + '" data-id="' + eee.kode_mapel + '" data-alias="' + eee.alias + '">' + eee.nama_mapel + '</option>');
                                }
                            }
                            else {
                                if (eee.kurikulum == '' && eee.program == '') {
                                    $("#nama").append('<option value="' + eee.nama_mapel + '" data-id="' + eee.kode_mapel + '" data-alias="' + eee.alias + '">' + eee.nama_mapel + '</option>');
                                }
                                else if (eee.kurikulum == '' && eee.program == 'Paket A, Paket B') {
                                    $("#nama").append('<option value="' + eee.nama_mapel + '" data-id="' + eee.kode_mapel + '" data-alias="' + eee.alias + '">' + eee.nama_mapel + '</option>');
                                }
                            }
                        });
                    }
                    else {
                        response.kelas.forEach(function (ee) {
                            if (ee.id_pk == $("#id_pk option:selected").val() && ee.tingkatan == $("#soallevel option:selected").val()) {
                                $("#soalkelas").append('<option value="' + ee.nama + '" data-kurikulum="' + ee.kurikulum + '">' + ee.nama + '</option>');
                            }
                        });
                    }
                });

                $("#soalkelas").change(function () {
                    $("#nama").html('<option disabled selected></option>');
                    response.mapel.forEach(function (eee) {
                        if ($("#id_pk option:selected").val() == 'IPS' || $("#id_pk option:selected").val() == 'IPA') {
                            if (eee.kurikulum == '' && eee.program == '') {
                                $("#nama").append('<option value="' + eee.nama_mapel + '" data-id="' + eee.kode_mapel + '" data-alias="' + eee.alias + '">' + eee.nama_mapel + '</option>');
                            }
                            if ($("#soalkelas option:selected").data('kurikulum') == eee.kurikulum) {
                                $("#nama").append('<option value="' + eee.nama_mapel + '" data-id="' + eee.kode_mapel + '" data-alias="' + eee.alias + '">' + eee.nama_mapel + '</option>');
                            }
                        }
                        else {
                            if (eee.kurikulum == '' && eee.program == '') {
                                $("#nama").append('<option value="' + eee.nama_mapel + '" data-id="' + eee.kode_mapel + '" data-alias="' + eee.alias + '">' + eee.nama_mapel + '</option>');
                            }
                            else if (eee.kurikulum == '' && eee.program == 'Paket A, Paket B') {
                                $("#nama").append('<option value="' + eee.nama_mapel + '" data-id="' + eee.kode_mapel + '" data-alias="' + eee.alias + '">' + eee.nama_mapel + '</option>');
                            }
                        }
                    });
                });
            }
        });
    });

    $('#soalpg, #soalpg2').keyup(function () {
        $('#tampilpg, #tampilpg2').val(this.value);
    });
	
    $('#soalesai, #soalesai2').keyup(function () {
        $('#tampilesai, #tampilesai2').val(this.value);
    });

    $(document).on('submit', '.formtambah', function (ev) {
        ev.preventDefault();

        var idmapel = $("#nama option:selected").data("id");
        var idpk = $("#id_pk").val();
        var idguru = $("#guru").val();
        var level = $("#soallevel").val();
        var rombel = $("#soalkelas").val();
        var nama = $("#nama").val();
        var alias = $("#nama option:selected").data("alias");
        var jmlsoal = $("#soalpg").val();
        var jmlesai = $("#soalesai").val();
        var tampilpg = $("#tampilpg").val();
        var tampilesai = $("#tampilesai").val();
        var bobotpg = $("#bobot_pg").val();
        var bobotesai = $("#bobot_esai").val();
        var opsi = $("#opsi").val();
        var tgl = "<?= date('Y-m-d H:i:s') ?>";
        var status = $("#status").val();
        var paket_soal = $("#paketsoal").val();

        $.ajax({
            url: $(this).attr('action'),
            type: 'post',
            data: {
                idmapel: idmapel,
                idpk: idpk,
                idguru: idguru,
                level: level,
                rombel: rombel,
                nama: nama,
                alias: alias,
                jmlsoal: jmlsoal,
                jmlesai: jmlesai,
                tampilpg: tampilpg,
                tampilesai: tampilesai,
                bobotpg: bobotpg,
                bobotesai: bobotesai,
                opsi: opsi,
                tgl: tgl,
                status: status,
                paket_soal: paket_soal,
            },
            dataType: 'json',
            beforeSend: function () {
                $('#save').html('<i class="fas fa-spin fa-spinner"></i>');
            },
            complete: function () {
                $("#save").html('Simpan');
            },
            success: function (response) {
                if (response.sukses) {
                    window.location = response.redirect;
                }
                else {
                    window.location = response.redirect;
                }
            }
        });
    });

    $(document).on('click', '.banksoal-edit', function (e) {
        e.preventDefault();
        $.ajax({
            url: $(this).data('href'),
            data: {
                'id': $(this).data('id')
            },
            type: 'post',
            dataType: 'json',
            success: function (response) {
                _load();
                if (response.access) {
                    $('.modalview').html(response.access);
                    $("#edit").modal('show');
                }
                $('#soalpg, #soalpg2').keyup(function () {
                    $('#tampilpg, #tampilpg2').val(this.value);
                });
	
                $('#soalesai, #soalesai2').keyup(function () {
                    $('#tampilesai, #tampilesai2').val(this.value);
                });

                $("select").select2({
                    placeholder: $("select").data('placeholder'),
                    theme: 'bootstrap4',
                });
            }
        })
    });

    $(document).on('click', '.delete-all', function () {
        swal.fire({
            icon: 'info',
            html: 'Anda ingin hapus semua soal ini?',
            confirmButtonText: 'Ya',
            showCancelButton: true,
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: $(this).data('href'),
                    dataType: 'json',
                    success: function (response) {
                        if (response.sukses) {
                            location.reload();
                        } else {
                            location.reload();
                        }
                    }
                });
            }
        })
    });

    $(document).on('click', '.delete-soal', function () {
        swal.fire({
            icon: 'info',
            html: 'Anda ingin hapus soal ini?',
            confirmButtonText: 'Ya',
            showCancelButton: true,
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: $(this).data('href'),
                    dataType: 'json',
                    success: function (response) {
                        if (response.sukses) {
                            location.reload();
                        } else {
                            location.reload();
                        }
                    }
                });
            }
        })
    });

    $(document).on('submit', '.formsoal', function (e) {
        e.preventDefault();

        $.ajax({
            url: $(this).attr('action'),
            data: $(this).serialize(),
            type: 'post',
            dataType: 'json',
            beforeSend: function () {
                $('.btn-soal-save').html('<i class="fas fa-spin fa-spinner"></i>');
            },
            complete: function () {
                $('.btn-soal-save').html('<i class="fas fa-save"></i> <span class="d-none d-lg-inline">Simpan</span>');
            },
            success: function (response) {
                loadsoal();
                Swal.fire({
                    icon: response.confirm.icon,
                    title: response.confirm.pesan,
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        });
    });

    $("#cetaksoal").attr('src');
    $("#cetaksoalkunci").attr('src');
});
function getPenguji(id) {
    $.ajax({
        url: "/penguji/" + id,
        type: "GET",
        success: function(response) {
            let setStation = JSON.parse(response);
            let html = ''
            let btn = ''
            let no = 0
            if (setStation == 0) {
                html += '<tr>'
                html += '<td style="text-align:center" colspan="5">Station belum di-generate</td>'
                html += '</tr>'
                btn += '<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>'
            } else {
                setStation.forEach(station => {
                    let mahasiswa = collectMahasiswa(station.mahasiswa)
                    let penguji = collectPenguji(station.penguji)
                    no++
                    html += '<tr>'
                    html += '<td class="' + ((station.stationStatus == 'Rest') ? 'text-danger' : '') + '">' + no + '</td>'
                    html += '<td class="' + ((station.stationStatus == 'Rest') ? 'text-danger' : '') + '">' + station.lokasiNama + '</td>'
                    html += '<td class="' + ((station.stationStatus == 'Rest') ? 'text-danger' : '') + '">' + station.stationNama + '</td>'
                    html += '<td>'
                    html += '<select name="penguji,' + station.lokasiId + ',' + station.stationId + '" class="form-control">'
                    html += '<option value="">--Pilih Penguji--</option>'
                    html += penguji
                    html += '</select>'
                    html += '</td>'
                    html += '<td>'
                    html += '<select name="peserta,' + station.lokasiId + ',' + station.stationId + '" class="form-control">'
                    html += '<option value="">--Pilih Peserta--</option>'
                    html += mahasiswa
                    html += '</select>'
                    html += '</td>'
                    html += '</tr>'
                });
                $('.datastation').find('select').select2()
                $('#simpanstation').attr('action', '/penguji/' + id)
                btn += '<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>'
                btn += '<button type="submit" class="btn btn-primary">Save</button>'
            }
            $('#btnFooter').empty()
            $('#btnFooter').append(btn)
            $('.datastation').empty()
            $('.datastation').append(html)
            $('#editPenguji').modal('show')
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        },
    })
}

function getPertanyaan(id) {
    let station = ''
    $.ajax({
        url: "/pertanyaan/" + id,
        type: "GET",
        success: function(response) {
            let pertanyaan = JSON.parse(response);
            let content = ''
            let tab = []
            let btn = ''
            if (pertanyaan == 0) {
                tab += '<li class="nav-item">'
                tab += '<a class="nav-link active" id="station1-tab" data-toggle="tab" href="#station1" role="tab" aria-controls="station1" aria-selected="true">Station 1</a>'
                tab += '</li>'
                content += '<div class="tab-pane fade show active" id="station1" role="tabpanel" aria-labelledby="station1-tab">'
                content += '<textarea class="skenario" name="skenario,1"></textarea>'
                content += '<div class="table-responsive">'
                content += '<table class="table table-striped table-bordered">'
                content += '<thead>'
                content += '<tr>'
                content += '<th style="text-align:center" scope="col" width="5%">No.</th>'
                content += '<th scope="col">Nama Kompetensi</th>'
                content += '<th scope="col" width="55%">Tugas</th>'
                content += '<th scope="col" width="15%">Bobot</th>'
                content += '</tr>'
                content += '</thead>'
                content += '<tbody>'
                content += '<tr>'
                content += '<td style="text-align:center" colspan="4">Pertanyaan belum di-generate</td>'
                content += '</tr>'
                content += '</tbody>'
                content += '</table>'
                content += '</div>'
                content += '</div>'
                btn += '<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>'
            } else {
                let flags = [],
                    output = [],
                    skenario = [],
                    attachment = [],
                    pendukung = [],
                    stat = [],
                    l = pertanyaan.length,
                    i;
                for (i = 0; i < l; i++) {
                    if (flags[pertanyaan[i].stationId]) continue;
                    flags[pertanyaan[i].stationId] = true
                    output.push(pertanyaan[i].stationId)
                    stat.push(pertanyaan[i].stationStatus)
                    attachment.push(pertanyaan[i].stationAttachment)
                    pendukung.push(pertanyaan[i].stationPendukung)
                    skenario.push(pertanyaan[i].skenario)
                }
                let urut = 0
                output.forEach(title => {
                    let status = ''
                    let ss = urut;
                    let color = '';
                    urut++;
                    if (urut == 1) {
                        status = 'active'
                    }
                    if (stat[ss] == 'Rest') {
                        status = 'disabled'
                        color = 'text-danger '
                    }
                    tab += '<li class="nav-item">'
                    tab += '<a class="nav-link ' + color + status + '" id="station' + title + '-tab" data-toggle="tab" href="#station' + title + '" role="tab" aria-controls="station' + title + '" aria-selected="true">Station ' + title + '</a>'
                    tab += '</li>'
                });
                let urutC = 0
                output.forEach(title => {
                    let statusC = ''
                    let scene = (skenario[urutC] == null) ? '' : skenario[urutC]
                    let attach = (attachment[urutC] == null) ? '' : JSON.parse(attachment[urutC])
                    let pend = (pendukung[urutC] == null) ? '' : pendukung[urutC]
                    urutC++;
                    if (urutC == 1) {
                        statusC = 'active'
                    }
                    content += '<div class="tab-pane fade show ' + statusC + '" id="station' + title + '" role="tabpanel" aria-labelledby="station' + title + '-tab">'
                    content += '<div class="row">'
                    content += '<div class="col-md-6">'
                    content += '<div class="form-group">'
                    content += '<label>Instruksi Penilaian</label>'
                    content += '<div class="custom-file">'
                    content += '<input type="file" accept="application/pdf" class="custom-file-input" name="instruksi,' + title + '" value="' + ((attach[0] != null) ? attach[0] : '') + '" id="instruksi,' + title + '" onchange="labelInstruksi(' + title + ')">'
                    content += '<label class="custom-file-label" id="labelInstruksi,' + title + '" for="instruksi,' + title + '">' + ((attach[0] != null) ? attach[0] : 'Choose file') + '</label>'
                    content += '</div>'
                    content += '</div>'
                    content += '</div>'
                    content += '<div class="col-md-6">'
                    content += '<div class="form-group">'
                    content += '<label>Rubrik Penilaian</label>'
                    content += '<div class="custom-file">'
                    content += '<input type="file" accept="application/pdf" class="custom-file-input" name="rubrik,' + title + '" value="' + ((attach[1] != null) ? attach[1] : '') + '" id="rubrik,' + title + '" onchange="labelRubrik(' + title + ')">'
                    content += '<label class="custom-file-label" id="labelRubrik,' + title + '" for="rubrik,' + title + '">' + ((attach[1] != null) ? attach[1] : 'Choose file') + '</label>'
                    content += '</div>'
                    content += '</div>'
                    content += '</div>'
                    content += '</div>'
                    if (pend == '') {
                        content += '<div class="form-group">'
                        content += '<label style="display: inline-block; padding-left: 0 !important;" class="custom-switch mt-2">'
                        content += '<input type="checkbox" name="cekFilePendukung,' + title + '" class="custom-switch-input" onchange="filePendukung(' + title + ')" ' + ((pend != '') ? 'checked' : '') + '>'
                        content += '<span class="custom-switch-indicator mb-1 mr-1"></span>'
                        content += '</label>'
                        content += '<label>Tambahkan File Pendukung</label>'
                        content += '</div>'
                        content += '<div class="form-group" id="filePendukung,' + title + '">'
                        content += '</div>'
                    } else {
                        content += '<div class="form-group">'
                        content += '<label>File Pendukung</label>'
                        content += '<div class="custom-file">'
                        content += '<input type="file" accept="application/pdf" class="custom-file-input" name="pendukung,' + title + '" value="' + ((pend != null) ? pend : '') + '" id="pendukung,' + title + '" onchange="labelPendukung(' + title + ')">'
                        content += '<label class="custom-file-label" id="labelPendukung,' + title + '" for="pendukung,' + title + '">' + ((pend != null) ? pend : 'Choose file') + '</label>'
                        content += '</div>'
                        content += '</div>'
                    }
                    content += '<textarea class="skenario" name="skenario,' + title + '">' + scene + '</textarea>'
                    content += '<div class="table-responsive">'
                    content += '<table class="table table-striped table-bordered">'
                    content += '<thead>'
                    content += '<tr>'
                    content += '<th style="text-align:center" scope="col" width="5%">No.</th>'
                    content += '<th scope="col">Nama Kompetensi</th>'
                    content += '<th scope="col" width="55%">Tugas</th>'
                    content += '<th scope="col" width="15%">Bobot</th>'
                    content += '</tr>'
                    content += '</thead>'
                    content += '<tbody>'
                    let no = 0
                    pertanyaan.forEach(quest => {
                        if (title == quest.stationId) {
                            no++
                            let isi = (quest.pertanyaan == null) ? '' : quest.pertanyaan
                            let bobot = quest.bobot
                            content += '<tr>'
                            content += '<td>' + no + '</td>'
                            content += '<td>' + quest.kompetensiNama + '</td>'
                            content += '<td><input type"text" class="form-control" name="tugas,' + quest.stationId + ',' + quest.kompetensiId + '" value="' + isi + '"/></td>'
                            content += '<td><input class="form-control" type="number" name="bobot,' + quest.stationId + ',' + quest.kompetensiId + '" value="' + bobot + '" oninput="setBobotMax(' + quest.stationId + ',' + quest.kompetensiId + ')" /></td>'
                            content += '</tr>'
                        }
                    });
                    content += '</tbody>'
                    content += '</table>'
                    content += '</div>'
                    content += '</div>'
                });
                $('#pertanyaan').attr('action', '/pertanyaan/' + id)
                btn += '<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>'
                btn += '<button type="submit" class="btn btn-primary">Save</button>'
            }
            $('#myTab').empty()
            $('#myTab').append(tab)
            $('#myTabContent').empty()
            $('#myTabContent').append(content)
            $('#myTabContent').find('.skenario').summernote({
                dialogsInBody: true,
                minHeight: 150,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough']],
                    ['para', ['paragraph']]
                ]
            })
            $('#btnFooter').empty()
            $('#btnFooter').append(btn)
                // if (pend != '') {
                //     filePendukung(1)
                // }
            $('#editPertanyaan').modal('show')
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        },
    })
}

function getCetakPertanyaan(id) {
    $.ajax({
        url: "/pertanyaan/" + id,
        type: "GET",
        success: function(response) {
            let pertanyaan = JSON.parse(response);
            let tab = []
            let content = ''
            let btn = ''
            if (pertanyaan == 0) {
                tab += '<li class="nav-item">'
                tab += '<a class="nav-link active" id="station1-tab" data-toggle="tab" href="#station1" role="tab" aria-controls="station1" aria-selected="true">Station 1</a>'
                tab += '</li>'
                content += '<div class="tab-pane fade show active" id="station1" role="tabpanel" aria-labelledby="station1-tab">'
                content += '<div class="card">'
                content += '<div class="card-header">'
                content += '<h4>SKENARIO KLINIK</h4>'
                content += '</div>'
                content += '<div class="card-body">'
                content += '<p>Pertanyaan belum di-generate</p>'
                content += '</div>'
                content += '</div>'
                content += '<div class="card">'
                content += '<div class="card-header">'
                content += '<h4>TUGAS</h4>'
                content += '</div>'
                content += '<div class="card-body">'
                content += '<p>Pertanyaan belum di-generate</p>'
                content += '</div>'
                content += '</div>'
                content += '</div>'
                btn += '<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>'
            } else {
                let flags = [],
                    output = [],
                    skenario = [],
                    stat = [],
                    l = pertanyaan.length,
                    i;
                for (i = 0; i < l; i++) {
                    if (flags[pertanyaan[i].stationId]) continue;
                    flags[pertanyaan[i].stationId] = true
                    output.push(pertanyaan[i].stationId)
                    stat.push(pertanyaan[i].stationStatus)
                    skenario.push(pertanyaan[i].skenario)
                }
                let urut = 0
                output.forEach(title => {
                    let status = ''
                    let ss = urut;
                    let color = '';
                    urut++;
                    if (urut == 1) {
                        status = 'active'
                    }
                    if (stat[ss] == 'Rest') {
                        status = 'disabled'
                        color = 'text-danger '
                    }
                    tab += '<li class="nav-item">'
                    tab += '<a class="nav-link ' + color + status + '" id="station' + title + '-tab" data-toggle="tab" href="#station' + title + '" role="tab" aria-controls="station' + title + '" aria-selected="true">Station ' + title + '</a>'
                    tab += '</li>'
                });
                let urutC = 0
                output.forEach(title => {
                    let statusC = ''
                    let scene = (skenario[urutC] == null || skenario[urutC] == '') ? 'Skenario belum dibuat' : skenario[urutC]
                    urutC++;
                    if (urutC == 1) {
                        statusC = 'active'
                    }
                    content += '<div class="tab-pane fade show ' + statusC + '" id="station' + title + '" role="tabpanel" aria-labelledby="station' + title + '-tab">'
                    content += '<div class="card">'
                    content += '<div class="card-header">'
                    content += '<h4>SKENARIO KLINIK</h4>'
                    content += '</div>'
                    content += '<div class="card-body">'
                    content += '<p>' + scene + '</p>'
                    content += '</div>'
                    content += '</div>'
                    let no = 0
                    content += '<div class="card">'
                    content += '<div class="card-header">'
                    content += '<h4>TUGAS</h4>'
                    content += '</div>'
                    content += '<div class="card-body">'
                    pertanyaan.forEach(quest => {
                        if (title == quest.stationId) {
                            if (quest.pertanyaan != null) {
                                no++
                                let isi = quest.pertanyaan
                                content += '<p>' + no + '. ' + isi + '</p>'
                            }
                        }
                    });
                    content += '</div>'
                    content += '</div>'
                    content += '</div>'
                });
                $('#pertanyaan').attr('action', '/pertanyaan/cetak/' + id)
                btn += '<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>'
                btn += '<button type="submit" class="btn btn-primary">Print</button>'
            }
            $('#myTab').empty()
            $('#myTab').append(tab)
            $('#myTabContent').empty()
            $('#myTabContent').append(content)
            $('#btnFooter').empty()
            $('#btnFooter').append(btn)
            $('#editPertanyaan').modal('show')
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        },
    })
}

function setBobotMax(st, km) {
    let bobotMax = $('[name="bobotMax"]').val();
    let val = $('[name="bobot,' + st + ',' + km + '"]').val();
    if (val !== '') {
        val = parseFloat(val);
        if (val < 0)
            val = 0;
        else if (val > bobotMax)
            val = bobotMax;
    }
    return $('[name="bobot,' + st + ',' + km + '"]').val(val)
}

function labelInstruksi(st) {
    const dokumen = document.querySelector('[id="instruksi,' + st + '"]');
    const dokumenLabel = document.querySelector('[id="labelInstruksi,' + st + '"]');

    dokumenLabel.textContent = dokumen.files[0].name;
}

function labelRubrik(st) {
    const dokumen = document.querySelector('[id="rubrik,' + st + '"]');
    const dokumenLabel = document.querySelector('[id="labelRubrik,' + st + '"]');

    dokumenLabel.textContent = dokumen.files[0].name;
}

function labelPendukung(st) {
    const dokumen = document.querySelector('[id="pendukung,' + st + '"]');
    const dokumenLabel = document.querySelector('[id="labelPendukung,' + st + '"]');

    dokumenLabel.textContent = dokumen.files[0].name;
}

function filePendukung(st) {
    if ($('[name="cekFilePendukung,' + st + '"]').is(':checked')) {
        let html = ''
        html += '<label>File Pendukung</label>'
        html += '<div class="custom-file">'
        html += '<input type="file" accept="application/pdf" class="custom-file-input" name="pendukung,' + st + '" id="pendukung,' + st + '" onchange="labelPendukung(' + st + ')">'
        html += '<label class="custom-file-label" id="labelPendukung,' + st + '" for="pendukung,' + st + '">Choose file</label>'
        html += '</div>'
        $('[id="filePendukung,' + st + '"]').empty()
        $('[id="filePendukung,' + st + '"]').append(html)
    } else {
        $('[id="filePendukung,' + st + '"]').empty()
    }
}

function filePendukungExit(st, data) {
    console.log('disini');
}

function cetakPenguji(id) {
    let html = ''
    html += '<p>Apakah kamu benar ingin mencetak penguji ini?</p>'
    $('#formCetakPenguji').attr('action', '/penguji/cetak/' + id)
    $('#dataCetakPenguji').empty()
    $('#dataCetakPenguji').append(html)
    $('#cetakPenguji').modal('show')
}

function collectMahasiswa(nim) {
    let html = ''
    $.ajax({
        url: "/penguji/mahasiswa",
        type: "GET",
        async: false,
        success: function(response) {
            if (JSON.parse(response).status) {
                JSON.parse(response).data.forEach(element => {
                    let status = (element.mahasiswaNpm == nim) ? 'selected' : ''
                    html += '<option value="' + element.mahasiswaNpm + '" ' + status + '>' + element.mahasiswaNpm + ' - ' + element.mahasiswaNama + '</option>'
                });
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        },
    })
    return html
}

function collectPenguji(id) {
    let html = ''
    $.ajax({
        url: "/penguji/penguji",
        type: "GET",
        async: false,
        success: function(response) {
            if (JSON.parse(response).status) {
                JSON.parse(response).data.forEach(element => {
                    let status = (element.pengujiId == id) ? 'selected' : ''
                    html += '<option value="' + element.pengujiId + '" ' + status + '>' + element.pengujiNama + '</option>'
                });
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        },
    })
    return html
}

$("#tambahPenguji").click(function() {
    var data = "";
    data += "<div class='form-group'>";
    data += "<input name='pengujiNama[]' type='text' class='form-control' required>";
    data += "</div>";
    $('#dosen').append(data);
});

$('#gambarApp').change(function() {
    const file = this.files[0];
    if (file) {
        let reader = new FileReader();
        reader.onload = function(event) {
            $('#previewGambarApp').attr('src', event.target.result);
        }
        reader.readAsDataURL(file);
    }
});

var _URL = window.URL || window.webkitURL;
$("#gambarApp").change(function(e) {
    var file, img;
    if ((file = this.files[0])) {
        img = new Image();
        img.onload = function() {
            if (this.width == 498 && this.height == 125) {
                let url = $("#gambarApp").val()
                console.log(url);
                var filename = url.substring(url.lastIndexOf('/') + 1);
                let html = ''
                html += "<p><strong>Dimension: 498px X 125px</strong></p>"
                html += "<button type='submit' class='btn btn-primary float-right'>Save Changes</button>"
                $('#dimGambarApp').empty()
                $('#dimGambarApp').append(html)
            } else {
                alert('Invalid Dimension Image');
                let html = ''
                html += "<p><strong>Dimension: 498px X 125px</strong></p>"
                $('#dimGambarApp').empty()
                $('#dimGambarApp').append(html)
            }
        };
        img.src = _URL.createObjectURL(file);
    }
});

function labelGambarApp() {
    const dokumen = document.querySelector('#gambarApp');
    const dokumenLabel = document.querySelector('.gambarAppLabel');

    dokumenLabel.textContent = dokumen.files[0].name;
}

$('#gambarHeader').change(function() {
    const file = this.files[0];
    if (file) {
        let reader = new FileReader();
        reader.onload = function(event) {
            $('#previewGambarHeader').attr('src', event.target.result);
        }
        reader.readAsDataURL(file);
    }
});

var _URL = window.URL || window.webkitURL;
$("#gambarHeader").change(function(e) {
    var file, img;
    if ((file = this.files[0])) {
        img = new Image();
        img.onload = function() {
            if (this.width == 512 && this.height == 512) {
                let url = $("#gambarHeader").val()
                var filename = url.substring(url.lastIndexOf('/') + 1);
                let html = ''
                html += "<p><strong>Dimension: 512px X 512px</strong></p>"
                html += "<button type='submit' class='btn btn-primary float-right'>Save Changes</button>"
                $('#dimGambarHeader').empty()
                $('#dimGambarHeader').append(html)
            } else {
                alert('Invalid Dimension Image');
                let html = ''
                html += "<p><strong>Dimension: 512px X 512px</strong></p>"
                $('#dimGambarHeader').empty()
                $('#dimGambarHeader').append(html)
            }
        };
        img.src = _URL.createObjectURL(file);
    }
});

function labelGambarHeader() {
    const dokumen = document.querySelector('#gambarHeader');
    const dokumenLabel = document.querySelector('.gambarHeaderLabel');

    dokumenLabel.textContent = dokumen.files[0].name;
}

function peringatan() {
    let checkedValue = $('input[name="setKehadiran"]').is(":checked");
    if (checkedValue) {
        $('#peringatan').modal('show');
        $('[name="kehadiran"]').val('absen');
    } else {
        $('[name="kehadiran"]').val('');
        $('.nilai').prop('disabled', false);
        $('.nilai-gr').prop('disabled', false);
    }
}

function setujuiAbsen() {
    $('.nilai').prop('checked', false);
    $('.nilai-gr').prop('checked', false);

    $('.nilai').prop('disabled', true);
    $('.nilai-gr').prop('disabled', true);
}

function batalAbsen() {
    $('input[name="setKehadiran"]').prop('checked', false);
}

function konfirmasiSimpan() {
    let checkedValue = $('input[name="setKehadiran"]').is(":checked");
    let jenisBtn = $('[name="konfirmasi"]').val();
    if (jenisBtn == "next") {
        $('#penilaianSave').submit();
    } else {
        let jlhNilai = $('.rowNilai').length;
        let jlhChecked = $('.nilai:checked').length;
        let jlhCheckedGr = $('.nilai-gr:checked').length;

        if (jlhNilai != jlhChecked && !checkedValue || jlhCheckedGr < 1 && !checkedValue) {
            $('#reminder').modal('show');
        } else {
            $('#konfirmasi').modal('show');
        }
    }

}

function setujuiSimpan() {
    $('#penilaianSave').submit();
}

function stationRest() {
    jmlStation = $('[name="jmlStation"]').val();
    if ($('[name="cekRest"]').is(':checked')) {
        if ($('[name="jmlStation"]').val()) {
            if ($('[name="jmlStation"]').val() < 1) {
                $('#stationRest').empty()
            } else {
                let html = ''
                html += '<label class="form-label">Pada Station</label>'
                html += '<div class="selectgroup selectgroup-pills">'
                for (let rest = 1; rest <= jmlStation; rest++) {
                    html += '<label class="selectgroup-item">'
                    html += '<input type="checkbox" name="stationRest[]" value="' + rest + '" class="selectgroup-input">'
                    html += '<span class="selectgroup-button">Station ' + rest + '</span>'
                    html += '</label>'
                }
                html += '</div>'
                $('#stationRest').empty()
                $('#stationRest').append(html)
            }
        } else {
            $('#stationRest').empty()
        }
    }
}
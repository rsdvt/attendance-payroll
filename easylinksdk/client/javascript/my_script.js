$(document).ready(function() {
    done();
});

function done() {
    setTimeout(function() {
        updates();
        done();
    }, 200);
}

// function updates() {
//     $.getJSON("fetch.php", function(data) {
//         $("ul").empty();
//         $.each(data.result, function() {
//             $("ul").append(this['nama']);
//         });
//     });
// }

function updateStatus() {
    $.ajax({ url: 'update_status.php' });
}

function getNewScan() {
    $.ajax({ url: 'get_new_scan.php' });
}

var nama;
var status;
var gelar_depan;
var gelar_belakang;
var hasil_nama;

function realTime() {
    $.ajax({

        url: "check_status.php",
        dataType: 'json',
        cache: 'false',
        success: function(data) {
            status = data[3];
            nama = data[2];
            gelar_depan = data[4];
            gelar_belakang = data[5];
            lokasi = data[6];
            hasil_nama = `${gelar_depan} ${nama} ${gelar_belakang}`;


            if (status == 0) {

                $('.welcome').html('SELAMAT DATANG');
                $('.nama').html(hasil_nama);
                // $('#ket_absen').html('');



            } else {
                // $('#ket_absen').html('SILAHKAN ABSEN TERLEBIH DAHULU');
                $('.welcome').html('');
                $('.nama').html('STIE Putra Perdana Indonesia');

            }
        }
    });
}

setInterval(function() {
    realTime();
    updateStatus();
}, 2000);

setInterval(function() {
    getNewScan();
}, 5000);


//effect text

// var textWrapper = document.querySelector('.ml10 .welcome');
// textWrapper.innerHTML = textWrapper.textContent.replace(/\S/g, "<span class='welcome'>$&</span>, <span class='nama'>$&</span> ");

// anime.timeline({ loop: true })
//     .add({
//         targets: '.ml10 .welcome',
//         rotateY: [-100, 0],
//         duration: 5000,
//         delay: (el, i) => 45 * i
//     }).add({
//         targets: '.ml10',
//         opacity: 0,
//         duration: 1000,
//         easing: "easeOutExpo",
//         delay: 1000
//     });

// var textWrapper = document.querySelector('.ml10 .nama');
// textWrapper.innerHTML = textWrapper.textContent.replace(/\S/g, "<span class='nama'>$&</span>");

// anime.timeline({ loop: true })
//     .add({
//         targets: '.ml10 .nama',
//         rotateX: [-90, 0],
//         duration: 5000,
//         delay: (el, i) => 45 * i
//     }).add({
//         targets: '.ml10',
//         opacity: 0,
//         duration: 1000,
//         easing: "easeOutExpo",
//         delay: 1000
//     });


//     var textWrapper = document.querySelector('.ml10 .switch');
// textWrapper.innerHTML = textWrapper.textContent.replace(/\S/g, "<span class='switch'>$&</span>");

// anime.timeline({ loop: true })
//     .add({
//         targets: '.ml10 .switch',
//         rotateX: [-90, 0],
//         duration: 5000,
//         delay: (el, i) => 45 * i
//     }).add({
//         targets: '.ml10',
//         opacity: 0,
//         duration: 1000,
//         easing: "easeOutExpo",
//         delay: 1000
//     });

// var textWrapper = document.querySelector('.ml10 .lokasi');
// textWrapper.innerHTML = textWrapper.textContent.replace(/\S/g, "<span class='lokasi'>$&</span>");

// anime.timeline({ loop: true })
//     .add({
//         targets: '.ml10 .lokasi',
//         rotateX: [-90, 0],
//         duration: 5000,
//         delay: (el, i) => 45 * i
//     }).add({
//         targets: '.ml10',
//         opacity: 0,
//         duration: 1000,
//         easing: "easeOutExpo",
//         delay: 1000
//     });
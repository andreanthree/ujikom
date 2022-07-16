<!-- General JS Scripts -->
<script src="{{ asset('theme/js/jquery-3.5.1.js') }}"></script>
<script src="{{ asset('theme/js/popper.min.js') }}"></script>
<script src="{{ asset('theme/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('theme/js/jquery.nicescroll.min.js') }}"></script>
<script src="{{ asset('theme/js/select2.full.min.js ') }}"></script>
<script>
    parseDatetimeToText = (tglku) => {
        try {

            var tgl = '' + tglku;
            var bulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
                'Oktober', 'November', 'Desember'
            ];
            var spl = tgl.split(' ');
            var tanggal = spl[0].split('-');
            return tanggal[2] + ' ' + bulan[Number(tanggal[1])] + ' ' + tanggal[0] + ' ' + spl[1];
        } catch (error) {
            return tglku;
        }
    }
    parseDateToText = (tglku) => {
        try {

            var tgl = '' + tglku;
            var bulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
                'Oktober', 'November', 'Desember'
            ];
            var tanggal = tgl.split('-');
            return tanggal[2] + ' ' + bulan[Number(tanggal[1])] + ' ' + tanggal[0];
        } catch (error) {
            return tglku;
        }
    }
    parseBobotToText = (tglku) => {
        console.log("tglku", tglku);
        try {
            var bulan = {
                20: 'Sangat Rendah',
                40: 'Rendah',
                60: 'Menengah',
                80: 'Tinggi',
                100: 'Sangat Tinggi'
            };

            return bulan[Number(tglku)];
        } catch (error) {
            return tglku;
        }
    }
</script>
<!-- Template JS File -->
<script src="{{ asset('theme/js/scripts.js') }}"></script>
<script src="{{ asset('theme/js/custom.js') }}"></script>

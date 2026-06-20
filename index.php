<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Agung SP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <style>
        /* Desain tambahan untuk struk agar terlihat realistis */
        .struk-box {
            border: 2px dashed #ccc;
            padding: 20px;
            background-color: #fafafa;
            font-family: 'Courier New', Courier, monospace;
        }
    </style>
</head>
<body>
    <section class="bg-secondary p-5 text-center text-white mb-4">
        <h1>Toko Elektronik Agung SP</h1>
    </section>
    <section class="container">
        <div class="row">
            <!-- KOLOM FORM KIRI -->
            <div class="col-md-6 mb-4">
                <div class="card p-4 shadow-sm">
                    <h4 class="mb-3 text-secondary">Form Transaksi</h4>
                    <form id="paymentForm">
                        <div class="mb-3 row">
                            <label for="nama" class="col-sm-4 col-form-label">Nama Pembeli</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="nama" placeholder="Masukkan nama">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="produk" class="col-sm-4 col-form-label">Nama Produk</label>
                            <div class="col-sm-8">
                                <select class="form-control" id="produk">
                                    <option value="" data-harga="0">-- Pilih Produk --</option>
                                    <option value="Television" data-harga="3000000">Television (Rp 3.000.000)</option>
                                    <option value="Kulkas" data-harga="2500000">Kulkas (Rp 2.500.000)</option>
                                    <option value="Mesin Cuci" data-harga="2000000">Mesin Cuci (Rp 2.000.000)</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="belanja" class="col-sm-4 col-form-label">Total Belanja</label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" id="belanja" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="potongan" class="col-sm-4 col-form-label">Potongan Harga</label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" id="potongan" value="0">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="bayar" class="col-sm-4 col-form-label">Total Bayar</label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" id="bayar" readonly>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="button" id="btnCetak" class="btn btn-primary w-100">Cetak Struk</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- KOLOM STRUK KANAN -->
            <div class="col-md-6 mb-4">
                <div id="strukOutput" class="card shadow-sm d-none">
                    <div class="card-body">
                        <div class="struk-box">
                            <div class="text-center mb-3">
                                <h5>TOKO AGUNG SP</h5>
                                <small>Jl. Raya Serang No. 1, Banten</small>
                                <hr>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6">Nama Pembeli:</div>
                                <div class="col-6 text-end" id="stNama">-</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6">Produk:</div>
                                <div class="col-6 text-end" id="stProduk">-</div>
                            </div>
                            <hr>
                            <div class="row mb-2">
                                <div class="col-6">Total Belanja:</div>
                                <div class="col-6 text-end" id="stBelanja">Rp 0</div>
                            </div>
                            <div class="row mb-2 text-danger">
                                <div class="col-6">Potongan:</div>
                                <div class="col-6 text-end" id="stPotongan">-Rp 0</div>
                            </div>
                            <hr style="border-top: 2px dashed #000;">
                            <div class="row fw-bold fs-5">
                                <div class="col-6">TOTAL BAYAR:</div>
                                <div class="col-6 text-end" id="stBayar">Rp 0</div>
                            </div>
                            <div class="text-center mt-4">
                                <small>Terima Kasih Atas Kunjungan Anda</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SCRIPT LOGIC JAVASCRIPT -->
    <script>
        const namaInput = document.getElementById('nama');
        const produkSelect = document.getElementById('produk');
        const belanjaInput = document.getElementById('belanja');
        const potonganInput = document.getElementById('potongan');
        const bayarInput = document.getElementById('bayar');
        const btnCetak = document.getElementById('btnCetak');
        const strukOutput = document.getElementById('strukOutput');

        function formatRupiah(angka) {
            return 'Rp ' + new Intl.NumberFormat('id-ID').format(angka);
        }

        function hitungTotal() {
            const pilihan = produkSelect.options[produkSelect.selectedIndex];
            const hargaProduk = parseInt(pilihan.getAttribute('data-harga')) || 0;
            const potongan = parseInt(potonganInput.value) || 0;

            const totalBayar = hargaProduk - potongan;

            belanjaInput.value = hargaProduk;
            bayarInput.value = totalBayar < 0 ? 0 : totalBayar;
        }

        produkSelect.addEventListener('change', hitungTotal);
        potonganInput.addEventListener('input', hitungTotal);

        // 2. Logika Cetak Struk ke Samping Form
        btnCetak.addEventListener('click', function() {
            if (namaInput.value.trim() === "" || produkSelect.value === "") {
                alert("Silakan isi nama pembeli dan pilih produk terlebih dahulu!");
                return;
            }

            // Ambil data nilai terupdate
            const nama = namaInput.value;
            const produk = produkSelect.value;
            const belanja = parseInt(belanjaInput.value) || 0;
            const potongan = parseInt(potonganInput.value) || 0;
            const totalBayar = parseInt(bayarInput.value) || 0;

            // Tampilkan komponen struk (menghilangkan class d-none milik Bootstrap)
            strukOutput.classList.remove('d-none');

            // Masukkan data ke element struk
            document.getElementById('stNama').innerText = nama;
            document.getElementById('stProduk').innerText = produk;
            document.getElementById('stBelanja').innerText = formatRupiah(belanja);
            document.getElementById('stPotongan').innerText = '-' + formatRupiah(potongan);
            document.getElementById('stBayar').innerText = formatRupiah(totalBayar);
        });
    </script>

<!-- SCRIPT JS BOOTSTRAP (Opsional untuk komponen interaktif) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
</script>
</body>
</html>

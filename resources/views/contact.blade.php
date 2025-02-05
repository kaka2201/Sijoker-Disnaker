@extends('layouts.appuser')

@section('title', 'Dinas Tenaga Kerja Kota Batu - Pelatihan Tenaga Kerja')

@section('content')

    <div class="container py-5">
        <h2 class="text-center font-weight-bold mb-4">Frequently Asked Questions (FAQ)</h2>

        <div class="accordion" id="faqAccordion">

            <!-- FAQ Item 1 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Apa itu pelatihan kerja ini?
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Program peningkatan keterampilan kerja oleh Dinas Tenaga Kerja untuk mempersiapkan peserta menghadapi pasar kerja.
                    </div>
                </div>
            </div>

            <!-- FAQ Item 2 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        Siapa yang bisa mendaftar?
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Warga Indonesia minimal 18 tahun, berdomisili di wilayah Dinas Tenaga Kerja Kota Batu, dan ingin meningkatkan keterampilan kerja.
                    </div>
                </div>
            </div>

            <!-- FAQ Item 3 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingThree">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        Bagaimana cara mendaftar?
                    </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Daftar online melalui website dengan mengisi formulir dan mengunggah dokumen yang diperlukan.
                    </div>
                </div>
            </div>

            <!-- FAQ Item 4 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingFour">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                        Dokumen apa saja yang dibutuhkan?
                    </button>
                </h2>
                <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Scan KTP, KK, ijazah terakhir, foto terbaru, dan AK1
                    </div>
                </div>
            </div>

            <!-- FAQ Item 6 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingSix">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                        Kapan pendaftaran dibuka?
                    </button>
                </h2>
                <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Dibuka secara berkala, cek jadwal di website atau media sosial Dinas Tenaga Kerja.
                    </div>
                </div>
            </div>

            <!-- FAQ Item 7 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingSeven">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                        Apa yang harus dilakukan jika kesulitan mendaftar?
                    </button>
                </h2>
                <div id="collapseSeven" class="accordion-collapse collapse" aria-labelledby="headingSeven" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Hubungi tim bantuan melalui contact yang tersedia atau langsung ke kantor Disnaker.
                    </div>
                </div>
            </div>

            <!-- FAQ Item 8 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingEight">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
                        Bagaimana proses seleksinya?
                    </button>
                </h2>
                <div id="collapseEight" class="accordion-collapse collapse" aria-labelledby="headingEight" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Seleksi berdasarkan kelengkapan dokumen, kesesuaian latar belakang, dan kuota.
                    </div>
                </div>
            </div>

            <!-- FAQ Item 9 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingNine">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseNine" aria-expanded="false" aria-controls="collapseNine">
                        Di mana lokasi pelatihan?
                    </button>
                </h2>
                <div id="collapseNine" class="accordion-collapse collapse" aria-labelledby="headingNine" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Pelatihan bisa online atau offline di wilayah kota batu.
                    </div>
                </div>
            </div>

            <!-- FAQ Item 10 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingTen">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTen" aria-expanded="false" aria-controls="collapseTen">
                        Apa manfaat mengikuti pelatihan?
                    </button>
                </h2>
                <div id="collapseTen" class="accordion-collapse collapse" aria-labelledby="headingTen" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Sertifikat kompetensi dari BNSP, peningkatan keterampilan, dan peluang kerja lebih baik.
                    </div>
                </div>
            </div>

            <!-- FAQ Item 11 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingEleven">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEleven" aria-expanded="false" aria-controls="collapseEleven">
                        Apakah ada jaminan pekerjaan setelah pelatihan?
                    </button>
                </h2>
                <div id="collapseEleven" class="accordion-collapse collapse" aria-labelledby="headingEleven" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Tidak ada jaminan, tetapi keterampilan yang diperoleh akan meningkatkan peluang kerja.
                    </div>
                </div>
            </div>

            <!-- FAQ Item 12 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingTwelve">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwelve" aria-expanded="false" aria-controls="collapseTwelve">
                        Bagaimana memantau status pendaftaran?
                    </button>
                </h2>
                <div id="collapseTwelve" class="accordion-collapse collapse" aria-labelledby="headingTwelve" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Login ke akun di website untuk melihat Status Pendaftaran.
                    </div>
                </div>
            </div>

            <!-- FAQ Item 13 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingThirteen">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThirteen" aria-expanded="false" aria-controls="collapseThirteen">
                        Berapa kali saya bisa mengikuti pelatihan?
                    </button>
                </h2>
                <div id="collapseThirteen" class="accordion-collapse collapse" aria-labelledby="headingThirteen" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Tidak lebih dari 2 dalam waktu yang bersamaan
                    </div>
                </div>
            </div>

            <!-- FAQ Item 14 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingFourteen">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFourteen" aria-expanded="false" aria-controls="collapseFourteen">
                        Bagaimana jika tidak lolos seleksi?
                    </button>
                </h2>
                <div id="collapseFourteen" class="accordion-collapse collapse" aria-labelledby="headingFourteen" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Bisa mendaftar di periode berikutnya atau pilih program lain.
                    </div>
                </div>
            </div>

            <!-- FAQ Item 15 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingFifteen">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFifteen" aria-expanded="false" aria-controls="collapseFifteen">
                        Siapa yang bisa dihubungi untuk pertanyaan lebih lanjut?
                    </button>
                </h2>
                <div id="collapseFifteen" class="accordion-collapse collapse" aria-labelledby="headingFifteen" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Hubungi email info@dinasnaker.go.id atau telepon 021-123456.
                    </div>
                </div>
            </div>

            <!-- FAQ Item 15 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingsixteen">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsesixteen" aria-expanded="false" aria-controls="collapsesixteen">
                        Bagaimana untuk mengurus AK1?
                    </button>
                </h2>
                <div id="collapsesixteen" class="accordion-collapse collapse" aria-labelledby="headingsixteen" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Untuk mengurus AK1 bisa mendatangi pelayanan Disnaker di Mal pelayanan publik di balai kota batu
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Contact Start -->
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <h2 class="font-weight-bold mb-4" style="font-family: 'Poppins', sans-serif;">Hubungi Kami</h2>
                <p class="text-muted mb-4">Jika Anda memiliki pertanyaan atau membutuhkan informasi lebih lanjut, jangan ragu untuk menghubungi kami:</p>
                <div class="d-flex mb-3">
                    <i class="fas fa-map-marker-alt text-primary mr-3 mt-1"></i>
                    <p class="text-muted">Jl. Panglima Sudirman No.507, Pesanggrahan, Kec. Batu, Kota Batu, Jawa Timur 65313</p>
                </div>
                <div class="d-flex mb-3">
                    <i class="fas fa-phone-alt text-primary mr-3 mt-1"></i>
                    <p class="text-muted">+62 822 2222 2222</p>
                </div>
                <div class="d-flex">
                    <i class="fas fa-envelope text-primary mr-3 mt-1"></i>
                    <p class="text-muted">info@disnakerkotabatu.go.id</p>
                </div>
            </div>
            <div class="col-lg-6">
                <form class="shadow-lg p-4 rounded">
                    <div class="form-group">
                        <input type="text" class="form-control rounded-pill" placeholder="Nama Lengkap" required>
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control rounded-pill" placeholder="Alamat Email" required>
                    </div>
                    <div class="form-group">
                        <textarea class="form-control rounded" rows="5" placeholder="Pesan" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">Kirim Pesan</button>
                </form>
            </div>
        </div>
    </div>
    <!-- Contact End -->
@endsection
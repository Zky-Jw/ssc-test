<script>
import { reactive } from 'vue';

const dataCategory = reactive({
  displayLayanan: 1,
  serviceId: 1,
  layanan: [
    {
      id: 1,
      title: 'Akademik',
      icons: 'heroicons-outline:academic-cap',
      icon: 'wxnxiano',
      colorPrimary: '#aa0000',
      colorSecondary: '#000000',
      service: [
        {
          id: 1,
          title: 'Surat Cuti',
          description: 'Cuti adalah istilah yang merujuk pada periode waktu dimana seseorang tidak hadir dari pekerjaan atau kuliah karena alasan tertentu, seperti liburan, sakit, atau urusan pribadi',
          duration: '3-5 Hari Kerja',
          requirement: [
            {
              title: 'Jika baru mau mengajukan cuti atau perpanjangan cuti, silahkan membawa Surat Perizinan Cuti, dapat diunduh di sini',
              link: 'https://akademik.ittelkom-sby.ac.id/cuti-undur-diri-pindah-prodi/'
            }
          ]
        },
        {
          id: 2,
          title: 'Undur Diri',
          description: 'Layanan undur diri yaitu layanan yang mengurus pengunduran diri mahasiswa dari kampus',
          duration: '3 Hari Kerja',
          requirement: [
            {
              title: 'Bawa Surat Keterangan bebas tanggungan keuangan, unduh di sini',
              link: 'https://keuangan.ittelkom-sby.ac.id/layanan-keuangan/permintaan-surat-keterangan-bebas-administrasi-keuangan/'
            },
            {
              title: 'Bawa Surat keterangan bebas peminjaman buku perpustakaan, unduh di sini',
              link: 'https://akademik.ittelkom-sby.ac.id/wp-content/uploads/2023/02/Pelayanan-Bebas-Pustaka.pdf'
            },
            {
              title: 'Bawa Form pengajuan pengunduran diri, unduh',
              link: 'https://akademik.ittelkom-sby.ac.id/cuti-undur-diri-pindah-prodi/'
            },
          ]
        },
        {
          id: 3,
          title: 'Surat Keterangan Aktif',
          description: 'Layanan panduan pengajuan surat yang menjelaskan bahwa mahasiswa sebagaimana termaktub pada surat tersebut berstatus aktif mengikuti perkuliahan di semester tertentu.',
          duration: '3 Hari Kerja',
          requirement: [
            {
              title: 'Sudah Isi Form Permintaan Surat Keterangan Akademik Mahasiswa',
              link: null,
            },
            {
              title: 'Pastikan tidak ada presensi matkul yang kurang. Jika merasa ada, silahkan komunikasikan terlebih dahulu dengan dosen pengampu',
              link: null,
            },
            {
              title: 'Mengisi gform permintaan Surat Keterangan Aktif di sini',
              link: 'https://akademik.ittelkom-sby.ac.id/surat-keterangan-aktif/',
            },
          ]
        },
        {
          id: 4,
          title: 'Pindah Program Studi',
          description: 'Layanan pindah program studi mahasiswa',
          duration: '3-5 Hari Kerja',
          requirement: [
            {
              title: 'Bawa Form pengajuan perpindahan program studi, dapat diunduh di sini',
              link: 'https://akademik.ittelkom-sby.ac.id/cuti-undur-diri-pindah-prodi/'
            }
          ]
        },
        {
          id: 5,
          title: 'PDDIKTI',
          description: 'Layanan insiden terkait perubahan data pada PDDIKTI yang berhubungan dengan data pergantian semester, IPK, dan Data lainnya',
          duration: '3-5 Hari Kerja',
          requirement: [
            {
              title: 'Menyiapkan data yang ingin diadukan mengenai data diri yang ada di PDDIKTI dengan iGracias',
              link: null
            }
          ]
        },
      ],
      informationTitle: 'Informasi Akademik',
      informationDescription: 'Merupakan unit yang bertugas mengelola administrasi akademik yang mencakup kegiatan layanan administrasi akademik, pusat bahasa, dan perpustakaan. Informasi lengkap mengenai Unit Akademik, silakan kunjungi:',
      igUsername: 'akademikitts',
      igUrl: 'https://www.instagram.com/akademikitts/',
      webUrl: ['https://akademik.ittelkom-sby.ac.id/'],
      informationImg: 'https://ssc.ittelkom-sby.ac.id/assets-home/imgs/banner/device-academic.png'
    },
    // {
    //   id: 2,
    //   title: 'FTIB',
    //   icons: 'carbon:code',
    //   icon: 'nobciafz',
    //   colorPrimary: '#000000',
    //   colorSecondary: '#aa0000',
    //   service: [
    //     {
    //       id: 1,
    //       title: 'Panduan Kegiatan Akademik',
    //       accordionService: [
    //         {
    //           id: 1,
    //           title: 'Panduan Pelaksanaan Kerja Praktik di Lingkungan FTIB',
    //           description: 'Panduan bagi mahasiswa dalam pelaksanaan kerja praktik di lingkungan FTIB mulai dari pengajuan hingga pelaporan',
    //           duration: null,
    //           requirement: [],
    //           linkList: [
    //             'https://ittsby.id/Panduan-Layanan-KP', 'https://ftib.ittelkom-sby.ac.id/kerja-praktek/'
    //           ]
    //         },
    //         {
    //           id: 2,
    //           title: 'Panduan Pelaksanaan Kegiatan MBKM di Lingkungan FTIB',
    //           description: 'Panduan bagi mahasiswa dalam pelaksanaan kegiatan MBKM di lingkungan FTIB mulai dari pengajuan hingga pelaporan',
    //           duration: null,
    //           requirement: [],
    //           linkList: [
    //             'https://ftib.ittelkom-sby.ac.id/mbkm-2/'
    //           ]
    //         },
    //         {
    //           id: 3,
    //           title: 'Panduan Pelaksanaan Tugas Akhir 1 (TA1)',
    //           description: 'Panduan bagi mahasiswa dalam pelaksanaan Tugas Akhir di lingkungan FTIB',
    //           duration: null,
    //           requirement: [],
    //           linkList: [
    //             'https://ftib.ittelkom-sby.ac.id/seminar-proposal/'
    //           ]
    //         },
    //         {
    //           id: 4,
    //           title: 'Panduan Pelaksanaan Tugas Akhir 2 (TA2)',
    //           description: 'Panduan bagi mahasiswa dalam pelaksanaan Tugas Akhir di lingkungan FTIB',
    //           duration: null,
    //           requirement: [],
    //           linkList: [
    //             'https://ftib.ittelkom-sby.ac.id/berkas-tugas-akhir-mahasiswa/'
    //           ]
    //         },
    //       ]
    //     },
    //     {
    //       id: 2,
    //       title: 'Surat dan Form Terkait Kegiatan Akademik',
    //       accordionService: [
    //         {
    //           id: 1,
    //           title: 'Permohonan Surat Dispensasi / Tugas Mahasiswa (tertanda tangan dekan)',
    //           description: 'Panduan bagi mahasiswa dalam pelaksanaan kerja praktik di lingkungan FTEIC mulai dari pengajuan hingga pelaporan',
    //           duration: '3-5 hari kerja',
    //           requirement: [
    //             'Bukti Kegiatan (Surat Undangan/Surat Penunjukan)'
    //           ],
    //           linkList: [
    //             'https://ittsby.id/SuratTugasDispenFTIB',
    //           ]
    //         },
    //         {
    //           id: 2,
    //           title: 'Permohonan Surat Keterangan Aktif Mahasiswa (tertanda tangan dekan)',
    //           description: 'Surat ini digunakan sebagai tanda bahwa mahasiswa tersebut aktif dalam semester berjalan dalam kegiatan tridharma pendidikan terutama dharma satu yang dapat digunakan untuk persyaratan beasiswa dan program lainnya',
    //           duration: '3-5 hari kerja',
    //           requirement: [
    //             'Telah registrasi pada semester berjalan dan tidak terdapat masalah absen pada perkuliahan di semester sebelumnya'
    //           ],
    //           linkList: [
    //             'https://ittsby.id/SuketAktifMahasiswa',
    //           ]
    //         },
    //         {
    //           id: 3,
    //           title: 'Permohonan Pengambilan Data ke Perusahaan (tertanda tangan dekan)',
    //           description: 'Surat ini digunakan sebagai pengantar bagi mahasiswa untuk dapat memohon dalam pengambilan data perusahaan untuk mendukung tugas kuliah dan atau tugas akhir',
    //           duration: '3-5 hari kerja',
    //           requirement: [
    //             'Maksimal mengajukan untuk dua perusahaan dan atau untuk maksimal dua data dalam sekali permohonan'
    //           ],
    //           linkList: [
    //             'https://ittsby.id/SuratPengambilanDataFTIB',
    //           ]
    //         },
    //         {
    //           id: 4,
    //           title: 'Permohonan Surat Pengajuan KP (tertanda tangan dekan)',
    //           description: 'Surat ini digunakan sebagai pengantar bagi mahasiswa untuk dapat memohon melaksanakan Kerja praktik di suatu lembaga atau perusahaan',
    //           duration: '3-5 hari kerja',
    //           requirement: [
    //             'Maksimal mengajukan untuk tiga perusahaan, jika melebihi 3 kali pengajuan silahkan sertakan surat penolakan dari perusahaan yang diajukan sebelumnya'
    //           ],
    //           linkList: [
    //             'https://ittsby.id/suratpengantarsurvey', 'https://ittsby.id/PermohonanKPFTIB'
    //           ]
    //         },
    //         {
    //           id: 5,
    //           title: 'Permohonan Surat Pengajuan MBKM (tertanda tangan dekan)',
    //           description: 'Surat ini digunakan sebagai pengantar bagi mahasiswa untuk dapat memohon melaksanakan program MBKM di suatu lembaga atau perusahaan',
    //           duration: '3-5 hari kerja',
    //           requirement: [
    //             'Seluruh persyaratan dapat dilihat di link akses dibawah'
    //           ],
    //           linkList: [
    //             'https://ittsby.id/PengajuanMBKMFTIB', 'https://ittsby.id/PermohonanKPFTIB'
    //           ]
    //         },

    //       ]

    //     },
    //     {
    //       id: 3,
    //       title: 'Form Terkait Kegiatan Kemahasiswaan',
    //       accordionService: [
    //         {
    //           id: 1,
    //           title: 'Form Peminjaman Ruang Laboratorium FTIB',
    //           description: 'Form ini digunakan untuk meminjam ruangan laboratorium yang dikelola oleh FTIB',
    //           duration: '3 hari kerja',
    //           requirement: [
    //             'Memberikan bukti bahwa sudah mendapatkan ijin dari Koordinator (PIC) Laboratorium dapat berupa screenshot chat atau dokumen pendukung lainnya',
    //             'Untuk lembar permohonan mahasiswa mencari tanda tangan dari Ketua KK dan dosen pembimbing, untuk tanda tangan logistik dan dekanat, mahasiswa menyerahkan ke SSC'
    //           ],
    //           linkList: [
    //             'https://ittsby.id/PeminjamanRuanganLabFTEIC',
    //           ]
    //         },
    //         {
    //           id: 2,
    //           title: 'Form Peminjaman Aset Laboratorium FTEIC',
    //           description: 'Form ini digunakan untuk meminjam alat dan aset lain pada laboratorium yang dikelola oleh FTEIC',
    //           duration: '3 hari kerja',
    //           requirement: [
    //             'Memberikan bukti bahwa aset tersebut akan digunakan untuk kegiatan ormawa dan atau penelitian tertentu dapat dibuktikan dengan perintah dari dosen pembina atau ketua penelitian yang dilampiri proposal kegaitan atau penelitian',
    //           ],
    //           linkList: [
    //             'https://ittsby.id/PinjamAsetFTEIC'
    //           ]
    //         }
    //       ]
    //     },
    //     {
    //       id: 4,
    //       title: 'Legalisir',
    //       accordionService: [
    //         {
    //           id: 1,
    //           title: 'Legalisir KHS & Transkrip',
    //           description: 'Dokumen yang di legalisir digunakan untuk mengurus administrasi beasiswa atau mendaftar pekerjaan',
    //           duration: '3-5 hari kerja',
    //           requirement: [
    //             'Mahasiswa memfoto-copy transkrip asli atau mencetak KHS (jika transkrip asli belum diterima) maksimal 10 lembar'
    //           ],
    //           linkList: []
    //         },
    //         {
    //           id: 2,
    //           title: 'Legalisir SKL & Ijazah',
    //           description: 'Dokumen yang di legalisir digunakan untuk mengurus administrasi beasiswa atau mendaftar pekerjaan',
    //           duration: '3-5 hari kerja',
    //           requirement: [
    //             'Mahasiswa memfoto-copy ijazah asli maksimal 10 lembar atau SKL (jika ijazah asli belum diterima) maksimal 5 lembar'
    //           ],
    //           linkList: []
    //         }
    //       ]
    //     },
    //   ],
    //   informationTitle: 'Informasi FTIB',
    //   informationDescription: 'Merupakan unit yang bertugas mengelola administrasi ftib yang mencakup kegiatan layanan administrasi ftib, pusat bahasa, dan perpustakaan. Informasi lengkap mengenai Unit FTIB, silakan kunjungi:',
    //   igUsername: 'ftib.ittelkomsby',
    //   igUrl: 'https://www.instagram.com/ftib.ittelkomsby/',
    //   webUrl: ['https://ftib.ittelkom-sby.ac.id/'],
    //   informationImg: 'https://ssc.ittelkom-sby.ac.id/assets-home/imgs/banner/device-ftib.png'
    // },
    // {
    //   id: 3,
    //   title: 'FTEIC',
    //   icons: 'clarity:lightning-line',
    //   icon: 'ckuogwdx',
    //   colorPrimary: '#000000',
    //   colorSecondary: '#aa0000',
    //   service: [
    //     {
    //       id: 1,
    //       title: 'Panduan Kegiatan Akademik',
    //       accordionService: [
    //         {
    //           id: 1,
    //           title: 'Panduan Pelaksanaan Kerja Praktik di Lingkungan FTEIC',
    //           description: 'Panduan bagi mahasiswa dalam pelaksanaan kerja praktik di lingkungan FTEIC mulai dari pengajuan hingga pelaporan',
    //           duration: null,
    //           requirement: [],
    //           linkList: [
    //             'https://fteic.ittelkom-sby.ac.id/bkpmm/',
    //           ]
    //         },
    //         {
    //           id: 2,
    //           title: 'Panduan Pelaksanaan Kegiatan MBKM di Lingkungan FTEIC',
    //           description: 'Panduan bagi mahasiswa dalam pelaksanaan kegiatan MBKM di lingkungan FTEIC mulai dari pengajuan hingga pelaporan',
    //           duration: null,
    //           requirement: [],
    //           linkList: [
    //             'https://fteic.ittelkom-sby.ac.id/mbkm/'
    //           ]
    //         },
    //         {
    //           id: 3,
    //           title: 'Panduan Pelaksanaan Tugas Akhir 1 (TA1)',
    //           description: 'Panduan bagi mahasiswa dalam pelaksanaan Tugas Akhir di lingkungan FTEIC',
    //           duration: null,
    //           requirement: [],
    //           linkList: [
    //             'https://fteic.ittelkom-sby.ac.id/bspm/'
    //           ]
    //         },
    //         {
    //           id: 4,
    //           title: 'Panduan Pelaksanaan Tugas Akhir 2 (TA2)',
    //           description: 'Panduan bagi mahasiswa dalam pelaksanaan Tugas Akhir 2 di lingkungan FTEIC',
    //           duration: null,
    //           requirement: [],
    //           linkList: [
    //             'https://fteic.ittelkom-sby.ac.id/btam/'
    //           ]
    //         },
    //         {
    //           id: 4,
    //           title: 'Panduan Pengajuan Proposal Himpunan di Linkungan FTEIC',
    //           description: 'Panduan bagi mahasiswa dalam mengajukan proposal dan pendanaan himpunan mahasiswa di lingkungan FTEIC',
    //           duration: null,
    //           requirement: [],
    //           linkList: [
    //             'https://ittsby.id/PanduanProposalKmhsFTEIC'
    //           ]
    //         }
    //       ]
    //     },
    //     {
    //       id: 2,
    //       title: 'Surat dan Form Terkait Kegiatan Akademik',
    //       accordionService: [
    //         {
    //           id: 1,
    //           title: 'Permohonan Surat Dispensasi / Tugas Mahasiswa (tertanda tangan dekan)',
    //           description: 'Surat ini digunakan sebagai permohonan ijin dan pengganti absen bagi mahasiswa yang tidak dapat mengikuti perkuliahan',
    //           duration: '3 hari kerja',
    //           requirement: [
    //             'Bukti Kegiatan (Surat Undangan/Surat Penunjukan)'
    //           ],
    //           linkList: [
    //             'https://ittsby.id/SuratTugasDispenFTEIC',
    //           ]
    //         },
    //         {
    //           id: 2,
    //           title: 'Permohonan Surat Keterangan Aktif Mahasiswa (tertanda tangan dekan)',
    //           description: 'Surat ini digunakan sebagai tanda bahwa mahasiswa tersebut aktif dalam semester berjalan dalam kegiatan tridharma pendidikan terutama dharma satu yang dapat digunakan untuk persyaratan beasiswa dan program lainnya',
    //           duration: '3 hari kerja',
    //           requirement: [
    //             'Telah registrasi pada semester berjalan dan tidak terdapat masalah absen pada perkuliahan di semester sebelumnya'
    //           ],
    //           linkList: [
    //             'https://ittsby.id/SuketAktifMahasiswa',
    //           ]
    //         },
    //         {
    //           id: 3,
    //           title: 'Permohonan Pengambilan Data ke Perusahaan (tertanda tangan dekan)',
    //           description: 'Surat ini digunakan sebagai pengantar bagi mahasiswa untuk dapat memohon dalam pengambilan data perusahaan untuk mendukung tugas kuliah dan atau tugas akhir',
    //           duration: '3 hari kerja',
    //           requirement: [
    //             'Maksimal mengajukan untuk dua perusahaan dan atau untuk maksimal dua data dalam sekali permohonan'
    //           ],
    //           linkList: [
    //             'https://ittsby.id/SuratPengambilanData',
    //           ]
    //         },
    //         {
    //           id: 4,
    //           title: 'Permohonan Surat Pengajuan KP (tertanda tangan dekan)',
    //           description: 'Surat ini digunakan sebagai pengantar bagi mahasiswa untuk dapat memohon melaksanakan Kerja praktik di suatu lembaga atau perusahaan',
    //           duration: '3 hari kerja',
    //           requirement: [
    //             'Maksimal mengajukan untuk dua perusahaan dan atau untuk maksimal dua data dalam sekali permohonan',
    //             'Proposal Kerja Praktik yang sudah tertanda tangan dosen pembimbing akademik dan kepala program studi',
    //             'Surat Pengajuan Kerja Praktik yang sudah terparaf dosen wali dan kepala program studi',
    //             'Lebih Detil dapat membaca panduan program KP FTEIC'
    //           ],
    //           linkList: [
    //             'https://ittsby.id/SuratPengajuanKPFTEIC'
    //           ]
    //         },
    //         {
    //           id: 5,
    //           title: 'Permohonan Surat Pengajuan MBKM (tertanda tangan dekan)',
    //           description: 'Surat ini digunakan sebagai pengantar bagi mahasiswa untuk dapat memohon melaksanakan program MBKM di suatu lembaga atau perusahaan',
    //           duration: '3 hari kerja',
    //           requirement: [
    //             'Maksimal mengajukan satu perusahaan sampai ada penolakan untuk pengajuan berikutnya',
    //             'Surat Persetujuan keikutsertaan yang telah terparaf dosen wali dan tertanda tangan ketua Koordinator MBKM',
    //             'Proposal MBKM yang sudah tertanda tangan dosen pembimbing akademik dan kepala program studi',
    //             'Surat Pengajuan MBKM yang sudah terparaf dosen wali dan kepala program studi (khusus kegiatan magang)',
    //             'Lebih Detil dapat membaca panduan program MBKM FTEIC'
    //           ],
    //           linkList: [
    //             'https://ittsby.id/SuratPengajuanMBKMFTEIC',
    //             'https://ittsby.id/TemplateProposalMBKMFTEIC',
    //             'https://ittsby.id/SuratPersetujuanKeikutsertaanMBKMFTEIC'
    //           ]
    //         },
    //         {
    //           id: 6,
    //           title: 'Form Usulan Konversi SKS FTEIC (tertanda tangan dekan)',
    //           description: 'Form ini digunakan sebagai pengantar bagi mahasiswa untuk dapat memohon konversi SKS dari mata kuliah yang sudah diambil di luar kurikulum ke dalam kurikulum yang berlaku',
    //           duration: '3 hari kerja',
    //           requirement: [
    //             'Maksimal mengajukan satu berkas konversi untuk satu program MBKM',
    //             'Surat Penerimaan Kegiatan MBKM dari Lembaga atau Perusahaan',
    //             'Form Konversi yang sudah tertanda tangan kaprodi dan dosen wali',
    //           ],
    //           linkList: [
    //             'https://ittsby.id/SuratPengajuanMBKMFTEIC'
    //           ]
    //         }
    //       ]

    //     },
    //     {
    //       id: 3,
    //       title: 'Form Terkait Kegiatan Kemahasiswaan',
    //       accordionService: [
    //         {
    //           id: 1,
    //           title: 'Form Peminjaman Ruang Laboratorium FTIB (Termasuk Residensi)',
    //           description: 'Form ini digunakan untuk meminjam ruangan laboratorium diluar jam operasional reguler (senin-jumat 08.00 - 22.00) yang dilakukan di laboratorium yang dikelola oleh Fakultas Teknologi Elektro dan Industri Cerdas',
    //           duration: '3 hari kerja',
    //           requirement: [
    //             'Memberikan bukti bahwa sudah mendapatkan ijin dari Koordinator (PIC) Laboratorium dapat berupa screenshot chat atau dokumen pendukung lainnya',
    //             'Untuk lembar permohonan mahasiswa mencari tanda tangan dari Ketua KK dan dosen pembimbing, untuk tanda tangan logistik dan dekanat, mahasiswa menyerahkan ke SSC'
    //           ],
    //           linkList: [
    //             'https://ittsby.id/PeminjamanRuanganLabFTEIC',
    //           ]
    //         },
    //         {
    //           id: 2,
    //           title: 'Form Peminjaman Aset Laboratorium FTEIC',
    //           description: 'Form ini digunakan untuk meminjam alat dan aset lain pada laboratorium yang dikelola oleh FTEIC',
    //           duration: '3 hari kerja',
    //           requirement: [
    //             'Memberikan bukti bahwa aset tersebut akan digunakan untuk kegiatan ormawa dan atau penelitian tertentu dapat dibuktikan dengan perintah dari dosen pembina atau ketua penelitian yang dilampiri proposal kegaitan atau penelitian',
    //           ],
    //           linkList: [
    //             'https://ittsby.id/PinjamAsetFTEIC'
    //           ]
    //         }
    //       ]
    //     },
    //     {
    //       id: 4,
    //       title: 'Legalisir',
    //       accordionService: [
    //         {
    //           id: 1,
    //           title: 'Legalisir KHS & Transkrip',
    //           description: 'Dokumen yang di legalisir digunakan untuk mengurus administrasi beasiswa atau mendaftar pekerjaan',
    //           duration: '3 hari kerja',
    //           requirement: [
    //             'Mahasiswa memfoto-copy transkrip asli atau mencetak KHS (jika transkrip asli belum diterima) maksimal 10 lembar'
    //           ],
    //           linkList: []
    //         },
    //         {
    //           id: 2,
    //           title: 'Legalisir SKL & Ijazah',
    //           description: 'Dokumen yang di legalisir digunakan untuk mengurus administrasi beasiswa atau mendaftar pekerjaan',
    //           duration: '3 hari kerja',
    //           requirement: [
    //             'Mahasiswa memfoto-copy ijazah asli atau SKL (jika ijazah asli belum diterima) maksimal 10 lembar'
    //           ],
    //           linkList: []
    //         }
    //       ]
    //     },
    //   ],
    //   informationTitle: 'Informasi FTEIC',
    //   informationDescription: 'Merupakan unit yang bertugas mengelola administrasi fteic yang mencakup kegiatan layanan administrasi fteic, pusat bahasa, dan perpustakaan. Informasi lengkap mengenai Unit FTEIC, silakan kunjungi:',
    //   igUsername: 'fteic.ittelkomsby',
    //   igUrl: 'https://www.instagram.com/fteic.ittelkomsby/',
    //   webUrl: ['https://fteic.ittelkom-sby.ac.id/'],
    //   informationImg: 'https://ssc.ittelkom-sby.ac.id/assets-home/imgs/banner/device-fteic.png'
    // },
    {
      id: 4,
      title: 'Pusat Bahasa & Perpustakaan',
      icons: 'carbon:book',
      icon: 'gdjyhaga',
      colorPrimary: '#000000',
      colorSecondary: '#aa0000',
      service: [
        {
          id: 1,
          title: 'Layanan Pusat Bahasa',
          accordionService: [
            {
              id: 1,
              title: 'Tes EPrT',
              description: 'Layanan tes standar internasional yang digunakan untuk mengukur kemampuan Bahasa Inggris dalam berbicara, membaca, menulis, dan mendengarkan. Tes ini juga menjadi syarat kelulusan mahasiswa',
              duration: null,
              requirement: [],
              linkList: ['https://akademik.ittelkom-sby.ac.id/layanan-tes-eprt/']
            },
            {
              id: 2,
              title: 'Kursus Bahasa Inggris',
              description: 'Layanan yang dirancang untuk membantu mahasiswa belajar bahasa Inggris dengan lebih efektif. Kursus bahasa Inggris dapat mencakup berbagai topik, seperti keterampilan percakapan, tata bahasa, membaca, menulis, dan mendengarkan.',
              duration: null,
              requirement: [],
              linkList: ['https://akademik.ittelkom-sby.ac.id/layanan-pusat-bahasa/']
            },
          ]
        },
        {
          id: 2,
          title: 'Layanan Perpustakaan',
          accordionService: [
            {
              id: 1,
              title: 'Pendaftaran Anggota',
              description: 'Panduan pendaftaran anggota baru di perpustakaan',
              duration: null,
              requirement: [],
              linkList: ['https://akademik.ittelkom-sby.ac.id/wp-content/uploads/2023/02/Pendaftaran-Anggota.pdf']
            },
            {
              id: 2,
              title: 'Kunjungan Perpustakaan',
              description: 'Panduan mengenai tata cara memasuki ruang perpustakaan',
              duration: null,
              requirement: [],
              linkList: ['https://akademik.ittelkom-sby.ac.id/wp-content/uploads/2023/02/Kunjungan-Perpustakaan.pdf']
            },
            {
              id: 3,
              title: 'Peminjaman Bahan Pustaka',
              description: 'Panduan tata cara peminjaman koleksi  bahan pustaka yang ada di perpustakaan',
              duration: null,
              requirement: [],
              linkList: ['https://akademik.ittelkom-sby.ac.id/wp-content/uploads/2023/03/Peminjaman-Bahan-Pustaka.pdf']
            },
            {
              id: 4,
              title: 'Pengembalian Bahan Pustaka',
              description: 'Panduan tata cara pengembalian bahan pustaka yang telah dipinjam di perpustakaan',
              duration: null,
              requirement: [],
              linkList: ['https://akademik.ittelkom-sby.ac.id/wp-content/uploads/2023/02/Pengembalian-Bahan-Pustaka.pdf']
            },
            {
              id: 5,
              title: 'Perpanjangan Bahan Pustaka',
              description: 'Panduan tata cara memperpanjang peminjaman koleksi  bahan pustaka yang telah memasuki batas akhir peminjaman di perpustakaan',
              duration: null,
              requirement: [],
              linkList: ['https://akademik.ittelkom-sby.ac.id/wp-content/uploads/2023/02/Perpanjangan-Bahan-Pustaka.pdf']
            },
            {
              id: 6,
              title: 'Penerimaan Koleksi KTI',
              description: 'Layanan panduan pengajuan surat berita acara serah terima  yang menjelaskan bahwa mahasiswa sebagaimana termaktub pada surat tersebut telah menyerahkan laporan TA, KP, dan MBKM dalam bentuk Hardcopy pada perpustakaan.',
              duration: null,
              requirement: [],
              linkList: ['https://akademik.ittelkom-sby.ac.id/wp-content/uploads/2023/02/Penerimaan-Koleksi-KTI.pdf']
            },
            {
              id: 7,
              title: 'Pelayanan Jurnal dan Tugas Akhir',
              description: 'Layanan panduan peminjaman jurnal dan tugas akhir yang tersedia  di perpustakaan',
              duration: null,
              requirement: [],
              linkList: ['https://akademik.ittelkom-sby.ac.id/wp-content/uploads/2023/03/Pelayanan-Jurnal-dan-Tugas-Akhir.pdf']
            },
            {
              id: 8,
              title: 'Pelayanan Bebas Pustaka',
              description: 'Layanan panduan pengajuan surat yang menjelaskan bahwa mahasiswa sebagaimana termaktub pada surat tersebut tidak memiliki tanggungan administrasi dan peminjaman di perpustakaan',
              duration: null,
              requirement: [],
              linkList: ['https://akademik.ittelkom-sby.ac.id/wp-content/uploads/2023/02/Pelayanan-Bebas-Pustaka.pdf']
            },
            {
              id: 9,
              title: 'Peminjaman Fasilitas Perpustakaan',
              description: 'Layanan prosedur peminjaman fasilitas perpustakaan',
              duration: null,
              requirement: [],
              linkList: ['https://akademik.ittelkom-sby.ac.id/wp-content/uploads/2023/02/Layanan-Peminjaman-fasilitas-Perpustakaan.pdf']
            },
            {
              id: 10,
              title: 'Informasi dan Pengambilan Barang Hilang',
              description: 'Layanan panduan informasi dan pengembalian barang hilang di perpustakaan',
              duration: null,
              requirement: [],
              linkList: ['https://akademik.ittelkom-sby.ac.id/wp-content/uploads/2023/02/Layanan-Informasi-Pengembalian-Barang-Hilang.pdf']
            },
            {
              id: 11,
              title: 'Berbagi Buku',
              description: 'Layanan panduan bagi pemustaka yang ingin memberikan koleksi buku yang dimiliki dan diserahkan ke perpustakaan agar dapat digunakan oleh pemustaka lain',
              duration: null,
              requirement: [],
              linkList: ['https://akademik.ittelkom-sby.ac.id/wp-content/uploads/2023/02/Layanan-berbagi-buku.pdf']
            },
            {
              id: 12,
              title: 'Usulan Buku Baru Perpustakaan',
              description: 'Layanan pengajuan usulan pengadaan buku baru yang anda butuhkan di perpustakaan',
              duration: null,
              requirement: [],
              linkList: ['https://akademik.ittelkom-sby.ac.id/wp-content/uploads/2023/02/Layanan-usulan-buku-baru-perpustakaan.pdf']
            },
          ]
        }
      ],
      informationTitle: 'Informasi Pusat Bahasa & Perpustakaan',
      informationDescription: 'Merupakan unit yang bertugas mengelola administrasi perpus yang mencakup kegiatan layanan administrasi perpus, pusat bahasa, dan perpustakaan. Informasi lengkap mengenai Unit Pusat Bahasa & Perpustakaan, silakan kunjungi:',
      igUsername: 'akademikitts',
      igUrl: 'https://www.instagram.com/akademikitts/',
      webUrl: ['https://akademik.ittelkom-sby.ac.id/layanan-perpustakaan/', 'https://akademik.ittelkom-sby.ac.id/layanan-pusat-bahasa/'],
      informationImg: 'https://ssc.ittelkom-sby.ac.id/assets-home/imgs/banner/device-perpus.png'
    },
    {
      id: 5,
      title: 'Keuangan',
      icons: 'solar:hand-money-linear',
      icon: 'vaeagfzc',
      colorPrimary: '#000000',
      colorSecondary: '#aa0000',
      service: [
        {
          id: 1,
          title: 'Pembayarann BPP lebih dari 1 Semester',
          description: 'Panduan pembayaran Biaya Penyelenggaraan Pendidikan setiap semester.',
          duration: '3 Hari Kerja',
          requirement: [],
        },
        {
          id: 2,
          title: 'Pengajuan Angsuran BPP',
          description: 'Pengajuan keringanan bagi mahasiswa yang belum dapat melakukan pelunasan pembayaran BPP',
          duration: '3 Hari Kerja',
          requirement: [
            {
              title: 'Bawa berkas Surat Permohonan Angsuran (bisa di download di web utama kampus atau dari dosen wali)',
              link: null,
            }
          ]
        },
        {
          id: 3,
          title: 'Permintaan Bukti Pembayaran/Kuitansi Pembayaran Biaya Pendidikan',
          description: 'Permintaan bukti pembayaran biaya pendidikan dari mahasiswa atau orang tua/wali mahasiswa',
          duration: '1 Hari Kerja',
          requirement: []
        },
        {
          id: 4,
          title: 'Permintaan Surat Tagihan/ Invoice Biaya Pendidikan',
          description: 'Permintaan surat tagihan atau invoice biaya pendidikan dari mahasiswa atau orang tua/wali mahasiswa',
          duration: '1 Hari Kerja',
          requirement: []
        },
        {
          id: 5,
          title: 'Permintaan Surat Keterangan Bebas Administrasi Keuangan',
          description: 'Permintaan surat keterangan yang menyatakan bahwa mahasiswa sudah tidak memiliki piutang biaya pendidikan. Surat tersebut digunakan untuk keperluan mengurus proses kelulusan dan proses undur diri',
          duration: '1 Hari Kerja',
          requirement: []
        },
      ],
      informationTitle: 'Informasi Keuangan',
      informationDescription: 'Merupakan unit yang bertugas mengelola administrasi keuangan yang mencakup kegiatan layanan administrasi keuangan, pusat bahasa, dan perpustakaan. Informasi lengkap mengenai Unit Keuangan, silakan kunjungi:',
      igUsername: 'keuangan.ittelkomsby',
      igUrl: 'https://www.instagram.com/keuangan.ittelkomsby/',
      webUrl: ['https://keuangan.ittelkom-sby.ac.id/'],
      informationImg: 'https://ssc.ittelkom-sby.ac.id/assets-home/imgs/banner/device-keuangan.png'
    },
    {
      id: 6,
      title: 'PuTi',
      icons: 'akar-icons:wifi',
      icon: 'qhgmphtg',
      colorPrimary: '#000000',
      colorSecondary: '#aa0000',
      service: [
        {
          id: 1,
          title: 'Peminjaman perangkat jaringan',
          description: 'Peminjaman perangkat jaringan meliputi Mifi Orbit, Kabel LAN, dan perangkat dan penunjang kebutuhan perangkat jaringan',
          duration: '1 Hari Kerja',
          requirement: [
            {
              title: 'Membawa surat peminjaman perangkat jaringan, dapat diunduh disini',
              link: 'https://ssc.ittelkom-sby.ac.id/assets-home/imgs/page/puti/surat-peminjaman-perangkat-jaringan.pdf',
            }
          ]
        },
        {
          id: 2,
          title: 'Permintaan Data',
          description: 'Permintaan data terkait unit untuk keperluan tugas kuliah',
          duration: '3-5 Hari Kerja',
          requirement: [
            {
              title: 'Mengirim data yang ingin diminta (format excel) atau list pertanyaan untuk wawancara ke email SSC',
              link: null,
            },
            {
              title: 'Sudah punya Surat Pengantar Pengambilan Data dari Fakultas',
              link: null,
            }
          ]
        },
        {
          id: 3,
          title: 'Laporan Insiden Aplikasi',
          description: 'Laporan insiden aplikasi (igracias, elearning, dll)',
          duration: '3 Hari Kerja',
          requirement: [
            {
              title: 'Menyiapkan bukti insiden',
              link: null,
            }
          ]
        },
        {
          id: 4,
          title: 'Manajemen Akun',
          description: 'Permintaan Reset Password akun (igracias, wifi, office 365, email) atau Permintaan pembuatan akun baru institusi',
          duration: '3 Hari Kerja',
          requirement: [
            {
              title: 'Pembuatan email UKM : Siapkan alamat email yang diinginkan',
              link: null
            },
            {
              title: 'Reset password igracias, wifi, office 365, email kampus : Siapkan username/email yang akan di reset password',
              link: null
            }
          ]
        },
      ],
      informationTitle: 'Informasi PuTi',
      informationDescription: 'Merupakan unit yang bertugas mengelola administrasi puti yang mencakup kegiatan layanan administrasi puti, pusat bahasa, dan perpustakaan. Informasi lengkap mengenai Unit PuTi, silakan kunjungi:',
      igUsername: 'puti.ittelkomsby',
      igUrl: 'https://www.instagram.com/puti.ittelkomsby/',
      webUrl: ['https://puti.ittelkom-sby.ac.id/'],
      informationImg: 'https://ssc.ittelkom-sby.ac.id/assets-home/imgs/banner/device-puti.png'
    },
    {
      id: 7,
      title: 'Kemahasiswaan',
      icons: 'uil:chat-bubble-user',
      icon: 'uukerzzv',
      colorPrimary: '#000000',
      colorSecondary: '#aa0000',
      service: [
        {
          id: 1,
          title: 'Pengajuan Proposal dan LPJ Kegiatan',
          description: 'Layanan terkait pelaksanaan pengusulan & pendanaan program kegiatan ormawa dan UKM',
          duration: '3-5 Hari Kerja',
          requirement: [
            {
              title: 'Membawa proposal atau LPJ yang ingin diajukan',
              link: null,
            }
          ]
        },
        {
          id: 2,
          title: 'Validasi dan Approval TAK',
          description: 'Layanan approval sertifikat TAK sebagai syarat untuk mengikuti sidang tugas akhir/skripsi/proyek akhir, mendapatkan beasiswa, dan mengikuti seleksi mahasiswa berprestasi.',
          duration: '5 Hari Kerja',
          requirement: [
            {
              title: 'Mengirimkan bukti permasalahan TAK ke email SSC dengan format pengajuan layanan online',
              link: null,
            },
            {
              title: 'Pertanyaan tentang jumlah poin TAK bisa cek disini',
              link: 'https://student.ittelkom-sby.ac.id/transkrip-aktivitas-kemahasiswaan/',
            }
          ]
        },
        {
          id: 3,
          title: 'Hilang, cetak ulang, dan ambil KTM baru',
          description: 'Layanan hilang, cetak ulang, dan ambil KTM baru',
          duration: '1-3 Hari Kerja',
          requirement: [
            {
              title: 'Jika belum dapat KTM: Silahkan tanyakan kepada dosen wali atau kaprodi terlebih dahulu. Jika tidak ada silahkan ke SSC',
              link: null,
            },
            {
              title: 'Jika hilang KTM atau ingin cetak lagi silahkan : Membawa surat kehilangan dari kepolisian dan Membawa uang denda Rp 50.000',
            }
          ]
        },
        {
          id: 4,
          title: 'Surat Rekomendasi / Delegasi Lomba',
          description: 'Layanan pengajuan surat rekomendasi atau surat pengantar lomba.',
          duration: '- Hari Kerja',
          requirement: []
        },
        {
          id: 5,
          title: 'Surat Keterangan Tidak Menerima Beasiswa Dari Kampus',
          description: 'Layanan pembuatan surat keterangan tidak menerima beasiswa dari kampus untuk keperluan tertentu.',
          duration: '- Hari Kerja',
          requirement: []
        },
        {
          id: 6,
          title: 'Asuransi dan Layanan Kesehatan Telkomedika',
          description: 'Asuransi dan Layanan Kesehatan Telkomedika',
          duration: '- Hari Kerja',
          requirement: []
        },
      ],
      informationTitle: 'Informasi Kemahasiswaan',
      informationDescription: 'Merupakan unit yang bertugas mengelola administrasi kemahasiswaan yang mencakup kegiatan layanan administrasi kemahasiswaan, pusat bahasa, dan perpustakaan. Informasi lengkap mengenai Unit Kemahasiswaan, silakan kunjungi:',
      igUsername: 'kemahasiswaanitts',
      igUrl: 'https://www.instagram.com/kemahasiswaanitts/',
      webUrl: ['https://kemahasiswaan.ittelkom-sby.ac.id/'],
      informationImg: 'https://ssc.ittelkom-sby.ac.id/assets-home/imgs/banner/device-kemahasiswaan.png'
    },
    {
      id: 8,
      title: 'Logistik',
      icons: 'uil:setting',
      icon: 'sbiheqdr',
      colorPrimary: '#000000',
      colorSecondary: '#aa0000',
      service: [
        {
          id: 1,
          title: 'Peminjaman Asset',
          description: 'Layanan peminjaman asset seperti ruangan kuliah, aula rapat, serta perlengkapan audio & video.',
          duration: '3 Hari Kerja',
          requirement: [
            {
              title: 'Pastikan Anda memahami SOP yang berlaku',
              link: null,
            },
            {
              title: 'Membawa surat F01 dan F02 yang dapat diunduh disini',
              link: 'https://drive.google.com/drive/u/1/folders/1jyZBKcwa0-jlE4m0cLy3EpnCatrpYRgw'
            }
          ]
        },
        {
          id: 2,
          title: 'Pemeliharaan Asset Rusak/Hilang',
          description: 'Layanan pemeliharaan asset mengenai kelistrikan, air, gedung, audio & video yang rusak atau hilang.',
          duration: ' - Hari Kerja',
          requirement: []
        },
      ],
      informationTitle: 'Informasi Logistik',
      informationDescription: 'Merupakan unit yang bertugas mengelola administrasi logistik yang mencakup kegiatan layanan administrasi logistik, pusat bahasa, dan perpustakaan. Informasi lengkap mengenai Unit Logistik, silakan kunjungi:',
      igUsername: 'logistik.ittelkomsby',
      igUrl: 'https://www.instagram.com/logistik.ittelkomsby/',
      webUrl: ['https://logistik.ittelkom-sby.ac.id/'],
      informationImg: 'https://ssc.ittelkom-sby.ac.id/assets-home/imgs/banner/device-academic.png'
    },
  ],
})

export { dataCategory }

export default {
  data() {
    return { dataCategory }
  }
}
</script>


<template>
  <div>

  </div>
</template>

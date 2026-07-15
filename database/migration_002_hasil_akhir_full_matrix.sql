-- Migration 002: hasil_akhir menyimpan matriks penuh (responden x alternatif)
-- Sebelumnya hasil_akhir hanya menyimpan 1 baris (layanan terbaik) per responden,
-- sehingga rata-rata kepuasan per layanan menjadi bias (hanya menghitung dari
-- responden yang kebetulan menobatkan layanan itu sebagai favorit).
--
-- Jalankan manual setelah database/db_disdukcapil_smart.sql:
--   mysql -u root db_disdukcapil_smart < database/migration_002_hasil_akhir_full_matrix.sql
--
-- Setelah migrasi ini, jalankan ulang "Hitung Ulang SMART" (menu Penilaian) agar
-- seluruh data penilaian yang sudah ada terisi penuh ke hasil_akhir (sebelumnya
-- hanya pemenang yang tersimpan).

-- Catatan: setiap ALTER TABLE di MySQL/InnoDB melakukan implicit commit sendiri
-- (DDL tidak benar-benar atomik dalam satu transaksi), jadi urutan step di bawah
-- SENGAJA menambah index/kolom baru dulu sebelum menghapus yang lama - supaya foreign
-- key hasil_akhir_ibfk_1/2 (id_responden -> responden, id_alternatif -> alternatif)
-- selalu punya index pendukung di setiap langkah dan tidak diblokir MySQL.

-- 1. Rename kolom: baris ini sekarang = skor untuk 1 alternatif, bukan cuma pemenang.
ALTER TABLE hasil_akhir
    CHANGE COLUMN id_alternatif_terbaik id_alternatif INT NOT NULL
        COMMENT 'ID layanan yang dinilai (bukan hanya layanan terbaik)';

-- 2. Flag "baris ini adalah skor tertinggi milik responden ini" agar UI yang butuh
--    "layanan favorit responden X" tidak perlu MAX(nilai_smart) berulang.
ALTER TABLE hasil_akhir
    ADD COLUMN is_terbaik TINYINT(1) NOT NULL DEFAULT 0
        COMMENT '1 = ranking #1 untuk responden ini (baris pemenang)'
    AFTER nilai_smart;

-- 3. Tambah index/unique key baru TERLEBIH DAHULU (index_alternatif & idx_responden_alternatif
--    akan menggantikan idx_alternatif_terbaik & idx_responden sebagai penopang FK).
ALTER TABLE hasil_akhir
    ADD UNIQUE KEY idx_responden_alternatif (id_responden, id_alternatif),
    ADD KEY idx_alternatif (id_alternatif),
    ADD KEY idx_responden_terbaik (id_responden, is_terbaik);

-- 4. Baru sekarang aman membuang unique key lama (1 baris per responden) dan index lama.
ALTER TABLE hasil_akhir
    DROP INDEX idx_responden,
    DROP INDEX idx_alternatif_terbaik;

-- 5. Backfill: baris seed yang sudah ada otomatis jadi pemenang untuk dirinya sendiri.
UPDATE hasil_akhir SET is_terbaik = 1;

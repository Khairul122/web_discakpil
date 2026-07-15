-- Migration 003: lengkapi kriteria supaya lebih dekat dengan 9 unsur pelayanan
-- Permenpan RB No. 14/2017 (SKM), dan rapikan label sub-kriteria C1 yang tidak
-- konsisten dengan pola "Sangat X / X / Cukup X / Tidak X" di kriteria lain.
--
-- Ditambahkan: C6 Prosedur, C7 Perilaku Pelaksana.
-- Bobot dihitung ulang supaya tetap total 100 di antara 7 kriteria.
--
-- PENTING: setelah migrasi ini, semua penilaian LAMA (responden yang sudah pernah
-- mengisi kuesioner) belum punya jawaban untuk C6 & C7 - WAJIB jalankan
-- database/backfill_kriteria_baru.php setelah migrasi ini supaya tidak ada
-- kuesioner yang "kosong/nol" untuk kriteria baru.

START TRANSACTION;

-- 1. Rebalance bobot kriteria lama (total 100 sebelumnya, sekarang dibagi ulang
--    supaya tetap total 100 setelah 2 kriteria baru ditambahkan).
UPDATE kriteria SET bobot = 20 WHERE kode_kriteria = 'C1'; -- Kecepatan Waktu (Waktu Pelayanan)
UPDATE kriteria SET bobot = 15 WHERE kode_kriteria = 'C2'; -- Kesesuaian Syarat (Persyaratan)
UPDATE kriteria SET bobot = 15 WHERE kode_kriteria = 'C3'; -- Kompetensi Petugas (Kompetensi Pelaksana)
UPDATE kriteria SET bobot = 10 WHERE kode_kriteria = 'C4'; -- Sarana Prasarana
UPDATE kriteria SET bobot = 10 WHERE kode_kriteria = 'C5'; -- Respon Pengaduan (Penanganan Pengaduan)

-- 2. Rapikan label sub-kriteria C1 supaya konsisten dengan pola kriteria lain.
UPDATE sub_kriteria sk
  JOIN kriteria k ON sk.id_kriteria = k.id_kriteria
  SET sk.nama_pilihan = 'Cukup Cepat'
  WHERE k.kode_kriteria = 'C1' AND sk.nama_pilihan = 'Cukup';
UPDATE sub_kriteria sk
  JOIN kriteria k ON sk.id_kriteria = k.id_kriteria
  SET sk.nama_pilihan = 'Tidak Cepat'
  WHERE k.kode_kriteria = 'C1' AND sk.nama_pilihan = 'Lambat';

-- 3. Tambah 2 kriteria baru (unsur Prosedur & Perilaku Pelaksana dari Permenpan RB 14/2017).
INSERT INTO kriteria (kode_kriteria, nama_kriteria, pertanyaan, bobot, jenis) VALUES
  ('C6', 'Prosedur', 'Bagaimana penilaian Anda terhadap kemudahan alur/prosedur pelayanan yang harus dilalui?', 15, 'benefit'),
  ('C7', 'Perilaku Pelaksana', 'Bagaimana keramahan dan kesopanan petugas dalam memberikan pelayanan kepada Anda?', 15, 'benefit');

-- 4. Sub-kriteria untuk 2 kriteria baru (skala 4 level konsisten dengan kriteria lain).
INSERT INTO sub_kriteria (id_kriteria, nama_pilihan, nilai_utility)
SELECT id_kriteria, 'Sangat Mudah', 100 FROM kriteria WHERE kode_kriteria = 'C6';
INSERT INTO sub_kriteria (id_kriteria, nama_pilihan, nilai_utility)
SELECT id_kriteria, 'Mudah', 75 FROM kriteria WHERE kode_kriteria = 'C6';
INSERT INTO sub_kriteria (id_kriteria, nama_pilihan, nilai_utility)
SELECT id_kriteria, 'Cukup Mudah', 50 FROM kriteria WHERE kode_kriteria = 'C6';
INSERT INTO sub_kriteria (id_kriteria, nama_pilihan, nilai_utility)
SELECT id_kriteria, 'Tidak Mudah', 25 FROM kriteria WHERE kode_kriteria = 'C6';

INSERT INTO sub_kriteria (id_kriteria, nama_pilihan, nilai_utility)
SELECT id_kriteria, 'Sangat Ramah', 100 FROM kriteria WHERE kode_kriteria = 'C7';
INSERT INTO sub_kriteria (id_kriteria, nama_pilihan, nilai_utility)
SELECT id_kriteria, 'Ramah', 75 FROM kriteria WHERE kode_kriteria = 'C7';
INSERT INTO sub_kriteria (id_kriteria, nama_pilihan, nilai_utility)
SELECT id_kriteria, 'Cukup Ramah', 50 FROM kriteria WHERE kode_kriteria = 'C7';
INSERT INTO sub_kriteria (id_kriteria, nama_pilihan, nilai_utility)
SELECT id_kriteria, 'Tidak Ramah', 25 FROM kriteria WHERE kode_kriteria = 'C7';

COMMIT;

# Studi Kasus Metode SMART (Simple Multi-Attribute Rating Technique)
### Penerapan Indeks Kepuasan Masyarakat (IKM) pada Dinas Kependudukan dan Pencatatan Sipil

---

## 📖 Pendahuluan Metode SMART
**SMART (Simple Multi-Attribute Rating Technique)** adalah metode pengambilan keputusan multi-kriteria yang dikembangkan oleh Edward pada tahun 1977. Metode ini didasarkan pada teori bahwa setiap alternatif terdiri dari beberapa kriteria yang memiliki nilai-nilai dan setiap kriteria memiliki bobot yang menggambarkan seberapa penting kriteria tersebut dibandingkan dengan kriteria lainnya.

Dalam aplikasi SI-IKM SMART, metode ini digunakan untuk mengukur kinerja pelayanan dinas berdasarkan tingkat kepuasan masyarakat terhadap sembilan (9) kriteria standar kepuasan pelayanan publik berdasarkan **Permenpan-RB Nomor 14 Tahun 2017**.

---

## 🧮 Langkah-Langkah Perhitungan SMART

### 1. Menentukan Kriteria ($C_j$) & Bobot Awal ($W_j$)
Administrator menentukan kriteria penilaian beserta bobotnya masing-masing. Bobot mencerminkan tingkat kepentingan kriteria tersebut.

### 2. Normalisasi Bobot Kriteria ($w_j$)
Rumus normalisasi bobot untuk kriteria ke-$j$:
$$w_j = \frac{W_j}{\sum_{i=1}^{m} W_i}$$
Dimana:
*   $w_j$ = Bobot kriteria hasil normalisasi
*   $W_j$ = Bobot awal kriteria ke-$j$
*   $\sum W_i$ = Total seluruh bobot kriteria

### 3. Menghitung Nilai Utility ($u_j(A_i)$)
Nilai utility adalah nilai konversi respon penilaian masyarakat ke dalam rentang nilai $[0 - 100]$ berdasarkan sub-kriteria pilihan responden.
*   Sangat Baik (Sesuai Standar Tinggi) = Nilai Utility $100$
*   Baik = Nilai Utility $75$
*   Kurang Baik = Nilai Utility $50$
*   Tidak Baik = Nilai Utility $25$

### 4. Menghitung Nilai Akhir ($V(A_i)$)
Nilai evaluasi akhir untuk alternatif $A_i$ (layanan kependudukan) dihitung dengan mengalikan nilai utility dengan bobot normalisasi, lalu menjumlahkannya untuk seluruh kriteria:
$$V(A_i) = \sum_{j=1}^{m} (w_j \times u_j(A_i))$$
Dimana:
*   $V(A_i)$ = Nilai akhir kepuasan untuk layanan (alternatif) $A_i$
*   $w_j$ = Bobot normalisasi kriteria ke-$j$
*   $u_j(A_i)$ = Nilai utility kriteria ke-$j$ untuk layanan $A_i$

---

## 📝 Simulasi Studi Kasus (Simulasi Manual 3 Kriteria)

Misalkan kita memiliki 3 kriteria ($m = 3$) dan 2 alternatif layanan ($A_1 = \text{KTP-el}$ dan $A_2 = \text{Kartu Keluarga}$):

### Langkah 1: Kriteria dan Bobot Awal
*   $C_1$ (Waktu Pelayanan): Bobot $W_1 = 80$
*   $C_2$ (Biaya/Tarif): Bobot $W_2 = 90$
*   $C_3$ (Kompetensi Petugas): Bobot $W_3 = 70$
*   **Total Bobot ($\sum W$)** = $80 + 90 + 70 = 240$

### Langkah 2: Normalisasi Bobot ($w_j$)
*   $w_1 = \frac{80}{240} \approx 0.3333$
*   $w_2 = \frac{90}{240} = 0.3750$
*   $w_3 = \frac{70}{240} \approx 0.2917$
*   *Pengecekan:* $\sum w_j = 0.3333 + 0.3750 + 0.2917 = 1.0000$ (Benar)

### Langkah 3: Penilaian Responden & Nilai Utility ($u$)
Misal, seorang responden memberikan rating sebagai berikut:
1.  **Layanan KTP-el ($A_1$)**:
    *   Waktu Pelayanan ($C_1$): Rating "Baik" $\rightarrow u_1(A_1) = 75$
    *   Biaya ($C_2$): Rating "Sangat Baik" (Gratis) $\rightarrow u_2(A_1) = 100$
    *   Petugas ($C_3$): Rating "Baik" $\rightarrow u_3(A_1) = 75$
2.  **Layanan Kartu Keluarga ($A_2$)**:
    *   Waktu Pelayanan ($C_1$): Rating "Kurang Baik" $\rightarrow u_1(A_2) = 50$
    *   Biaya ($C_2$): Rating "Sangat Baik" $\rightarrow u_2(A_2) = 100$
    *   Petugas ($C_3$): Rating "Tidak Baik" $\rightarrow u_3(A_2) = 25$

### Langkah 4: Perhitungan Nilai Akhir ($V$)
*   **Nilai SMART KTP-el ($V(A_1)$)**:
    $$V(A_1) = (0.3333 \times 75) + (0.3750 \times 100) + (0.2917 \times 75)$$
    $$V(A_1) = 24.9975 + 37.5000 + 21.8775 = 84.375$$
*   **Nilai SMART Kartu Keluarga ($V(A_2)$)**:
    $$V(A_2) = (0.3333 \times 50) + (0.3750 \times 100) + (0.2917 \times 25)$$
    $$V(A_2) = 16.6650 + 37.5000 + 7.2925 = 61.4575$$

**Kesimpulan Pengambilan Keputusan:**
Berdasarkan nilai akhir SMART, layanan **KTP-el ($84.38$)** memiliki tingkat kepuasan yang jauh lebih tinggi daripada layanan **Kartu Keluarga ($61.46$)**. Pimpinan dinas dapat melihat bahwa aspek *Waktu Pelayanan* dan *Kompetensi Petugas* pada layanan Kartu Keluarga membutuhkan evaluasi mendalam karena memiliki nilai utility rendah ($50$ dan $25$).

---

## 🗄️ Korelasi Desain Database terhadap Struktur SMART

Aplikasi memetakan rumus matematika di atas secara dinamis ke dalam struktur tabel database relasional:

1.  **Bobot Kriteria ($W_j$)** disimpan pada tabel `kriteria` kolom `bobot`.
2.  **Nilai Utility ($u_j(a_i)$)** disimpan pada tabel `sub_kriteria` kolom `nilai` yang merelasikan sub-pilihan ke kriteria utama.
3.  **Tanggapan Survei** disimpan pada tabel `penilaian` yang merelasikan `id_responden`, `id_alternatif` (layanan yang dinilai), `id_kriteria`, dan `id_sub` (pilihan jawaban responden).
4.  **Hasil Akhir Perhitungan ($V(A_i)$)** secara berkala disimpan pada tabel `hasil_akhir` kolom `nilai_smart` guna mempercepat pemuatan grafik statistik dan cetak laporan pimpinan.

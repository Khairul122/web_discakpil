<?php
// Satu-satunya jalur perhitungan metode SMART yang dipakai di seluruh aplikasi.
// nilai_utility selalu diperlakukan sebagai skor kepuasan langsung (0-100, 100=terbaik),
// terlepas dari jenis kriteria (benefit/cost) - lihat catatan di views/sub-kriteria/form.php.
class SmartCalculator
{
    // $kriterias: array of ['id_kriteria' => ..., 'bobot' => ...]
    // Returns ['id_kriteria' => normalized_weight]
    public static function normalizeWeights(array $kriterias): array
    {
        $total_bobot = array_sum(array_column($kriterias, 'bobot'));
        $weights = [];
        foreach ($kriterias as $k) {
            $weights[$k['id_kriteria']] = $total_bobot > 0 ? $k['bobot'] / $total_bobot : 0;
        }
        return $weights;
    }

    // $penilaian_list: rows with at least id_kriteria and nilai_utility
    // $normalized_weights: id_kriteria => Wi
    public static function calculateForAlternatif(array $penilaian_list, array $normalized_weights): array
    {
        $nilai_smart = 0.0;
        $covered_weight = 0.0;

        foreach ($penilaian_list as $p) {
            $bobot_normal = $normalized_weights[$p['id_kriteria']] ?? 0;
            $nilai_utility = (float) $p['nilai_utility'];

            $nilai_smart += $bobot_normal * $nilai_utility;
            $covered_weight += $bobot_normal;
        }

        return [
            'nilai_smart' => $nilai_smart,
            'covered_weight' => $covered_weight,
            'incomplete' => $covered_weight < 0.999,
        ];
    }

    // Group flat penilaian rows (id_alternatif, id_kriteria, nilai_utility, ...) by id_alternatif
    // and compute the SMART score for each, ranked descending.
    public static function calculateAllAlternatif(array $penilaian_rows, array $normalized_weights): array
    {
        $by_alternatif = [];
        foreach ($penilaian_rows as $p) {
            $by_alternatif[$p['id_alternatif']][] = $p;
        }

        $hasil = [];
        foreach ($by_alternatif as $id_alternatif => $rows) {
            $calc = self::calculateForAlternatif($rows, $normalized_weights);
            $hasil[] = [
                'id_alternatif' => $id_alternatif,
                'nilai_smart' => $calc['nilai_smart'],
                'covered_weight' => $calc['covered_weight'],
                'incomplete' => $calc['incomplete'],
                'detail_kriteria' => $rows,
            ];
        }

        usort($hasil, function ($a, $b) {
            return $b['nilai_smart'] <=> $a['nilai_smart'];
        });

        foreach ($hasil as $i => &$h) {
            $h['ranking'] = $i + 1;
        }
        unset($h);

        return $hasil;
    }
}
?>

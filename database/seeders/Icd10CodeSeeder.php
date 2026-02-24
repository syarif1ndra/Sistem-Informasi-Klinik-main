<?php

namespace Database\Seeders;

use App\Models\Icd10Code;
use Illuminate\Database\Seeder;

class Icd10CodeSeeder extends Seeder
{
    public function run(): void
    {
        $codes = [
            ['code' => 'O00', 'name' => 'Kehamilan ektopik'],
            ['code' => 'O01', 'name' => 'Mola hidatidosa'],
            ['code' => 'O02', 'name' => 'Hasil konsepsi abnormal lainnya'],
            ['code' => 'O03', 'name' => 'Abortus spontan'],
            ['code' => 'O04', 'name' => 'Abortus dengan komplikasi infeksi genitalia'],
            ['code' => 'O05', 'name' => 'Abortus medis lainnya'],
            ['code' => 'O06', 'name' => 'Abortus tidak spesifik'],
            ['code' => 'O07', 'name' => 'Kegagalan abandoned termination of pregnancy'],
            ['code' => 'O08', 'name' => 'Komplikasi mengikuti abortus dan kehamilan ektopik'],
            ['code' => 'O09', 'name' => 'Durasi kehamilan'],
            ['code' => 'O10', 'name' => 'Hipertensi pre-existing mempersulit kehamilan'],
            ['code' => 'O11', 'name' => 'Gangguan hipertensi pre-existing dengan proteinuria superimposed'],
            ['code' => 'O12', 'name' => 'Oedema gestasional dan proteinuria tanpa hipertensi'],
            ['code' => 'O13', 'name' => 'Hipertensi gestasional tanpa proteinuria signifikan'],
            ['code' => 'O14', 'name' => 'Pre-eklampsia'],
            ['code' => 'O15', 'name' => 'Eklampsia'],
            ['code' => 'O16', 'name' => 'Hipertensi maternal tidak spesifik'],
            ['code' => 'O20', 'name' => 'Perdarahan pada kehamilan awal'],
            ['code' => 'O21', 'name' => 'Mual dan muntah berlebihan pada kehamilan'],
            ['code' => 'O22', 'name' => 'Komplikasi vena pada kehamilan'],
            ['code' => 'O23', 'name' => 'Infeksi saluran kemih pada kehamilan'],
            ['code' => 'O24', 'name' => 'Diabetes mellitus pada kehamilan'],
            ['code' => 'O25', 'name' => 'Malnutrisi pada kehamilan'],
            ['code' => 'O26', 'name' => 'Perawatan ibu untuk kondisi terkait kehamilan lainnya'],
            ['code' => 'O27', 'name' => 'Komplikasi cairan amnion dan membran'],
            ['code' => 'O28', 'name' => 'Penemuan abnormal pada pemeriksaan antenatal ibu'],
            ['code' => 'O29', 'name' => 'Komplikasi anestesi selama kehamilan'],
            ['code' => 'O30', 'name' => 'Kehamilan multipel'],
            ['code' => 'O31', 'name' => 'Komplikasi spesifik pada kehamilan multipel'],
            ['code' => 'O32', 'name' => 'Perawatan ibu untuk presentasi janin abnormal'],
            ['code' => 'O33', 'name' => 'Perawatan ibu untuk disproporsionalitas'],
            ['code' => 'O34', 'name' => 'Perawatan ibu untuk abnormalitas organ pelvis'],
            ['code' => 'O35', 'name' => 'Perawatan ibu untuk kelainan janin dan ketidaknormalan yang dikenal'],
            ['code' => 'O36', 'name' => 'Perawatan ibu untuk masalah janin lainnya yang dikenal'],
            ['code' => 'O40', 'name' => 'Polihidramnios'],
            ['code' => 'O41', 'name' => 'Gangguan cairan amnion dan membran lainnya'],
            ['code' => 'O42', 'name' => 'Ketuban pecah dini (KPD)'],
            ['code' => 'O43', 'name' => 'Gangguan plasenta'],
            ['code' => 'O44', 'name' => 'Plasenta previa'],
            ['code' => 'O45', 'name' => 'Solusio plasenta'],
            ['code' => 'O46', 'name' => 'Perdarahan antepartum'],
            ['code' => 'O47', 'name' => 'His palsu'],
            ['code' => 'O48', 'name' => 'Kehamilan lewat waktu (post-term)'],
            ['code' => 'O60', 'name' => 'Persalinan preterm'],
            ['code' => 'O61', 'name' => 'Kegagalan induksi persalinan'],
            ['code' => 'O62', 'name' => 'Abnormalitas kekuatan persalinan'],
            ['code' => 'O63', 'name' => 'Persalinan lama'],
            ['code' => 'O64', 'name' => 'Obstruksi persalinan akibat malposisi janin'],
            ['code' => 'O65', 'name' => 'Obstruksi persalinan akibat kelainan panggul ibu'],
            ['code' => 'O66', 'name' => 'Obstruksi persalinan lainnya'],
            ['code' => 'O67', 'name' => 'Perdarahan intrapartum'],
            ['code' => 'O68', 'name' => 'Persalinan dan kelahiran dipersulit oleh stres janin'],
            ['code' => 'O69', 'name' => 'Persalinan dan kelahiran dipersulit oleh komplikasi tali pusat'],
            ['code' => 'O70', 'name' => 'Laserasi perineum selama kelahiran'],
            ['code' => 'O71', 'name' => 'Trauma obstetri lainnya'],
            ['code' => 'O72', 'name' => 'Perdarahan postpartum'],
            ['code' => 'O73', 'name' => 'Retensi plasenta dan membran tanpa perdarahan'],
            ['code' => 'O74', 'name' => 'Komplikasi anestesia selama persalinan dan melahirkan'],
            ['code' => 'O75', 'name' => 'Komplikasi lain pada persalinan dan kelahiran'],
            ['code' => 'O80', 'name' => 'Persalinan normal tunggal'],
            ['code' => 'O82', 'name' => 'Persalinan tunggal melalui seksio sesarea'],
            ['code' => 'O83', 'name' => 'Persalinan tunggal lainnya dengan bantuan'],
            ['code' => 'O84', 'name' => 'Persalinan multipel'],
            ['code' => 'O85', 'name' => 'Sepsis puerperalis'],
            ['code' => 'O86', 'name' => 'Infeksi puerperalis lainnya'],
            ['code' => 'O87', 'name' => 'Komplikasi vena pada nifas'],
            ['code' => 'O88', 'name' => 'Emboli obstetrik'],
            ['code' => 'O89', 'name' => 'Komplikasi anestesia pada nifas'],
            ['code' => 'O90', 'name' => 'Komplikasi nifas'],
            ['code' => 'O91', 'name' => 'Infeksi payudara pada laktasi'],
            ['code' => 'O92', 'name' => 'Gangguan payudara dan laktasi lainnya'],
            ['code' => 'O94', 'name' => 'Sekuela komplikasi kehamilan, persalinan, dan puerperium'],
            ['code' => 'O95', 'name' => 'Kematian obstetrik penyebab tidak spesifik'],
            ['code' => 'O96', 'name' => 'Kematian dari penyebab obstetrik langsung setelah 42 hari'],
            ['code' => 'O98', 'name' => 'Penyakit infeksi &parasit ibu yang mempersulit kehamilan'],
            ['code' => 'O99', 'name' => 'Penyakit ibu lainnya mempersulit kehamilan'],
        ];

        foreach ($codes as $code) {
            Icd10Code::firstOrCreate(['code' => $code['code']], ['name' => $code['name']]);
        }
    }
}

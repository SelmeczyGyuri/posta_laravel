<?php

namespace Database\Seeders;

use App\Models\County;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountySeeder extends Seeder
{
    const COUNTIES = [
        'Budapest',
        'Bács-Kiskun',
        'Baranya',
        'Békés',
        'Borsod-Abaúj-Zemplén',
        'Csongrád-Csanád',
        'Fejér',
        'Győr-Moson-Sopron',
        'Hajdú-Bihar',
        'Heves',
        'Jász-Nagykun-Szolnok',
        'Komárom-Esztergom',
        'Nógrád',
        'Pest',
        'Somogy',
        'Szabolcs-Szatmár-Bereg',
        'Tolna',
        'Vas',
        'Veszprém',
        'Zala',
    ];

    const URLS = [
        'https://www.nemzetijelkepek.hu/sites/default/files/styles/large/public/2022-06/budapest.jpg?itok=G-MfTwh_',
        'https://www.nemzetijelkepek.hu/sites/default/files/styles/large/public/2022-06/bacs.jpg?itok=bHZXS6W4',
        'https://www.nemzetijelkepek.hu/sites/default/files/styles/large/public/2022-06/baranya_0.jpg?itok=dG2F0YHM',
        'https://www.nemzetijelkepek.hu/sites/default/files/styles/large/public/2022-06/bekes.jpg?itok=0JJ33fox',
        'https://www.nemzetijelkepek.hu/sites/default/files/styles/large/public/2022-06/borsod.jpg?itok=rbD6oPHM',
        'https://www.nemzetijelkepek.hu/sites/default/files/styles/large/public/2022-06/csongrad.jpg?itok=iY3QzNfV',
        'https://www.nemzetijelkepek.hu/sites/default/files/styles/large/public/2022-06/fejer.jpg?itok=VdgTSXWw',
        'https://www.nemzetijelkepek.hu/sites/default/files/styles/large/public/2022-06/gyor.jpg?itok=XGP7PMvS',
        'https://www.nemzetijelkepek.hu/sites/default/files/styles/large/public/2022-06/hajdu.jpg?itok=CslS6AgD',
        'https://www.nemzetijelkepek.hu/sites/default/files/styles/large/public/2022-06/heves.jpg?itok=1yRMjzj6',
        'https://www.nemzetijelkepek.hu/sites/default/files/styles/large/public/2022-06/jasz.jpg?itok=zYu4oRDX',
        'https://www.nemzetijelkepek.hu/sites/default/files/styles/large/public/2022-06/komarom.jpg?itok=uVP5Jg5q',
        'https://www.nemzetijelkepek.hu/sites/default/files/styles/large/public/2022-06/nograd.jpg?itok=1o0wWInY',
        'https://www.nemzetijelkepek.hu/sites/default/files/styles/large/public/2022-06/pest.jpg?itok=MFOFNV_p',
        'https://www.nemzetijelkepek.hu/sites/default/files/styles/large/public/2022-06/somogy.jpg?itok=hONsG5PE',
        'https://www.nemzetijelkepek.hu/sites/default/files/styles/large/public/2022-06/szabolcs.jpg?itok=IVYwCyOA',
        'https://www.nemzetijelkepek.hu/sites/default/files/styles/large/public/2022-06/tolna.jpg?itok=eEGmwtXt',
        'https://www.nemzetijelkepek.hu/sites/default/files/styles/large/public/2022-06/vas.jpg?itok=lzcTUFvB',
        'https://www.nemzetijelkepek.hu/sites/default/files/styles/large/public/2022-06/veszprem.jpg?itok=oYNCJ8VJ',
        'https://www.nemzetijelkepek.hu/sites/default/files/styles/large/public/2022-06/zala.jpg?itok=hsjVLoIM',
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear out the old, faulty rows (Aba, duplicate Szepes, missing 1/2/3, etc.)
        County::truncate();

        foreach (self::COUNTIES as $index => $name) {
            County::create([
                'id' => $index + 1,
                'name' => $name,
                'crest_url' => self::URLS[$index],
            ]);
        }
    }
}

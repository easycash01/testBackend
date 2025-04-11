<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Faker\Factory as Faker;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('it_IT');
        
        // Ottieni gli ID degli utenti dipendenti
        $dipendentiIds = User::whereHas('role', function($query) {
            $query->where('name', 'dipendente');
        })->pluck('id')->toArray();
        
        // Titoli comuni per problemi IT
        $titoli = [
            'Problema con la stampante',
            'Computer lento',
            'Errore di rete',
            'Software non funzionante',
            'Problema di accesso email',
            'Schermo bloccato',
            'Tastiera non funzionante',
            'Mouse non risponde',
            'Aggiornamento software necessario',
            'Problema con Microsoft Office',
            'File corrotto',
            'Problema di connessione VPN',
            'Account bloccato',
            'Password dimenticata',
            'Virus rilevato'
        ];
        
        $descrizioni = [
            'Il computer si avvia molto lentamente e spesso si blocca durante l\'utilizzo di applicazioni.',
            'Non riesco ad accedere alla mia email aziendale. Appare un messaggio di errore di autenticazione.',
            'La stampante non stampa i documenti. Ho controllato che sia accesa e connessa alla rete.',
            'Il software gestionale si chiude improvvisamente quando tento di generare un report.',
            'Non riesco a connettermi alla rete aziendale. Altri dispositivi sembrano funzionare correttamente.',
            'Ho bisogno di installare un nuovo software per un progetto urgente.',
            'Lo schermo del mio computer lampeggia continuamente e rende difficile lavorare.',
            'La tastiera non risponde correttamente, alcuni tasti non funzionano.',
            'Il mouse si muove in modo irregolare e il clic non sempre funziona.',
            'Ho bisogno di recuperare un file che ho cancellato accidentalmente.',
            'Microsoft Excel si blocca quando apro file di grandi dimensioni.',
            'Non riesco ad accedere al server di file condivisi.',
            'Ho dimenticato la password del mio account aziendale.',
            'Il sistema operativo mostra un messaggio di errore all\'avvio.',
            'Ho bisogno di trasferire i miei dati su un nuovo dispositivo.'
        ];
        
        // 30 ticket
        for ($i = 1; $i <= 30; $i++) {
            $stato = $faker->randomElement(['Aperto', 'Working', 'Chiuso']);
            $createdAt = $faker->dateTimeBetween('-3 months', 'now');
            
            DB::table('tickets')->insert([
                'titolo' => $faker->randomElement($titoli),
                'descrizione' => $faker->randomElement($descrizioni),
                'requester_id' => $faker->randomElement($dipendentiIds),
                'stato' => $stato,
                'created_at' => $createdAt,
                'updated_at' => $faker->dateTimeBetween($createdAt, 'now'),
            ]);
        }
    }
}
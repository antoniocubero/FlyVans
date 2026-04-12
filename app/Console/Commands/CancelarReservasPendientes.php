<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reserva;

class CancelarReservasPendientes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cancelar-reservas-pendientes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cancelar las reservas pendientes que empiezan hoy';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Reserva::where('estado', 'pendiente')
            ->whereDate('fecha_inicio', '<',now()->toDateString())
            ->update([
                'estado' => 'cancelada'
            ]);

        return 0;
    }
}

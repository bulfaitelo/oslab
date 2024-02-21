<?php

namespace App\Http\Controllers;

use App\Http\OsLabClass\Backup\GetBackupDataInfo;
use App\Models\Configuracao\Sistema\Emitente;
use App\Models\Os\Os;
use Artisan;
use Illuminate\Http\Request;
use Spatie\Backup\Tasks\Monitor\BackupDestinationStatusFactory;
use Spatie\Backup\BackupDestination\BackupDestinationFactory;



class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $emitente = new \App\Models\Configuracao\Sistema\Emitente();
        // dd($emitente->getHtmlEmitente(1));


            $path = storage_path('app/OsLab/OsLab_2023-02-19-14-36-53.zip');
            return response()->download($path);
            // dd($path);



        // $backupStatus = BackupDestinationStatusFactory::createForMonitorConfig(config('backup.monitor_backups'));
        // dd($backupStatus->wasSuccessful());

        // $backupDestinations = BackupDestinationFactory::createFromArray(config('backup.backup'));
        // dd($backupDestinations);
        // // dd(config('backup.backup'));



        $emitente = Emitente::getHtmlEmitente(1);
        return view("teste", compact("emitente"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

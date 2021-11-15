<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $schedules = Schedule::where('doctor_id', Auth::id())->paginate(5);

        return view('schedules.index', [
            'schedules' => $schedules
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $patients = Patient::where('doctor_id', Auth::id())->get();

        return view('schedules.create', [
            'patients' => $patients
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'patient' => ['required'],
            'datetime' => ['required'],
        ]);

        $schedule = Schedule::create([
            'doctor_id' => Auth::id(),
            'patient_id' => $request->patient,
            'schedule_datetime' => $request->datetime,
        ]);

        if (! $schedule) {
            $request->session()->flash('alert-danger', 'Erro ao cadastrar novo agendamento');
            return back()->withInput();
        }

        $request->session()->flash('alert-success', 'Agendamento cadastrado com sucesso!');
        return redirect()->route('schedules.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $schedule = Schedule::find($id);

        if (! $schedule || $schedule->doctor_id !== Auth::id()) {
            Session::flash('alert-warning', 'Agendamento não encontrado');
            return back();
        }

        return view('schedules.show', [
            'schedule' => $schedule
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $schedule = Schedule::find($id);
        $patients = Patient::where('doctor_id', Auth::id())->get();

        if (! $schedule || $schedule->doctor_id !== Auth::id()) {
            Session::flash('alert-warning', 'Agendamento não encontrado');
            return back();
        }

        $scheduleDatetime = new \DateTime($schedule->schedule_datetime);

        return view('schedules.edit', [
            'schedule' => $schedule,
            'patients' => $patients,
            'scheduleDatetime' => $scheduleDatetime->format('Y-m-d\TH:i:s'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'patient' => ['required'],
            'datetime' => ['required'],
        ]);

        $schedule = Schedule::find($id);

        if (! $schedule || $schedule->doctor_id !== Auth::id()) {
            Session::flash('alert-warning', 'Agendamento não encontrado');
            return back();
        }

        $schedule->patient_id = $request->patient;
        $schedule->schedule_datetime = $request->datetime;


        if (! $schedule->save()) {
            $request->session()->flash('alert-danger', 'Erro ao atualizar agendamento');
            return back()->withInput();
        }

        $request->session()->flash('alert-success', 'Agendamento atualizado com sucesso!');
        return redirect()->route('schedules.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $schedule = Schedule::find($id);
        
        if (! $schedule || $schedule->doctor_id !== Auth::id()) {
            Session::flash('alert-warning', 'Agendamento não encontrado');
        }

        if (!$schedule->delete()) {
            Session::flash('alert-warning', 'Não foi possível excluir o agendamento');
        }

        Session::flash('alert-success', 'Agendamento excluído com sucesso');

        return back();
    }
}

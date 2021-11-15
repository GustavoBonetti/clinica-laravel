<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $patients = Patient::where('doctor_id', Auth::id())->paginate(5);

        return view('patients.index', [
            'patients' => $patients
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('patients.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:15'],
        ];

        if ($request->email) {
            $validate['email'] = ['string', 'email', 'max:255'];
        }

        $request->validate($validate);

        $patient = Patient::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email ?? null,
            'doctor_id' => Auth::id(),
        ]);

        if (! $patient) {
            $request->session()->flash('alert-danger', 'Erro ao cadastrar novo paciente');
            return back()->withInput();
        }

        $request->session()->flash('alert-success', 'Paciente cadastrado com sucesso!');
        return redirect()->route('patients.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $patient = Patient::find($id);

        if (! $patient || $patient->doctor_id !== Auth::id()) {
            Session::flash('alert-warning', 'Paciente não encontrado');
            return back();
        }

        return view('patients.show', [
            'patient' => $patient
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
        $patient = Patient::find($id);

        if (! $patient || $patient->doctor_id !== Auth::id()) {
            Session::flash('alert-warning', 'Paciente não encontrado');
            return back();
        }

        return view('patients.edit', [
            'patient' => $patient
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
        $validate = [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:15'],
        ];

        if ($request->email) {
            $validate['email'] = ['string', 'email', 'max:255'];
        }

        $request->validate($validate);

        $patient = Patient::find($id);

        if (! $patient || $patient->doctor_id !== Auth::id()) {
            Session::flash('alert-warning', 'Paciente não encontrado');
            return back();
        }

        $patient->name = $request->name;
        $patient->phone = $request->phone;
        $patient->email = $request->email;


        if (! $patient->save()) {
            $request->session()->flash('alert-danger', 'Erro ao atualizar paciente');
            return back()->withInput();
        }

        $request->session()->flash('alert-success', 'Paciente atualizado com sucesso!');
        return redirect()->route('patients.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $patient = Patient::find($id);

        if (! $patient || $patient->doctor_id !== Auth::id()) {
            Session::flash('alert-warning', 'Paciente não encontrado');
        }

        if (!$patient->delete()) {
            Session::flash('alert-warning', 'Não foi possível excluir o paciente');
        }

        Session::flash('alert-success', 'Paciente excluído com sucesso');

        return back();
    }
}

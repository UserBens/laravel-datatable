<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
// use DataTables;
// use Yajra\DataTables\Facades\DataTables as FacadesDataTables;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $students = Student::get();

        if ($request->ajax()) {
            $allData = DataTables::of($students)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' .
                        $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editStudent">Edit</a>';

                    $btn .= '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' .
                        $row->id . '" data-original-title="Delete" class="edit btn btn-danger btn-sm deleteStudent">Delete</a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);

            return $allData;
        }

        return view('students', compact('students'));
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
        Student::updateOrCreate(
            ['id' => $request->student_id],
            [
                'name' => $request->name,
                'email' => $request->email
            ]
        );

        return response()->json(['success'=>'Student Added Successfully']);
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
        $students = Student::find($id);
        return response()->json($students);
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
        Student::find($id)->delete();
        return response()->json(['success'=>'Student Delete Successfully']);

    }
}

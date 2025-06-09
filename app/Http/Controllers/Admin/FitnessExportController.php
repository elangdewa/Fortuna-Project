<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Exports\MembershipExport;
use App\Exports\FitnessClassWithMembersExport;
use App\Exports\SingleClassExport;
use App\Models\ClassSchedule;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class FitnessExportController extends Controller
{
    public function exportMemberships()
    {
        return Excel::download(new MembershipExport, 'memberships.xlsx');
    }

    public function exportAllClassesWithMembers()
    {
        return Excel::download(new FitnessClassWithMembersExport, 'kelas_dan_member.xlsx');
    }

    public function exportSingleClass(Request $request)
    {
        $classId = $request->get('class_id');
        return Excel::download(new SingleClassExport($classId), 'kelas_' . $classId . '_member.xlsx');
    }

    public function showExportPage()
    {
        $allClasses = ClassSchedule::with('fitnessClass')->get();
        return view('admin.exports.index', compact('allClasses'));
    }

    public function showFitnessExportPage()
{
    $allClasses = ClassSchedule::with('fitnessClass')->get();
    return view('admin.fitness.fitness', compact('allClasses'));
}
}

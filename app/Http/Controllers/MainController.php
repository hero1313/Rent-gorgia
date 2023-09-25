<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\Material;
use App\Models\Section;
use App\Models\Type;


class MainController extends Controller
{

    public function index()
    {
        return view('main.components.landing');
    }
    public function branchIndex()
    {
        $branches = Branch::all();
        return view('main.components.branches', compact(['branches']));
    }
    public function branchStore(Request $request)
    {
        $branch = new Branch;
        $branch->id = Branch::max('id') +1;
        $branch->name = $request->name;
        $branch->save();
        return redirect()->back();
    }
    public function branchDelete($id)
    {
        $branch = Branch::find($id);
        $branch->delete();
        return redirect()->back();
    }

    public function typeIndex()
    {
        $types = Type::all();
        return view('main.components.types', compact(['types']));
    }
    public function typeStore(Request $request)
    {
        $type = new Type;
        $type->id = Type::max('id') +1;
        $type->name = $request->name;
        $type->save();
        return redirect()->back();
    }
    public function typeDelete($id)
    {
        $type = Type::find($id);
        $type->delete();
        return redirect()->back();
    }

    public function materialIndex()
    {
        $materials = Material::all();
        return view('main.components.materials', compact(['materials']));
    }
    public function materialStore(Request $request)
    {
        $material = new Material;
        $material->id = Material::max('id') +1;
        $material->name = $request->name;
        $material->save();
        return redirect()->back();
    }
    public function materialDelete($id)
    {
        $material = Material::find($id);
        $material->delete();
        return redirect()->back();
    }


    public function sectionIndex()
    {
        $sections = Section::all();
        return view('main.components.sections', compact(['sections']));
    }
    public function sectionStore(Request $request)
    {
        $section = new Section;
        $section->id = Section::max('id') +1;
        $section->name = $request->name;
        $section->save();
        return redirect()->back();
    }
    public function sectionDelete($id)
    {
        $section = Section::find($id);
        $section->delete();
        return redirect()->back();
    }

}

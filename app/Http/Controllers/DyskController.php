<?php

namespace App\Http\Controllers;

use App\Models\Informujace;
use App\Models\Inne;
use App\Models\Nakazu;
use App\Models\Ostrzegawcze;
use App\Models\User;
use App\Models\Zakazu;
use Illuminate\Http\Request;
use ZipArchive;
use File;

class DyskController extends Controller
{
    public function download(Request $request){
        $path = public_path($request->filename);
        return response()->download($path);
    }
    public function downloadAllImages(Request $request){
        $folderPath = public_path('img/'.$request->path);
        $files = File::allFiles($folderPath);

        $zipFileName = $request->path.'.zip';
        $zipFilePath = public_path('img/'.$request->path.'/'.$zipFileName);
        $zip = new ZipArchive;
        $zip->open($zipFilePath, ZipArchive::CREATE);
        foreach ($files as $file) {
            $relativePath = basename($file);
            $zip->addFile($file, $relativePath);
        }
        $zip->close();
        return response()->download($zipFilePath)->deleteFileAfterSend(true);
    }
    public function upload(Request $request){
        if ($request->hasFile('files')) {
            $files = $request->file('files');

            foreach ($files as $file) {
                // Przechowywanie każdego pliku na serwerze
                if($request->typ==1)
                    $dir="img/ostrzegawcze";
                else if($request->typ==2)
                    $dir="img/zakazu";
                else if($request->typ==3)
                    $dir="img/nakazu";
                else if($request->typ==4)
                    $dir="img/informujace";
                else if($request->typ==5)
                    $dir="img/inne";
                $path = $file->store($dir, ['disk' => 'public2']);
                $user_id=User::where('login',session()->get('login'))->first()->id;
                $rekord = [
                    'user_id' => $user_id,
                    'file' => $path,
                ];
                if($request->typ==1)
                    Ostrzegawcze::create($rekord);
                else if($request->typ==2)
                    zakazu::create($rekord);
                else if($request->typ==3)
                    nakazu::create($rekord);
                else if($request->typ==4)
                    Informujace::create($rekord);
                else if($request->typ==5)
                    Inne::create($rekord);
            }
            return redirect()->back()->with('fl', 1);
        }
    }
    public function ostrzegawcze(Request $request){
        $znaki=Ostrzegawcze::select('ostrzegawczes.*', 'users.*')
            ->join('users', 'ostrzegawczes.user_id', '=', 'users.id')
            ->orderBy('ostrzegawczes.id', "desc")
            ->get();
        return view('dysk', ['znaki' => $znaki])->with('typ', 'ostrzegawcze')->with('sort', $request->sort);
    }
    public function nakazu(Request $request){
        $znaki=Nakazu::select('nakazus.*', 'users.*')
            ->join('users', 'nakazus.user_id', '=', 'users.id')
            ->orderBy('nakazus.id', "desc")
            ->get();
        return view('dysk', ['znaki' => $znaki])->with('typ', 'nakazu')->with('sort', $request->sort);
    }
    public function zakazu(Request $request){
        $znaki=Zakazu::select('zakazus.*', 'users.*')
            ->join('users', 'zakazus.user_id', '=', 'users.id')
            ->orderBy('zakazus.id', "desc")
            ->get();
        return view('dysk', ['znaki' => $znaki])->with('typ', 'zakazu')->with('sort', $request->sort);
    }
    public function informujace(Request $request){
        $znaki=Informujace::select('informujaces.*', 'users.*')
            ->join('users', 'informujaces.user_id', '=', 'users.id')
            ->orderBy('informujaces.id', "desc")
            ->get();
        return view('dysk', ['znaki' => $znaki])->with('typ', 'informujace')->with('sort', $request->sort);
    }
    public function inne(Request $request){
        $znaki=Inne::select('innes.*', 'users.*')
            ->join('users', 'innes.user_id', '=', 'users.id')
            ->orderBy('innes.id', "desc")
            ->get();
        return view('dysk', ['znaki' => $znaki])->with('typ', 'inne')->with('sort', $request->sort);
    }
}

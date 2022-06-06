<?php
namespace App\Http\Controllers;
use App\Models\AsmaulHusna;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;

class AsmaulController extends Controller
{

    public function index()
    {
        $asmaul = AsmaulHusna::orderBy('id', 'ASC')->get();
        $response = [
            'message' => 'List Data Asmaul',
            'data' => $asmaul
        ];
        return response()->json($response, Response::HTTP_OK);
    }


    public function store(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'id' => ['required'],
            'latin' => ['required'],
            'arabic' => ['required'],
            'terjemahan' => ['required'],
            'keterangan' => ['required'],
            'amalan' => ['required'],['max:255']
        ]);
        if ($validate->fails()) {
            return response()->json($validate->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        try {
            $asmaul = AsmaulHusna::create($request->all());
            $response = [
                'message' => 'Data Asmaul Berhasi Ditambahkan',
                'data' => $asmaul
            ];
            return response()->json($response, Response::HTTP_CREATED);
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Data Asmaul gagal disimpan',
                'data' => "Gagal" . $e->errorInfo
            ]);
        }
    }

    public function detailAsmaul($id)
    {
        $asmaul = AsmaulHusna::findOrFail($id);
        $response = [
            'message' => 'Detail Asmaul Husna',
            'data' => $asmaul,
        ];
        return response()->json($response, Response::HTTP_OK);
    }


    // Proses Update Data Asmaul Husna
    public function update(Request $request, $id)
    {
        // Mencari id data asmaul husna seperti data asmaul husna mana yang akan di rubah datanya
        $transaction = AsmaulHusna::findOrFail($id);
        // jika data sudah di temukan tahap selanjutnya validasi terlebih dahulu agar tidak sembarangan memasukan data
        $validate = Validator::make($request->all(),[
            'latin' => ['required'],
            'arabic' => ['required'],
            'terjemahan' => ['required'],
            'keterangan' => ['required'],
            'amalan' => ['required']
        ]);

        // tahap ini akan memunculkan error apabila data tidak sesuai dengan validasi di atas
        if ($validate->fails()) {
            return response()->json($validate->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }


        // setelah data berhasil di validasi maka tahap selanjutnya proses mengupdate data yang akan di masukan ke database
        try {
            $transaction->update($request->all());
            $response = [
                'message' => 'Data Asmaul Husna Berhasi Diubah',
                'data' => $transaction
            ];
            return response()->json($response, Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Data Asmaul Husna gagal disimpan',
                'data' => "Gagal" . $e->errorInfo
            ]);
        }
    }

    public function destroy($id)
    {
        $transaction = AsmaulHusna::findOrFail($id);
        try {
            $transaction->delete();
            $response = [
                'message' => 'Data Asmaul Husna Berhasil Dihapus',
            ];
            return response()->json($response, Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Data Asmaul Husna gagal dihapus',
                'data' => "Gagal" . $e->errorInfo
            ]);
        }
    }

}

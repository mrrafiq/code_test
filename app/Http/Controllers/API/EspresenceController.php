<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Espresence;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EspresenceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $user = User::where('id', Auth::user()->id)->first();
            $espresence = Espresence::where('id_user', Auth::user()->id)->first();
            $out = Espresence::where('id_user', Auth::user()->id)->where('type', 'OUT')->where('created_at', 'like', date_format($espresence->created_at, "Y-m-d").'%')->first();
            // dd($espresence);
            $status_in = "";
            $status_out = "";
            if ($espresence->is_approve == false || $out->is_approve == false) {
                $status_in = "REJECTED";
                $status_out = "REJECTED";
            }else{
                $status_in = "APPROVED";
                $status_out = "APPROVED";
            }
            return response()->json([
                'message' => 'Success get Data',
                'data' => [
                    "id_user" => $espresence->id_user,
                    "nama_user" => $user->nama,
                    "tanggal" => date_format($espresence->created_at, "Y-m-d"),
                    "waktu_masuk" => date_format($espresence->created_at, "H:i:s"),
                    "waktu_pulang" => date_format($out->created_at, "H:i:s"),
                    "status_masuk" => $status_in,
                    "status_pulang" => $status_out,

                ]
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e,
            ], 404);
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeIn(Request $request)
    {
        try {
            $espresence = new Espresence;
            $espresence->id_user = Auth::user()->id;
            $espresence->type = 'IN';
            $espresence->is_approve = 'FALSE';
            $espresence->save();

            $data = Espresence::where('id_user', Auth::user()->id)->get();
            return response()->json([
                'message' => 'Request is succesful',
                'data' => $data
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e,
            ], 400);
        }
    }

    public function storeOut(Request $request)
    {
        try {
            $espresence = new Espresence;
            $espresence->id_user = Auth::user()->id;
            $espresence->type = 'OUT';
            $espresence->is_approve = 'FALSE';
            $espresence->save();

            $data = Espresence::where('id_user', Auth::user()->id)->get();
            return response()->json([
                'message' => 'Request is succesful',
                'data' => $data
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e,
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Espresence  $espresence
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        try {
            $espresence = Espresence::where('id_user', $request->id_user)->get();
            return response()->json([
                'message' => 'Success get Data',
                'data' => $espresence
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e,
            ], 404);
        }

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Espresence  $espresence
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {
            $user = User::where('id', Auth::user()->id)->first();
            if($user->nama == "Supervisor"){
                $request->validate([
                    'npp' => 'required',
                    'is_approve' => 'required',
                    'type' => 'required'
                ]);
                $data = User::where('npp', $request->npp)->first();
                $member = Espresence::where('id_user', $data->id)->where('type', $request->type)->where('is_approve', FALSE)->first();
                if($member != null){
                    $member->is_approve = $request->is_approve;
                    $member->save();
                }

                $updated = Espresence::where('id_user', $data->id)->where('type', $request->type)->first();
                return response()->json([
                    'message' => 'Request is succesful',
                    'data' => $updated
                ], 200);
            }else{
                return response()->json([
                    'message' => 'Forbidden Access',
                ], 403);
            }
        } catch (Exception $e) {
            return response()->json([
                'message' => $e,
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Espresence  $espresence
     * @return \Illuminate\Http\Response
     */
    public function destroy(Espresence $espresence)
    {
        //
    }
}

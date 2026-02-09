<?php

namespace App\Http\Controllers\Api\V1;

use Rules;
use response;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
        /**
     * @OA\Get(
     *     path="/api/v1/getAllUsers",
     *     tags={"Users"},
     *     summary="Liste tous les utilisateurs",
     *     description="Retourne la liste de tous les utilisateurs avec leurs services et départements",
     *     @OA\Response(
     *         response=200,
     *         description="Liste des utilisateurs récupérée avec succès",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="name", type="string"),
     *                 @OA\Property(property="email", type="string"),
     *                 @OA\Property(property="matricule", type="string"),
     *                 @OA\Property(property="services", type="array", @OA\Items(type="object")),
     *                 @OA\Property(property="departments", type="array", @OA\Items(type="object"))
     *             )
     *         )
     *     )
     * )
     */
    public function getAllUsers()
    {
        $users = User::with('services', 'departments')->get();
        return response()->json($users);
    }

    public function register(Request $request){
        $dataUser=$request->validate([
            'name'=>'required|string|max:255',
            'email'=>'required|string|max:50',
            'password'=>'required|string|'.Rules::Password()->min(4)->letters()->symbols(),
        ]);

        $insertData=User::create([
            'name'=>$dataUser['name'],
            'email'=>$dataUser['email'],
            'password'=>Hash::make($dataUser['password'])
        ]);

        return response([
            'code'=> 200,
            'message'=> 'success code',
            'description'=> 'utilisateur cree avec succes',
            'data'=> $insertData
        ]);

    }

    public function login(Request $request){
        $request->validate([
            'name'=>'required|string|max:255',
            'email'=>'required|string|max:50',
            'password'=>'required|string|'.Rules::Password()->min(4)->letters()->symbols(),
        ]);

        if(Auth::attempt(['email'=>$request->email,'password'=>$request->password])){
             return response()->json([
            'code'=>200,
            'message'=>'code success',
            'description'=>'utilisateur connecte avec succes',
        ]);
        }else{
            return response()->json([
                'code'=>400,
                'message'=>'error code',
                'description'=>'Identifiants Invalides'
            ]);
        }

       

        }

        
    
}

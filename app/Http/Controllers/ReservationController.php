<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Exception;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function show(Reservation $reservation) {
        return response()->json($reservation,200);
    }

    public function search(Request $request) {
        $request->validate(['key'=>'string|required']);

        $reservations = Reservation::where('name','like',"%$request->key%")
            ->orWhere('roomnumber','like',"%$request->key%")->get();

        return response()->json($reservations, 200);
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'string|required',
            'roomnumber' => 'string|required',
            'address' => 'string|required',
            'phone' => 'numeric|required',
            'quantity' => 'numeric|required',
        ]);

        try {
            $merchandise = Merchandise::create([
                'name' => $request->name,
                'roomnumber' => $request->roomnumber,
                'address' => $request->address,
                'phone' => $request->phone,
                'quantity' => $request->quantity,
                'user_id' => auth()->user()->id
            ]);
            return response()->json($reservation, 202);
        }catch(Exception $ex) {
            return response()->json([
                'message' => $ex->getMessage()
            ],500);
        }

    }

    public function update(Request $request, Reservation $reservation) {
        try {
            $reservation->update($request->all());
            return response()->json($reservation, 202);
        }catch(Exception $ex) {
            return response()->json(['message'=>$ex->getMessage()], 500);
        }
    }

    public function destroy(Reservation $reservation) {
        $reservation->delete();
        return response()->json(['message'=>'Reservation deleted.'],202);
    }

    public function index() {
        $reservations = Reservation::where('user_id', auth()->user()->id)->orderBy('quantity')->get();
        return response()->json($reservations, 200);
    }
}
<?php

namespace Database\Seeders;

use App\Models\Demand;
use App\Models\Offer;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class OfferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       
                 // Create a new offer
        $offer = new Offer;
        $offer->title = 'Offer 1';
        $offer->description = 'Description for Offer 1';
        $offer->sector = 'IT';
        $offer->experience = '2 years';
        $offer->skills = 'PHP, Laravel';
        $offer->duration = 3;
        $offer->type = 'remote';
        $offer->visibility = 'visible';
        $offer->status = 'status';
        $offer->city = 'Rabat';
        $offer->direction = 'Software Development';
        $offer->save();

        // Create a new demand associated with the offer
        $demand = new demand;
        $demand->offer_id = $offer->id; // associate the demand with the offer
        $demand->user_id = 1; // associate the demand with the offer
        $demand->startDate = Carbon::now()->addDays(rand(1, 365));; // associate the demand with the offer
        $demand->endDate =Carbon::now()->addDays(rand(1, 365));; // associate the demand with the offer
        $demand->save();

        // Create another demand associated with the offer
        $demand2 = new demand;
        $demand2->offer_id = $offer->id; // associate the demand with the offer
        $demand2->user_id = 1; // associate the demand with the offer
        $demand2->startDate = Carbon::now()->addDays(rand(1, 365));; // associate the demand with the offer
        $demand2->endDate =Carbon::now()->addDays(rand(1, 365));; // associate the demand with the offer
        $demand2->save();

    }
}

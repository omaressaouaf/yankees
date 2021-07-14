<?php

namespace App\Providers;

use App\Models\Section;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;
use Spatie\OpeningHours\OpeningHours;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
        View::composer('includes.hero', function ($view) {
            $view->with([
                'header' => Section::where('name', 'header')->first(),
            ]);
        });
        View::composer('includes.about-section', function ($view) {
            $view->with([
                'about' => Section::where('name', 'about')->first(),
                "slides" => [
                    [
                        'image' => '/storage/images/design/sliders/slide1.jpg',
                        'text' => "Personalizer mon sandwich
                        Oui ! Votre Sandwich Topping extra vous préparera sur place le sandwich que vous souhaitez. En réalité, il existe  plusieurs assortiments de sandwiches pouvant être réalisés avec le choix de notre carte et vous pouvez composer votre sandwich avec n'importe quelle combinaison d'ingrédients proposés. Ces assortiments représentent une combinaisons de sandwiches délicieux... et portent tous notre façon de bien faire.
                        concernant la préparation des aliments doivent respecter les normes d'inspection et de fabrication. Toutes nos employers reçoivent des informations sur les procédures adéquates de manipulation des aliments afin de correctement former les membres de leur équipe.
                        La nourriture est fraîchement préparée chaque jour et les températures sont régulièrement contrôlées."
                    ],
                    [
                        'image' => '/storage/images/design/sliders/slide2.jpg',
                        'text' => "Nous sommes une alternative pour les personnes souhaitant un repas nourrissant et rapide pouvant plaire à toute la famille.
                        Yankees est engagé à fournir à ses clients des aliments savoureux, abordables et garantissant une sécurité alimentaire maximale
                        Notre objectif est d'être classé numéro un de la restauration rapide à Casablanca  en continuant à garantir la fraîcheur et le goût savoureux des produits qui constituent notre marque de fabrique."
                    ],
                    [
                        'image' => '/storage/images/design/sliders/slide3.jpg',
                        'text' => "Nous sommes fiers de nous approvisionner en ingrédients incroyables auprès d'éleveurs, d'agriculteurs, de boulangers et de fournisseurs de produits alimentaires qui partagent tous nos valeurs. Nous nous engageons à faire en sorte que TOUTES nos viandes soient exemptes d'antibiotiques et d'hormones.
                        Nos hamburgers sont faits à 100 % de bœuf Angus élevé a la nature, nourri végétarien et vérifié à la source. Notre poulet est une vraie viande blanche qui est fraîche, jamais congelée."
                    ]
                ]
            ]);
        });
        View::composer('includes.hero-meals', function ($view) {
            $nextOpen = OpeningHours::create(config('schedule.openingHours'))->nextOpen(Carbon::now())->translatedFormat('l H:i');
            $view->with([
                'nextOpen' => $nextOpen,
                "forcedClose" => config('schedule.forcedClose')
            ]);
        });
        View::composer('includes.footer', function ($view) {
            $openingHours = OpeningHours::create(config('schedule.openingHours'))->forWeekConsecutiveDays();
            $view->with([
                'openingHours' => $openingHours
            ]);
        });
    }
}

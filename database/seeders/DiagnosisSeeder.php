<?php

namespace Database\Seeders;

use App\Models\Diagnosis;
use Illuminate\Database\Seeder;

class DiagnosisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Diagnosis::insert([
            [
                "name" => "Charbon des inflorescences",
                "description" => "Le charbon des inflorescences est une maladie fongique causée par le pathogène *Ustilago maydis*. Elle se manifeste par la formation de galles charnues, noires et souvent remplies de spores sur les épis, les feuilles, les tiges et parfois d'autres parties de la plante. Ces galles peuvent atteindre une taille considérable, ce qui entraîne des pertes significatives en termes de rendement et de qualité. La maladie est favorisée par des conditions climatiques chaudes et humides, ainsi que par des blessures sur les plantes, qui facilitent l'infection.",
                "pathogene" => "Ustilago maydis",
                "prevention" => "Pour limiter la propagation du charbon des inflorescences : \n1. **Utiliser des variétés résistantes** : Sélectionnez des variétés de maïs ayant une tolérance naturelle au charbon. \n2. **Pratiquer la rotation des cultures** : Alternez les cultures pour éviter l'accumulation des spores dans le sol. \n3. **Contrôler les insectes** : Les insectes peuvent transporter les spores et causer des blessures facilitant l'infection. L'utilisation d'insecticides naturels ou intégrés peut réduire les risques. \n4. **Améliorer les pratiques culturales** : Évitez de blesser les plantes lors des travaux agricoles, car les blessures constituent une porte d'entrée pour le pathogène. \n5. **Maintenir un sol sain** : Un sol bien drainé et enrichi en matière organique peut réduire la vulnérabilité des plantes aux maladies. \n6. **Surveiller les champs** : Inspectez régulièrement les cultures pour détecter les premiers signes de la maladie et agir rapidement pour limiter sa propagation.",
                "image_url" => json_encode([
                    "http://localhost:8000/images/diseases/charbon_mais.png",
                    "http://localhost:8000/images/diseases/charbon_de_mais.jpg",
                ]),
            ],
            [
                "name" => "Rouille du maïs",
                "description" => "La rouille du maïs est une maladie fongique causée par *Puccinia sorghi* ou *Puccinia polysora*. Elle se manifeste par l'apparition de pustules orange à brun rougeâtre sur les feuilles, réduisant leur capacité à effectuer la photosynthèse. Cette réduction entraîne un affaiblissement général des plantes, diminuant le rendement et la qualité des grains. Les conditions chaudes et humides favorisent son développement rapide.",
                "pathogene" => "Puccinia sorghi ou Puccinia polysora",
                "prevention" => "Pour prévenir la rouille du maïs :\n1. **Utiliser des variétés résistantes** : Privilégiez les semences tolérantes aux maladies fongiques. \n2. **Appliquer des fongicides** : Les fongicides spécifiques doivent être utilisés dès les premiers signes pour limiter la propagation.\n3. **Surveiller les champs régulièrement** : Inspectez les cultures pour détecter et traiter rapidement toute apparition de rouille.\n4. **Gérer l'espacement des plantes** : Assurez une bonne aération entre les plants pour limiter l'humidité excessive.",
                "image_url" => json_encode([
                    "http://localhost:8000/images/diseases/rouille_mais.png",
                    "http://localhost:8000/images/diseases/rouille_mais.jpg",
                ]),
            ],
            [
                "name" => "Anthracnose",
                "description" => "L'anthracnose, causée par *Colletotrichum graminicola*, affecte les feuilles, les tiges et les épis de maïs. Elle se caractérise par des lésions sombres sur les feuilles, souvent bordées de jaune, et une pourriture des tiges qui affaiblit les plantes, augmentant leur vulnérabilité à la verse. La maladie est plus fréquente dans les régions avec des conditions chaudes et humides.",
                "pathogene" => "Colletotrichum graminicola",
                "prevention" => "Les mesures préventives contre l'anthracnose incluent :\n1. **Utiliser des variétés résistantes** : Choisissez des semences conçues pour résister à l'anthracnose.\n2. **Éliminer les débris de culture** : Nettoyez les champs après la récolte pour réduire la survie du pathogène.\n3. **Appliquer des fongicides** : Les traitements fongiques doivent être utilisés de manière préventive ou dès les premiers signes de la maladie.\n4. **Améliorer les pratiques culturales** : Favorisez une bonne gestion de l'irrigation et des sols pour limiter le stress des plantes.",
                "image_url" => json_encode([
                    "http://localhost:8000/images/diseases/anthracnose.jpg",
                    "http://localhost:8000/images/diseases/anthranose_mais2.png",
                ]),
            ],
            [
                "name" => "Fusariose de la tige",
                "description" => "La fusariose de la tige, causée par *Fusarium verticillioides*, entraîne la décomposition interne des tiges, les rendant cassantes et sujettes à la verse. Les plantes infectées présentent souvent une décoloration brune à noire à l'intérieur des tiges, ce qui réduit la circulation des nutriments et l'intégrité structurelle.",
                "pathogene" => "Fusarium verticillioides",
                "prevention" => "Pour prévenir la fusariose de la tige :\n1. **Utiliser des variétés résistantes** : Adoptez des semences qui offrent une résistance au *Fusarium*.\n2. **Pratiquer la rotation des cultures** : Alternez les cultures pour réduire l'accumulation du pathogène dans le sol.\n3. **Maintenir un bon équilibre hydrique et nutritionnel** : Un sol bien drainé et enrichi limite le stress des plantes, réduisant leur susceptibilité.\n4. **Éviter les blessures** : Manipulez les plants avec soin pour réduire les risques d'infection.",
                "image_url" => json_encode([
                    "http://localhost:8000/images/diseases/furariose_tige_mais.png",
                ]),
            ],
            [
                "name" =>  "Virus de la striure du maïs",
                "description" =>  "Le virus de la striure du maïs (MSV) provoque des stries jaunes ou blanches parallèles aux nervures des feuilles, accompagnées d'un rabougrissement et d'une déformation des plantes. Transmis par des cicadelles, ce virus peut causer d'importantes pertes de rendement, en particulier dans les régions où les insectes vecteurs prolifèrent.",
                "pathogene" => "Maize Streak Virus (MSV)",
                "prevention" =>  "Les mesures préventives incluent :\n1. **Utiliser des variétés résistantes** : Sélectionnez des semences adaptées pour résister au MSV.\n2. **Contrôler les cicadelles** : Appliquez des insecticides appropriés ou introduisez des prédateurs naturels pour limiter leur population.\n3. **Éviter le maïs en continu** : Pratiquez la rotation des cultures pour briser le cycle de vie du virus et de ses vecteurs.\n4. **Surveiller les champs** : Identifiez et gérez les foyers d'infection rapidement.",
                "image_url" => json_encode ([
                    "http://localhost:8000/images/diseases/virus_striure_mais.png",
                    "http://localhost:8000/images/diseases/virus_striure_mais2.png",
                ])
                ],
            [
                "name" => "Pourriture de la tige",
                "description" => "La pourriture de la tige est causée par divers pathogènes, notamment *Fusarium*, *Colletotrichum*, *Diplodia* et *Gibberella*. Elle se manifeste par des lésions brunâtres ou noires sur les tiges, accompagnées d'une décomposition interne qui fragilise les plantes et provoque leur verse. Cette maladie réduit la capacité des plantes à transporter l'eau et les nutriments.",
                "pathogene" => "Fusarium, Colletotrichum, Diplodia, Gibberella",
                "prevention" =>  "Pour gérer la pourriture de la tige :\n1. **Utiliser des variétés résistantes** : Plantez des variétés adaptées aux conditions locales et résistantes à la pourriture.\n2. **Éliminer les débris de culture** : Nettoyez le champ après la récolte pour limiter les réservoirs de pathogènes.\n3. **Surveiller les champs** : Identifiez les symptômes tôt pour prendre des mesures correctives.\n4. **Maintenir une bonne nutrition** : Assurez un apport équilibré",
                "image_url" => json_encode ([
                    "http://localhost:8000/images/diseases/pourriture_tige_mais.png",
                    "http://localhost:8000/images/diseases/pourriture_tige_mais2.png",
                ])
            ]
            // Ajoutez d'autres maladies ici si nécessaire
        ]);
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: nadege
 * Date: 2019-08-08
 * Time: 15:35
 */

namespace Theme\artisan\fixtures;


use App\Entity\Bloc;
use App\Entity\GroupeBlocs;
use App\Entity\Langue;
use App\Entity\Page;
use App\Entity\SEO;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ArtisanAccueilFixtures extends Fixture
{
    public function load(ObjectManager $manager){
        $date = new \DateTime();

        //Langue par défaut
        $repoLangue = $manager->getRepository(Langue::class);
        $langue = $repoLangue->findOneBy(['defaut' => 1]);

        //Page d'accueil
        $accueil = $langue->getPageAccueil();

        if(!$accueil){
            $seo = new SEO();
            $seo->setUrl('accueil')
                ->setMetaTitre("Accueil")
                ->setMetaDescription("Accueil");
            $manager->persist($seo);

            $accueil = new Page();
            $accueil->setTitre("Accueil")
                ->setTitreMenu("Accueil")
                ->setSEO($seo)
                ->setDateCreation($date)
                ->setDatePublication($date)
                ->setLangue($langue);

            $manager->persist($accueil);

            $langue->setPageAccueil($accueil);
            $manager->persist($langue);
        }

        $blocs = $accueil->getBlocs();
        foreach($blocs as $bloc){
            $accueil->removeBloc($bloc);
        }

        //Édito
        $edito = new Bloc();
        $edito->setType('Texte')
            ->setPage($accueil)
            ->setClass('edito')
            ->setPosition(0)
            ->setContenu([
                'texte' => file_get_contents(getcwd().'/themes/artisan/fixtures/edito.html')
            ]);
        $manager->persist($edito);

        //Bouton découvrir
        $contenuBouton = [
            'lien' => '#',
            'texte' => 'Découvrir',
            'titre' => 'Découvrir'
        ];

        $bouton = new Bloc();
        $bouton->setType('Bouton')
            ->setPage($accueil)
            ->setClass('decouvrir')
            ->setPosition(1)
            ->setContenu($contenuBouton);
        $manager->persist($bouton);

        //Image
        $image = new Bloc();
        $image->setType('Image')
            ->setPage($accueil)
            ->setClass('imageGalet')
            ->setPosition(2)
            ->setContenu([
                'image' => '/theme/img/flamme.png',
                'description' => "Nom de l'entreprise"
            ]);
        $manager->persist($image);

        //Titre documentaire
        $titreDocumentaire = new Bloc();
        $titreDocumentaire->setType('Titre')
            ->setPage($accueil)
            ->setPosition(3)
            ->setContenu([
                'texte' => 'Le documentaire de notre entreprise',
                'balise' => 'h2'
            ]);
        $manager->persist($titreDocumentaire);

        //Vidéo
        $video = new Bloc();
        $video->setType('Video')
            ->setPage($accueil)
            ->setPosition(4)
            ->setContenu([
                'video' => 'https://www.youtube.com/watch?v=IPSRJ0CBqBw'
            ]);
        $manager->persist($video);

        //Titre services
        $titreServices = new Bloc();
        $titreServices->setType('Titre')
            ->setPage($accueil)
            ->setPosition(5)
            ->setContenu([
                'texte' => 'Nos services',
                'balise' => 'h2'
            ]);
        $manager->persist($titreServices);

        //Services
        $texteService = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam imperdiet lacinia velit, eget posuere augue ultricies at. Sed faucibus nibh ut nibh posuere auctor. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam imperdiet lacinia velit, eget posuere augue ultricies at. Sed faucibus nibh ut nibh posuere auctor.';

        $contenuServices = [
            'nbColonnes' => 2,
            'cases' => [
                [
                    'position' => 0,
                    'titre' => 'Nom service',
                    'texte' => $texteService,
                ],
                [
                    'position' => 1,
                    'titre' => 'Nom service',
                    'texte' => $texteService,
                ],
                [
                    'position' => 2,
                    'titre' => 'Nom service',
                    'texte' => $texteService,
                ],
                [
                    'position' => 3,
                    'titre' => 'Nom service',
                    'texte' => $texteService,
                ]
            ]
        ];

        $services = new Bloc();
        $services->setType('Grille')
            ->setPage($accueil)
            ->setPosition(6)
            ->setClass('service')
            ->setContenu($contenuServices);
        $manager->persist($services);

        //Titre prix
        $titrePrix = new Bloc();
        $titrePrix->setType('Titre')
            ->setPage($accueil)
            ->setPosition(7)
            ->setContenu([
                'texte' => 'Nos prix',
                'balise' => 'h2'
            ]);
        $manager->persist($titrePrix);

        //Prix
        $edito = new Bloc();
        $edito->setType('Texte')
            ->setPage($accueil)
            ->setClass('prix')
            ->setPosition(8)
            ->setContenu([
                'texte' => file_get_contents(getcwd().'/themes/artisan/fixtures/prix.html')
            ]);
        $manager->persist($edito);

        //Bouton acheter
        $contenuBoutonAcheter = [
            'lien' => '#',
            'texte' => 'Acheter',
            'titre' => 'Acheter'
        ];

        $boutonAcheter = new Bloc();
        $boutonAcheter->setType('Bouton')
            ->setPage($accueil)
            ->setPosition(9)
            ->setContenu($contenuBoutonAcheter);
        $manager->persist($boutonAcheter);

        //Galerie
        $contenuGalerie = [
            'affichage' => 'liens',
            'images' => [
                [
                    'image' => [
                        'image' => 'theme/img/logo.png',
                        'description' => 'Logo'
                    ],
                    'position' => 0,
                    'lien' => '#',
                ],
                [
                    'image' => [
                        'image' => 'theme/img/logo.png',
                        'description' => 'Logo'
                    ],
                    'position' => 1,
                    'lien' => '#',
                ],
                [
                    'image' => [
                        'image' => 'theme/img/logo.png',
                        'description' => 'Logo'
                    ],
                    'position' => 2,
                    'lien' => '#',
                ],
                [
                    'image' => [
                        'image' => 'theme/img/logo.png',
                        'description' => 'Logo'
                    ],
                    'position' => 3,
                    'lien' => '#',
                ],
                [
                    'image' => [
                        'image' => 'theme/img/logo.png',
                        'description' => 'Logo'
                    ],
                    'position' => 4,
                    'lien' => '#',
                ],
                [
                    'image' => [
                        'image' => 'theme/img/logo.png',
                        'description' => 'Logo'
                    ],
                    'position' => 5,
                    'lien' => '#',
                ],
                [
                    'image' => [
                        'image' => 'theme/img/logo.png',
                        'description' => 'Logo'
                    ],
                    'position' => 6,
                    'lien' => '#',
                ]
            ]
        ];

        $galerie = new Bloc();
        $galerie->setType('Galerie')
            ->setPage($accueil)
            ->setPosition(10)
            ->setContenu($contenuGalerie);
        $manager->persist($galerie);

        //Formulaire
        $groupeBlocsFormulaire = new GroupeBlocs();
        $groupeBlocsFormulaire->setNom('Contact')
            ->setLangue($langue)
            ->setIdentifiant('contact');
        $manager->persist($groupeBlocsFormulaire);

        $contenuTitreFormulaire = [
            'texte' => 'Une question ? Un devis ?<br>Contactez-nous !',
            'balise' => 'h2'
        ];

        $titreFormulaire = new Bloc();
        $titreFormulaire->setType('Titre')
            ->setGroupeBlocs($groupeBlocsFormulaire)
            ->setPosition(0)
            ->setContenu($contenuTitreFormulaire);
        $manager->persist($titreFormulaire);

        $contenuFormulaire = [
            'destinataires' => ['contact@site.fr'],
            'objet' => 'Demande de contact',
            'messageConfirmation' => 'Merci pour votre message',
            'submit' => 'Valider',
            'champs' => [
                [
                    'type' => 'text',
                    'position' => 0,
                    'requis' => ['oui'],
                    'label' => 'Nom'
                ],
                [
                    'type' => 'text',
                    'position' => 1,
                    'requis' => ['oui'],
                    'label' => 'Prénom'
                ],
                [
                    'type' => 'text',
                    'position' => 2,
                    'requis' => ['oui'],
                    'label' => 'E-mail'
                ],
                [
                    'type' => 'textarea',
                    'position' => 3,
                    'requis' => ['oui'],
                    'label' => 'Message'
                ]
            ]
        ];

        $formulaire = new Bloc();
        $formulaire->setType('Formulaire')
            ->setGroupeBlocs($groupeBlocsFormulaire)
            ->setPosition(1)
            ->setContenu($contenuFormulaire);
        $manager->persist($formulaire);
        $manager->flush();

        $blocFormulaire = new Bloc();
        $blocFormulaire->setType('GroupeBlocs')
            ->setPage($accueil)
            ->setPosition(11)
            ->setContenu([
                'groupeBlocs' => $groupeBlocsFormulaire->getId()
            ]);
        $manager->persist($blocFormulaire);

        $manager->flush();
    }
}
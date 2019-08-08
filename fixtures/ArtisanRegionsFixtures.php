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
use App\Entity\Menu;
use App\Entity\MenuPage;
use App\Entity\Page;
use App\Entity\Region;
use App\Entity\SEO;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ArtisanRegionsFixtures extends Fixture
{
    public function load(ObjectManager $manager){
        //Langue par défaut
        $repoLangue = $manager->getRepository(Langue::class);
        $langue = $repoLangue->findOneBy(['defaut' => 1]);

        //Menu principal
        $repoMenu = $manager->getRepository(Menu::class);
        $menu = $repoMenu->findOneBy(['defaut' => 1, 'langue' => $langue]);

        //Régions
        $repoRegions = $manager->getRepository(Region::class);
        $regions = $repoRegions->findAll();
        foreach($regions as $region){
            if($region->getIdentifiant() == 'contenu'){
                $region->setPosition(1);
            }else{
                $manager->remove($region);
            }
        }

        $header = new Region();
        $header->setNom('En-tête')
            ->setIdentifiant('header')
            ->setPosition(0);
        $manager->persist($header);

        $footer = new Region();
        $footer->setNom('Pied de page')
            ->setIdentifiant('footer')
            ->setPosition(2);
        $manager->persist($footer);

        //Header
        $groupeBlocHeader = new GroupeBlocs();
        $groupeBlocHeader->setNom('Header')
            ->setLangue($langue)
            ->setRegion($header)
            ->setIdentifiant('header')
            ->setPosition(0);
        $manager->persist($groupeBlocHeader);

            //Logo
        $blocLogo = new Bloc();
        $blocLogo->setType('LogoSite')
            ->setPosition(0)
            ->setGroupeBlocs($groupeBlocHeader)
            ->setContenu([
                'logo' => [1],
                'nom' => [0]
            ]);
        $manager->persist($blocLogo);

            //Menu
        $blocMenuPrincipal = new Bloc();
        $blocMenuPrincipal->setType('Menu')
            ->setPosition(1)
            ->setGroupeBlocs($groupeBlocHeader)
            ->setContenu([
                'menu' => $menu->getId()
            ]);
        $manager->persist($blocMenuPrincipal);

            //Recherche
        $blocRecherche = new Bloc();
        $blocRecherche->setType('Recherche')
            ->setPosition(2)
            ->setGroupeBlocs($groupeBlocHeader);
        $manager->persist($blocRecherche);

        //Footer
        $groupeBlocFooter = new GroupeBlocs();
        $groupeBlocFooter->setNom('Footer')
            ->setLangue($langue)
            ->setRegion($footer)
            ->setIdentifiant('footer')
            ->setPosition(0);
        $manager->persist($groupeBlocFooter);

            //Logo
        $blocLogoFooter = new Bloc();
        $blocLogoFooter->setType('LogoSite')
            ->setPosition(0)
            ->setGroupeBlocs($groupeBlocFooter)
            ->setContenu([
                'logo' => [1],
                'nom' => [0]
            ]);
        $manager->persist($blocLogoFooter);

            //Réseaux sociaux
        $rs = new Bloc();
        $rs->setType('ReseauxSociaux')
            ->setGroupeBlocs($groupeBlocFooter)
            ->setPosition(1)
            ->setContenu([
                'facebook' => [1],
                'facebookUrl' => '#',
                'instagram' => [1],
                'instagramUrl' => '#',
                'twitter' => [1],
                'twitterUrl' => '#'
            ]);
        $manager->persist($rs);

            //Texte
        $coordonnees = new Bloc();
        $coordonnees->setType('Texte')
            ->setGroupeBlocs($groupeBlocFooter)
            ->setPosition(2)
            ->setContenu([
                'texte' => '<p>7 rue du chemin de Fer<br>67 000 STRASBOURG</p><p>tel. : 03 88 76 78 65<br>mail@mail.fr</p>'
            ]);
        $manager->persist($coordonnees);

            //Menu
        $menuFooter = new Menu();
        $menuFooter->setLangue($langue)
            ->setNom('Menu du pied de page');
        $manager->persist($menuFooter);
        $manager->flush();

        $blocMenuFooter = new Bloc();
        $blocMenuFooter->setType('Menu')
            ->setPosition(3)
            ->setGroupeBlocs($groupeBlocFooter)
            ->setContenu([
                'menu' => $menuFooter->getId()
            ]);
        $manager->persist($blocMenuFooter);

        //Page mentions légales
        $date = new \DateTime();

        $seo = new SEO();
        $seo->setUrl('mentions-legales')
            ->setMetaTitre('Mentions légales')
            ->setMetaDescription('Mentions légales');
        $manager->persist($seo);

        $page = new Page();
        $page->setTitre('Mentions légales')
            ->setTitreMenu('Mentions légales')
            ->setDateCreation($date)
            ->setDatePublication($date)
            ->setLangue($langue)
            ->setSEO($seo);
        $manager->persist($page);

        $menuPage = new MenuPage();
        $menuPage->setPosition(0)
            ->setMenu($menuFooter)
            ->setPage($page);
        $manager->persist($menuPage);

        $manager->flush();
    }
}
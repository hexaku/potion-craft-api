<?php

namespace App\DataFixtures;

use App\Entity\PotionIngredient;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class PotionIngredientFixtures extends Fixture implements DependentFixtureInterface
{
    public const POTION_INGREDIENTS = [
        // Acid potions
        [
            'ingredient' => 'firebell',
            'ingredient_quantity' => 5,
            'potion' => 'weak_acid'
        ],
        [
            'ingredient' => 'terraria',
            'ingredient_quantity' => 5,
            'potion' => 'weak_acid'
        ],
        [
            'ingredient' => 'firebell',
            'ingredient_quantity' => 2,
            'potion' => 'medium_acid'
        ],
        [
            'ingredient' => 'terraria',
            'ingredient_quantity' => 5,
            'potion' => 'medium_acid'
        ],
        [
            'ingredient' => 'red_mushroom',
            'ingredient_quantity' => 2,
            'potion' => 'medium_acid'
        ],
        [
            'ingredient' => 'firebell',
            'ingredient_quantity' => 3,
            'potion' => 'strong_acid'
        ],
        [
            'ingredient' => 'terraria',
            'ingredient_quantity' => 6,
            'potion' => 'strong_acid'
        ]
    ];

    public function load(ObjectManager $manager): void
    {
        foreach(self::POTION_INGREDIENTS as $potionIngredient){
            $newPotionIngredient = (new PotionIngredient())
                ->setIngredient($this->getReference('ingredient_' . $potionIngredient['ingredient']))
                ->setIngredientQuantity($potionIngredient['ingredient_quantity'])
                ->setPotion($this->getReference('potion_' . $potionIngredient['potion']));

            $manager->persist($newPotionIngredient);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            IngredientFixtures::class,
            PotionFixtures::class
        ];
    }
}

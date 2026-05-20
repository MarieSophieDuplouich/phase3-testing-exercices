<?php

namespace App\Tests;

use App\Services\PremiumMemberService;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;


/**
 * Activité 2 : Testez la classe PremiumMemberService
 * Doc des asserts de PHPUnit : https://docs.phpunit.de/en/13.1/assertions.html
 * Cette exercice est un peu plus dur et plus realiste.
 * Il s'agit de tester la classe PremiumMemberService qui contient des méthodes plus complexes que celles de GeometryService.
 * - La méthode generateMemberProfile génère un profil de membre à partir de son nom d'utilisateur, son âge et ses centres d'intérêt. Elle doit respecter plusieurs specifications que vous trouverez dans les commentaires de la méthode.
 * - La méthode applyPromoCode applique une réduction à un montant en fonction d'un code promo. Elle doit respecter plusieurs specifications que vous trouverez dans les commentaires de la méthode.
 * CERTAIN specification non pas été respectées dans l'implémentation de la classe PremiumMemberService, votre travail est de les identifier et de les tester correctement.
 * CERTAIN Test devrons donc échoué et c'est le but c'est la preuve que votre test et bien ecrit car il respecte la spec et pas juste l'implémentation.
 * C'est ce cette façon qu'on l'on évite d'écrire des test biasé.
 */
class PremiumMemberServiceTest extends KernelTestCase
{
    private PremiumMemberService $premiumMemberService;
    protected function setUp(): void
    {
        // Plutot que de faire new PremiumMemberService() on va le récuperer depuis le container de symfony pour être sur d'avoir la même instance 
        // que celle utilisée dans l'application c'est obligatoire pour des services plus réaliste qui inject des Repo ou d'autre Service par exemple.

        self::bootKernel();
        $this->premiumMemberService = static::getContainer()->get(PremiumMemberService::class);
    }
    // Remplissez les test restants :)
    // Bon courage héhé :)

    /**
     * Test la fonction generateMemberProfile pour un cas de SUCCES.
     * - 
     * - assertArrayHasKey
     * - assertStringStartsWith
     * - assertSame : pour comparer deux tableaux associatifs
     * - assertMatchesRegularExpression
     * - Voir la doc pour les autres asserts : https://docs.phpunit.de/en/13.1/assertions.html
     */
    public function testGenerateMemberProfileSuccess(): void
    {
        // sans self::bootKernel , symfony ne démarre pas

        self::bootKernel();
        $this->premiumMemberService = static::getContainer()->get(PremiumMemberService::class);

        $generatemember = $this->premiumMemberService->generateMemberProfile("Billy", 25, ['Coding', 'Gaming', 'Fiesta']);
        $this->assertEquals("Billy", $generatemember['meta']['username'], "Profile généré avec succès");

        // Ajoutez les autres vérifications juste en dessous

        // Vérifie que $generatemember est bien un tableau assertIsArray
        $this->assertIsArray($generatemember, "le profil du emembre doit générer un tableau aassociatif");

        // Vérifie que le tableau contient  la clé 'id' assertArrayHasKey
        $this->assertArrayHasKey('id', $generatemember);

        //vérifie que le tableau commence par "user_" assertStringStartsWith
        $this->assertStringStartsWith("usr_", $generatemember['id']);

        //Vérifie que created_at correspond au format 2026-05-20  assertMatchesRegularExpression
        $this->assertMatchesRegularExpression('/^\d{4}-\d{2}-\d{2}$/', $generatemember['created_at']);
    }



    /**
     * Test la fonction generateMemberProfile pour un cas d'ECHEC lorsque le nom d'utilisateur est vide.
     */
    public function testGenerateMemberProfileEmptyUsername(): void
    {
        // ExpectExeception prepart la levé d'exeption, pour les exeptions on utilise 
        // expect plutot que assert
        // Utilisez cette exemple pour tester les autres expections dans d'autre test.
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Le nom d'utilisateur ne peut pas être vide.");
        $this->premiumMemberService->generateMemberProfile("", 25, ['Coding', 'Gaming']);
    }

    public function testGenerateMemberProfileThrowsExceptionForUnderage(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Le membre doit être majeur.");
        $this->premiumMemberService->generateMemberProfile("Billy", 17, ['Coding', 'Gaming']);
    }

    public function testGenerateMemberProfileThrowsExceptionForEmptyUsername(): void
    {

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Le nom d'utilisateur ne peut pas être vide.");
        $this->premiumMemberService->generateMemberProfile("", 25, ['Coding', 'Gaming']);
    }



    //Regardez  pour la fonction testApplyPromoCodeVip(), la fonction applyPromoCode
    /**
     * Calcule une réduction basée sur un code promo et un montant.
     * Specifications :
     * - Le code promo "VIP20" applique une réduction de 20%
     * - Le code promo "SUMMER50" applique une réduction de 50%
     * - Si le code promo est null ou invalide, aucun rabais n'est appliqué et le montant original est retourné
     * - Tout autre code promo sauf null doit throw une InvalidArgumentException (héhé attention cette specification n'est pas implémentée dans la méthode)
     */
    public function testApplyPromoCodeVip(): void
    {

        $applycodevip = $this->premiumMemberService->applyPromoCode("100", "VIP20");
        $this->assertEquals(80, $applycodevip, "Le code promo VIP20 doit appliquer une réduction de 20%");
    }

    // On y est presque...

    // Regardez pour la fonction testIsEligibleForUpgrade(), la fonction isEligibleForUpgrade()
    /**
     * Vérifie si un membre est éligible à une mise à niveau premium.
     * - Le membre doit avoir au moins 3 centres d'intérêt
     * - Le membre doit être âgé d'au moins 18 ans
     * - Le montant dépensé doit être supérieur ou égal à 100
     */
    public function testIsEligibleForUpgrade(): void
    {
        $iseligibleforupgrade = $this->premiumMemberService->isEligibleForUpgrade(25, ['Coding', 'Gaming', 'Fiesta'], 150);
        $this->assertTrue($iseligibleforupgrade, "Le membre doit être éligible pour la mise à niveau premium");
    }



    public function testApplyPromoCodeSummer50(): void
    {
        $applycodesummer50 = $this->premiumMemberService->applyPromoCode(100, "SUMMER50");
        $this->assertEquals(50, $applycodesummer50, "Le code promo SUMMER50 doit appliquer une réduction de 50%");
    }

    public function testApplyPromoCodeThrowExceptionInvalid(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Le code promo est invalide.");
        $this->premiumMemberService->applyPromoCode(100, "INVALIDCODE");
    }

    public function testApplyPromoCodeNullAmountUnchanged(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Le code promo est null ou invalide.");
        $this->premiumMemberService->applyPromoCode(100, null);
    }

    public function testIsEligibleForUpgradeSuccess(): void
    {
        // Todo ...
    }

    public function testIsEligibleForUpgradeUnderAge(): void
    {
        // Todo ...
    }

    // C'est encore loin ? 8( 

    public function testIsEligibleForUpgradeInsufficientInterests(): void
    {
        // Todo ...
    }

    public function testIsEligibleForUpgradeInsufficientSpent(): void
    {
        // Todo ...
    }

    public function testCalculateLoyaltyPointsStandard(): void
    {
        // Todo ...
    }

    public function testCalculateLoyaltyPointsPremium(): void
    {
        // Todo ...
    }

    public function testCalculateLoyaltyPointsNegativeThrowException(): void
    {
        // Todo ...
    }

    public function testSummarizeSpending(): void
    {
        // Todo ...
    }

    public function testSummarizeSpendingEmptyThrowException(): void
    {
        // Todo ...
    }

    // On a presque fini :)

    public function testRenewSubscription1Month(): void
    {
        // Todo ...
    }

    public function testRenewSubscriptionInvalidDurationThrowException(): void
    {
        // Todo ...
    }

    public function testAnonymizeProfile(): void
    {
        // Todo ...
    }

    public function testAnonymizeProfileInvalidThrowException(): void
    {
        // Todo ...
    }
}
